<?php

namespace App\Http\Controllers\Admin\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
  /**
   *
   * Initiate controller instance
   *
   */
  protected $custom_msg = [
    'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
    'id_jabatan.required' => 'Role wajib diisi.',
    'username.required' => 'Username wajib diisi.',
    'username.unique' => 'Username sudah digunakan.',
    'password.required' => 'Password wajib diisi.',
    'password.min' => 'Password minimal :min karakter.',
    'password.max' => 'Password maksimal :max karakter.',
    'password.confirmed' => 'Konfirmasi password tidak cocok.',
    'nomor_hp.required' => 'Nomor HP wajib diisi.',
    'email.required' => 'Alamat email wajib diisi.',
    'email.email' => 'Format alamat email salah.',
    'email.unique' => 'Alamat email sudah digunakan.',
    'status.required' => 'Status wajib diisi.',
  ];

  function __construct()
  {
    $this->breadcrumbs = [
      [
        'text' => 'Master Data',
        'route' => route('admin.data-master.user.index')
      ],
      [
        'text' => 'User',
        'route' => route('admin.data-master.user.index')
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
    return Inertia::render('Admin/DataMaster/User/Index', [
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
      'text'  => 'Tambah User',
      'route' => route('admin.data-master.user.create')
    ];

    return Inertia::render('Admin/DataMaster/User/Create', [
      'breadcrumbs' => $this->breadcrumbs,
      'role'        => Role::select('id AS value', 'nama_jabatan AS label', 'tipe_user AS tipe_user')->get(),
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
    $request->validate($this->validationRules(), $this->custom_msg);

    DB::beginTransaction();
    try {
      $request->merge(['password' => Hash::make($request->password)]);
      $user = User::create($request->except(['password_confirmation', 'ektp']));
      if ($request->hasFile('ektp')) {
        $file_name = $user->slug . '-' . uniqid() . '.' . $request->file('ektp')->getClientOriginalExtension();
        $path = Storage::disk('public')->putFileAs('user/ektp', $request->file('ektp'), $file_name);
        $user->ektp_path = $path;
        $user->save();
      }

      log_activity(
        'Tambah User ' . $user->nama_lengkap,
        $user
      );

      DB::commit();
      return redirect()->route('admin.data-master.user.index')->with('alertState', 'success')->with('alertMessage', 'Data User telah berhasil ditambahkan.');
    } catch (Exception $e) {
      DB::rollback();
      return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function edit(User $user)
  {
    $this->breadcrumbs[] = [
      'text' => 'Ubah User',
      'route' => route('admin.data-master.user.edit', [$user->slug])
    ];

    return Inertia::render('Admin/DataMaster/User/Edit', [
      'breadcrumbs' => $this->breadcrumbs,
      'role'        => Role::select('id AS value', 'nama_jabatan AS label', 'tipe_user AS tipe_user')->get(),
      'user'        => $user,
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, User $user)
  {
    $request->validate($this->validationRules($user), $this->custom_msg);

    if ($request->status == 0 && $user->transactions()->exists()) {
      return redirect()
      ->back()
      ->withInput()
      ->with('alertState', 'error')
      ->with('alertMessage', "User {$user->nama_lengkap} tidak bisa dinonaktifkan karena sudah memiliki data transaksi.");
    }

    DB::beginTransaction();
    try {
      $user->update($request->except(['password', 'password_confirmation', 'ektp']));
      if ($request->hasFile('ektp')) {
        $file_name = $user->slug . '-' . uniqid() . '.' . $request->file('ektp')->getClientOriginalExtension();
        $path = Storage::disk('public')->putFileAs('user/ektp', $request->file('ektp'), $file_name);
        $user->ektp_path = $path;
      }
      if ($request->password) {
        $user->password = Hash::make($request->password);
      }
      $user->save();

      log_activity(
        'Ubah User ' . $user->nama_lengkap,
        $user
      );

      DB::commit();
      return redirect()->route('admin.data-master.user.index')->with('alertState', 'success')->with('alertMessage', 'Data User telah berhasil diubah.');
    } catch (Exception $e) {
      DB::rollback();
      return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $user)
  {
    if ($user->transactions()->exists()) {
      return redirect()
      ->back()
      ->withInput()
      ->with('alertState', 'error')
      ->with('alertMessage', "User {$user->nama_lengkap} tidak bisa dihapus karena sudah memiliki data transaksi.");
    }

    DB::beginTransaction();
    try {
      $user->delete();

      log_activity(
        'Hapus User ' . $user->nama_lengkap,
        $user
      );

      DB::commit();
      return redirect()->route('admin.data-master.user.index')->with('alertState', 'success')->with('alertMessage', 'Data User telah berhasil dihapus.');
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
    $data = User::query();

    $data = $data->orderBy('created_at', 'DESC')->filter($request->all())->paginateFilter();
    $data->load('role');

    return response()->json($data);
  }

  public function role(Request $request)
  {
    $data = Role::select('id AS value', 'nama_jabatan AS label')->get();
    return response()->json($data);
  }

  /**
   *
   * Validation Rules for Store/Update Data
   *
   */
  public function validationRules($user = null)
  {
    return [
      'nama_lengkap' => 'required',
      'nomor_hp' => 'required',
      'username' => [
        'required',
        'string',
        'alpha_dash',
        'max:20',
        Rule::unique('\App\Models\User', 'username')->ignore($user)
      ],
      'email' => [
        'required',
        'email',
        Rule::unique('\App\Models\User', 'email')->ignore($user)
      ],
      'password' => [
        Rule::requiredIf(function () use ($user) {
          return $user == null;
        }),
        'nullable',
        'string',
        'min:8',
        'max:16',
        'confirmed',
      ],
      'password_confirmation' => 'required_with:password',
      'id_jabatan' => 'required|exists:App\Models\Role,id',
      'status' => 'required|boolean',
    ];
  }
}
