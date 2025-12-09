<?php

namespace App\Http\Controllers\Admin\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Exception;

class RoleController extends Controller
{
  protected $validation = [
    'nama_jabatan' => 'required',
    'keterangan' => 'required',
    'tipe_user' => 'required|in:Backend User',
  ];

  protected $custom_msg = [
    'nama_jabatan.required' => 'Nama role wajib diisi.',
    'keterangan.required' => 'Keterangan wajib diisi.',
    'tipe_user.required' => 'Tipe user wajib diisi.',
  ];

  /**
   *
   * Initiate controller instance
   *
   */
  function __construct()
  {
    $this->breadcrumbs = [
      [
        'text' => 'Master Data',
        'route' => route('admin.data-master.role.index')
      ],
      [
        'text' => 'Role',
        'route' => route('admin.data-master.role.index')
      ]
    ];
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Inertia::render('Admin/DataMaster/Role/Index', [
      'breadcrumbs' => $this->breadcrumbs
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $this->breadcrumbs[] = [
      'text' => 'Tambah Role',
      'route' => route('admin.data-master.role.create')
    ];
    return Inertia::render('Admin/DataMaster/Role/Create', [
      'breadcrumbs' => $this->breadcrumbs,
      'userAccess' => config('user-access.access', []),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate($this->validation, $this->custom_msg);

    DB::beginTransaction();
    try {
      $role = Role::create($request->all());

      log_activity(
        'Tambah Role ' . $role->nama_jabatan,
        $role
      );

      DB::commit();
      return redirect()->route('admin.data-master.role.index')->with('alertState', 'success')->with('alertMessage', 'Data role telah berhasil ditambahkan.');
    } catch (Exception $e) {
      DB::rollback();
      return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Role  $role
   * @return \Illuminate\Http\Response
   */
  public function edit(Role $role)
  {
    $this->breadcrumbs[] = [
      'text' => 'Ubah Role',
      'route' => route('admin.data-master.role.edit', [$role->slug])
    ];

    return Inertia::render('Admin/DataMaster/Role/Edit', [
      'breadcrumbs' => $this->breadcrumbs,
      'userAccess' => config('user-access.access', []),
      'role' => $role,
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Role  $role
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Role $role)
  {
    $request->validate($this->validation, $this->custom_msg);

    DB::beginTransaction();
    try {
      $role->update($request->all());

      log_activity(
        'Ubah Role ' . $role->nama_jabatan,
        $role
      );

      DB::commit();
      return redirect()->route('admin.data-master.role.index')->with('alertState', 'success')->with('alertMessage', 'Data role telah berhasil diubah.');
    } catch (Exception $e) {
      DB::rollback();
      return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Role  $role
   * @return \Illuminate\Http\Response
   */
  public function destroy(Role $role)
  {
    if (count($role->user)) {
      return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', 'Gagal menghapus, sudah terdapat data us dengan role ini.');
    }

    DB::beginTransaction();
    try {

      $role->delete();

      log_activity(
        'Hapus Role ' . $role->nama_jabatan,
        $role
      );

      DB::commit();
      return redirect()->route('admin.data-master.role.index')->with('alertState', 'success')->with('alertMessage', 'Data role telah berhasil dihapus.');
    } catch (Exception $e) {
      DB::rollback();
      return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
    }
  }

  /**
   *
   * Generate data for datatables
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function table(Request $request)
  {
    $data = Role::query();

    $data = $data->orderBy('created_at', 'DESC')->filter($request->all())->paginateFilter();

    return response()->json($data);
  }
}
