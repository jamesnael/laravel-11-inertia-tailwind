<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Controller;
use App\Models\AboutObjectiveWhoWeAre;
use App\Models\AboutRKCMPD;
use App\Models\HomeAbout;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class HomeAboutController extends Controller
{
    /**
     *
     * Initiate controller instance
     *
     */
    function __construct()
    {
        $this->breadcrumbs = [
            [
                'text' => 'Home',
                'route' => route('admin.homepage.home-about.index')
            ],
            [
                'text' => 'Home About',
                'route' => route('admin.homepage.home-about.index')
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
        $homeabout = HomeAbout::find(1);
        return Inertia::render('Admin/Homepage/About/Index', [
            'breadcrumbs' => $this->breadcrumbs,
            'homeabout' => $homeabout
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AboutRKCMPD $rkcmpd
     * @return \Illuminate\Http\Response
     */
    public function edit(HomeAbout $home_about)
    {
        $this->breadcrumbs[] = [
            'text' => 'Edit Home About',
            'route' => route('admin.homepage.home-about.edit', [$home_about->id])
        ];
        return Inertia::render('Admin/Homepage/About/Edit', [
            'breadcrumbs' => $this->breadcrumbs,
            'homeabout' => $home_about,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AboutRKCMPD  $rkcmpd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomeAbout $home_about)
    {
        $request->validate($this->validationRules($home_about));

        DB::beginTransaction();
        try {
            $home_about->update($request->all());

            $home_about->save();

            log_activity(
                'Edit Data Home About ' . $home_about->id,
                $home_about
            );

            DB::commit();
            return redirect()->route('admin.homepage.home-about.index')->with('alertState', 'success')->with('alertMessage', 'Data Home About successfully updated.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    /**
     *
     * Validation Rules for Store/Update Data
     *
     */
    public function validationRules($home_about = null)
    {
        return [
            'left_text'=>'required',
            'right_text'=>'required',
        ];
 
    }
}
