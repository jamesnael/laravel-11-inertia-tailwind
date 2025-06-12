<?php

namespace App\Http\Controllers\Admin\AboutUs;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Banner;
use App\Models\Category;
use App\Models\History;
use App\Models\ListCountry;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class HistoryController extends Controller
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
                'text' => 'About Us',
                'route' => route('admin.about-us.history.index')
            ],
            [
                'text' => 'History',
                'route' => route('admin.about-us.history.index')
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
        return Inertia::render('Admin/AboutUs/History/Index', [
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    public function create()
    {
        $this->breadcrumbs[] = [
            'text' => 'Create History',
            'route' => route('admin.about-us.history.create')
        ];
        return Inertia::render('Admin/AboutUs/History/Create', [
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validationRules());

        DB::beginTransaction();
        try {
            
            if ($request->hasFile('images')) {
                $file_name = $request->year . '-' . uniqid() . '.' . $request->file('images')->getClientOriginalExtension();
                $path_image = Storage::disk('public')->putFileAs('history/image', $request->file('images'), $file_name);
            }

            $request->merge([
                'image' => $path_image
            ]);

            $history = History::create($request->all());

            log_activity(
                'Create History ' . $history->year,
                $history
            );

            DB::commit();
            return redirect()->route('admin.about-us.history.index')->with('alertState', 'success')->with('alertMessage', 'History successfully added.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    public function edit(History $history)
    {
        $this->breadcrumbs[] = [
            'text' => 'Edit History',
            'route' => route('admin.about-us.history.edit', [$history->slug])
        ];
        return Inertia::render('Admin/AboutUs/History/Edit', [
            'breadcrumbs' => $this->breadcrumbs,
            'history' => $history,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, History $history)
    {
        $request->validate($this->validationRules($history));

        DB::beginTransaction();
        try {
            $history->update($request->except(['image']));

            if ($request->hasFile('images')) {
                $file_name = $request->nama . '-' . uniqid() . '.' . $request->file('images')->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('history/image', $request->file('images'), $file_name);
                $history->image = $path;
            }

            $history->save();

            log_activity(
                'Edit History ' . $history->year,
                $history
            );

            DB::commit();
            return redirect()->route('admin.about-us.history.index')->with('alertState', 'success')->with('alertMessage', 'Data History successfully updated.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(History $history)
    {
        DB::beginTransaction();
        try {
            $history->delete();

            log_activity(
                'Delete History ' . $history->page_name,
                $history
            );

            DB::commit();
            return redirect()->route('admin.about-us.history.index')->with('alertState', 'success')->with('alertMessage', 'History successfully deleted.');
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
        return response()->json(History::orderBy('created_at', 'DESC')->filter($request->all())->paginateFilter());
    }

    /**
     *
     * Validation Rules for Store/Update Data
     *
     */
    public function validationRules($history = null)
    {
        if($history) {
            return [
                'year'=>'required|numeric',
                'description'=>'required',
                'image_source'=>'required',
            ];
        } else {
            return [
                'year'=>'required|numeric',
                'description'=>'required',
                'images'=>'required',
                'image_source'=>'required',
            ];
        }


    }
 
}
