<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Exception;

class JabatanController extends Controller
{
    protected $validation = [
        'nama_jabatan' => 'required',
        'keterangan' => 'required',
        'tipe_user' => 'required|in:Backend User,Supervisor,Sales,Surveyor,Kolektor,Manager Pemasaran,Manager Kolektor,Demo Broker',
    ];

    protected $custom_msg = [
        'nama_jabatan.required' => 'The Group ID field is required.',
        'keterangan.required' => 'The Description field is required.',
        'tipe_user.required' => 'The Tipe User field is required.',
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
                'route' => route('admin.settings.jabatan.index')
            ],
            [
                'text' => 'Group User',
                'route' => route('admin.settings.jabatan.index')
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
        return Inertia::render('Admin/Settings/Jabatan/Index', [
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
            'text' => 'Create Group User',
            'route' => route('admin.settings.jabatan.create')
        ];
        return Inertia::render('Admin/Settings/Jabatan/Create', [
            'breadcrumbs' => $this->breadcrumbs,
            'userAccess' => config('user-access.access', [])
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
        $request->validate($this->validation,$this->custom_msg);

        DB::beginTransaction();
        try {
            $jabatan = Jabatan::create($request->all());

            log_activity(
                'Create Group User ' . $jabatan->nama_jabatan,
                $jabatan
            );

            DB::commit();
            return redirect()->route('admin.settings.jabatan.index')->with('alertState', 'success')->with('alertMessage', 'Jabatan successfully added.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Jabatan $jabatan)
    {
        $this->breadcrumbs[] = [
            'text' => 'Edit Group User',
            'route' => route('admin.settings.jabatan.edit', [$jabatan->slug])
        ];

        return Inertia::render('Admin/Settings/Jabatan/Edit', [
            'breadcrumbs' => $this->breadcrumbs,
            'userAccess' => config('user-access.access', []),
            'jabatan' => $jabatan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate($this->validation,$this->custom_msg);

        DB::beginTransaction();
        try {
            $jabatan->update($request->all());

            log_activity(
                'Edit Group User ' . $jabatan->nama_jabatan,
                $jabatan
            );

            DB::commit();
            return redirect()->route('admin.settings.jabatan.index')->with('alertState', 'success')->with('alertMessage', 'Data Jabatan successfully updated.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jabatan $jabatan)
    {
        DB::beginTransaction();
        try {
            $jabatan->delete();

            log_activity(
                'Delete Group User ' . $jabatan->nama_jabatan,
                $jabatan
            );

            DB::commit();
            return redirect()->route('admin.settings.jabatan.index')->with('alertState', 'success')->with('alertMessage', 'Jabatan successfully deleted.');
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
        return response()->json(Jabatan::orderBy('created_at', 'DESC')->filter($request->all())->paginateFilter());
    }
}
