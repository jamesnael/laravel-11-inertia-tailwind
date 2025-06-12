<?php
namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Controller;
use App\Models\PartnerLogo;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class SupportedByController extends Controller
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
                'text' => 'Supported By',
                'route' => route('admin.homepage.supported-by.index')
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
        return Inertia::render('Admin/Homepage/SupportedBy/Index', [
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    public function create()
    {
        $this->breadcrumbs[] = [
            'text'  => 'Create Supported By',
            'route' => route('admin.homepage.supported-by.create')
        ];

        return Inertia::render('Admin/Homepage/SupportedBy/Create', [
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }

    public function edit(PartnerLogo $supported_by)
    {
        $this->breadcrumbs[] = [
            'text'  => 'Edit Supported By',
            'route' => route('admin.homepage.supported-by.edit', [$supported_by->slug])
        ];

        return Inertia::render('Admin/Homepage/SupportedBy/Edit', [
            'breadcrumbs'   => $this->breadcrumbs,
            'supported_by'  => $supported_by
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validationRules(), [
            'title.required' => 'The Supported By title field is required',
            'image.required' => 'The Supported By image field is required',
        ]);

        DB::beginTransaction();
        try {
            $request->merge([
                'tipe' => 'supported_by'
            ]);
            
            $supported_by = PartnerLogo::create($request->except(['image']));

            if ($request->hasFile('image')) {
                $file_name = $supported_by->slug . '-' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('partner_logo/image', $request->file('image'), $file_name);
                $supported_by->image = $path;
            }

            $supported_by->save();

            log_activity(
                'Create Supported By ' . $supported_by->title,
                $supported_by
            );

            DB::commit();
            return redirect()->route('admin.homepage.supported-by.index')->with('alertState', 'success')->with('alertMessage', 'Supported By successfully added.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    public function update(Request $request, PartnerLogo $supported_by)
    {
        $request->validate($this->validationRules($supported_by), [
            'title.required' => 'The Supported By title field is required',
        ]);

        DB::beginTransaction();
        try {
            $supported_by->update($request->except(['image']));

            if ($request->hasFile('image')) {
                $file_name = $supported_by->slug . '-' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('partner_logo/image', $request->file('image'), $file_name);
                $supported_by->image = $path;
            }

            $supported_by->save();

            $old = collect([
                'old' => $supported_by->getOriginal()
            ]);

            log_activity(
                'Edit Supported By ' . $supported_by->title,
                $supported_by,
                $old
            );

            DB::commit();
            return redirect()->route('admin.homepage.supported-by.index')->with('alertState', 'success')->with('alertMessage', 'Supported By successfully updated.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    public function destroy(PartnerLogo $supported_by)
    {
        DB::beginTransaction();
        try {
            $supported_by->delete();

            log_activity(
                'Delete PartnerLogo ' . $supported_by->title,
                $supported_by
            );

            DB::commit();
            return redirect()->route('admin.homepage.supported-by.index')->with('alertState', 'success')->with('alertMessage', 'Supported By successfully deleted.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    public function table(Request $request)
    {
        return response()->json(PartnerLogo::where('tipe','supported_by')->orderBy('created_at', 'DESC')->filter($request->all())->paginateFilter());
    }

    public function validationRules($supported_by = null)
    {
        if ($supported_by) {
            return [
                'title'     => 'required',
                'image'     => 'nullable',
                'status'    => 'required'
            ];
        }

        return [
            'title'     => 'required',
            'image'     => 'required',
            'status'    => 'required'
        ];
    }
}
