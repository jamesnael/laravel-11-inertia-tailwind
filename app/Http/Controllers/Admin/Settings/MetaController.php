<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Meta;
use App\Models\MetaTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class MetaController extends Controller
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
                'text' => 'Master Data',
                'route' => route('admin.settings.meta.index')
            ],
            [
                'text' => 'Meta',
                'route' => route('admin.settings.meta.index')
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
        return Inertia::render('Admin/Settings/Meta/Index', [
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    public function create()
    {
        $this->breadcrumbs[] = [
            'text'  => 'Create Meta',
            'route' => route('admin.settings.meta.create')
        ];
        return Inertia::render('Admin/Settings/Meta/Create', [
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }

    public function edit(MetaTag $meta)
    {
        $this->breadcrumbs[] = [
            'text'  => 'Edit Meta',
            'route' => route('admin.settings.meta.edit', [$meta->slug])
        ];
        return Inertia::render('Admin/Settings/Meta/Edit', [
            'breadcrumbs' => $this->breadcrumbs,
            'meta'         => $meta
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validationRules(), [
            'name.required' => 'The meta name field is required',
        ]);

        DB::beginTransaction();
        try {
            $meta = MetaTag::create($request->except(['image']));

            $meta->save();

            log_activity(
                'Create Meta ' . $meta->name,
                $meta
            );

            DB::commit();
            return redirect()->route('admin.settings.meta.index')->with('alertState', 'success')->with('alertMessage', 'Meta successfully added.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    public function update(Request $request, MetaTag $meta)
    {
        $request->validate($this->validationRules($meta), [
            'name.required' => 'The meta name field is required',
        ]);

        DB::beginTransaction();
        try {
            $meta->update($request->except(['image']));

            $meta->save();

            $old = collect([
                'old' => $meta->getOriginal()
            ]);

            log_activity(
                'Edit Meta ' . $meta->name,
                $meta,
                $old
            );

            DB::commit();
            return redirect()->route('admin.settings.meta.index')->with('alertState', 'success')->with('alertMessage', 'Meta successfully updated.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    public function destroy(MetaTag $meta)
    {
        DB::beginTransaction();
        try {
            $meta->delete();

            log_activity(
                'Delete Meta ' . $meta->name,
                $meta
            );

            DB::commit();
            return redirect()->route('admin.settings.meta.index')->with('alertState', 'success')->with('alertMessage', 'Meta successfully deleted.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    public function table(Request $request)
    {
        return response()->json(MetaTag::orderBy('created_at', 'DESC')->filter($request->all())->paginateFilter());
    }

    public function validationRules($meta = null)
    {
        return [
            'page_name'        => 'required',
            'title' => 'required',
            'description'       => 'required',
        ];
    }
}
