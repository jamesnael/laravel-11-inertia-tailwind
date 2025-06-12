<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Controller;
use App\Models\SlidingBanner;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class SlidingBannerController extends Controller
{
    function __construct()
    {
        $this->breadcrumbs = [
            [
                'text' => 'Homepage',
                'route' => route('admin.homepage.sliding-banner.index')
            ],
            [
                'text' => 'Sliding Banner',
                'route' => route('admin.homepage.sliding-banner.index')
            ]
        ];
    }

    public function index()
    {
        return Inertia::render('Admin/Homepage/SlidingBanner/Index', [
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    public function create()
    {
        $this->breadcrumbs[] = [
            'text'  => 'Create Sliding Banner',
            'route' => route('admin.homepage.sliding-banner.create')
        ];

        return Inertia::render('Admin/Homepage/SlidingBanner/Create', [
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validationRules(), [
            'tipe.required' => 'The type field is required'
        ]);

        // check main banner
        if ($request->tipe == 'main_banner' && $request->status == 1) {
            $publishedMainBanner = SlidingBanner::where([
                'status' => true,
                'tipe'   => 'main_banner'
            ])
            ->count();

            if ($publishedMainBanner != 0) {
                return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', 'Published Main Banner already exist!');
            }
        }

        DB::beginTransaction();
        try {
            $banner = SlidingBanner::create($request->except(['desktop_banner', 'mobile_banner', 'status']));

            // check published banner
            $publishedBanners = SlidingBanner::where([
                'status' => true,
            ])
            ->where('id', '!=', $banner->id)
            ->count();

            if ($publishedBanners == 4 && $request->status == 1) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', 'Published banners already reached the maximum limit of 4!');
            }

            $banner->status = $request->status;

            if ($request->hasFile('desktop_banner')) {
                $file_name = $banner->slug . '-' . uniqid() . '.' . $request->file('desktop_banner')->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('sliding_banner/desktop_banner', $request->file('desktop_banner'), $file_name);
                $banner->desktop_banner = $path;
            }

            if ($request->hasFile('mobile_banner')) {
                $file_name = $banner->slug . '-' . uniqid() . '.' . $request->file('mobile_banner')->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('sliding_banner/mobile_banner', $request->file('mobile_banner'), $file_name);
                $banner->mobile_banner = $path;
            }

            // get latest position
            if ($banner->tipe == 'secondary_banner') {
                $latestSecondary = SlidingBanner::where([
                    'tipe' => 'secondary_banner',
                    'status' => 1
                ])
                ->orderBy('position', 'desc')
                ->limit(1)
                ->first();

                $banner->position = $latestSecondary ?$latestSecondary->position + 1 : 1;
            }

            $banner->save();

            log_activity(
                'Create Sliding Banner ' . $banner->title,
                $banner
            );

            DB::commit();
            return redirect()->route('admin.homepage.sliding-banner.index')->with('alertState', 'success')->with('alertMessage', 'Banner successfully added.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    public function edit(SlidingBanner $banner)
    {
        $this->breadcrumbs[] = [
            'text' => 'Edit Sliding Banner',
            'route' => route('admin.homepage.sliding-banner.edit', [$banner->slug])
        ];

        return Inertia::render('Admin/Homepage/SlidingBanner/Edit', [
            'breadcrumbs' => $this->breadcrumbs,
            'banner'      => $banner
        ]);
    }

    public function update(Request $request, SlidingBanner $banner)
    {
        $request->validate($this->validationRules($banner), [
            'tipe.required' => 'The type field is required'
        ]);

        if ($request->tipe == 'main_banner') {
            $publishedMainBanner = SlidingBanner::where([
                'status' => true,
                'tipe'   => 'main_banner'
            ])
            ->where('id', '!=', $banner->id)
            ->count();

            if ($publishedMainBanner != 0 && $request->status == 1) {
                return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', 'Published Main Banner already exist!');
            }
        }

        DB::beginTransaction();
        try {
            $banner->update($request->except(['desktop_banner', 'mobile_banner', 'status']));

            // check published banner
            $publishedBanners = SlidingBanner::where([
                'status' => true,
            ])
            ->where('id', '!=', $banner->id)
            ->count();

            if ($publishedBanners == 4 && $request->status == 1) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', 'Published banners already reached the maximum limit of 4!');
            }

            $banner->status = $request->status;

            if ($request->hasFile('desktop_banner')) {
                $file_name = $banner->slug . '-' . uniqid() . '.' . $request->file('desktop_banner')->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('sliding_banner/desktop_banner', $request->file('desktop_banner'), $file_name);
                $banner->desktop_banner = $path;
            }

            if ($request->hasFile('mobile_banner')) {
                $file_name = $banner->slug . '-' . uniqid() . '.' . $request->file('mobile_banner')->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('sliding_banner/mobile_banner', $request->file('mobile_banner'), $file_name);
                $banner->mobile_banner = $path;
            }

            $banner->save();

            log_activity(
                'Edit Sliding Banner ' . $banner->page_name,
                $banner
            );

            DB::commit();
            return redirect()->route('admin.homepage.sliding-banner.index')->with('alertState', 'success')->with('alertMessage', 'Banner successfully edited.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    public function destroy(SlidingBanner $banner)
    {
        DB::beginTransaction();
        try {
            $banner->delete();

            log_activity(
                'Delete Sliding Banner ' . $banner->title,
                $banner
            );

            DB::commit();
            return redirect()->route('admin.homepage.sliding-banner.index')->with('alertState', 'success')->with('alertMessage', 'Banner successfully deleted.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    public function table(Request $request)
    {
        return response()->json(SlidingBanner::orderBy('created_at', 'DESC')->filter($request->all())->paginateFilter());
    }

    public function validationRules($banner = null)
    {
        if ($banner) {
            return [
                'title'          => 'required',
                'subtitle'       => 'required',
                'button_text'    => 'nullable',
                'button_link'    => 'nullable',
                'desktop_banner' => 'nullable|mimes:jpg,png,mp4|max:5120',
                'mobile_banner'  => 'nullable|mimes:jpg,png,mp4|max:5120',
                'tipe'           => 'required',
                'status'         => 'required',
            ];
        }

        return [
            'title'          => 'required',
            'subtitle'       => 'required',
            'button_text'    => 'nullable',
            'button_link'    => 'nullable',
            'desktop_banner' => 'required|mimes:jpg,png,mp4|max:5120',
            'mobile_banner'  => 'required|mimes:jpg,png,mp4|max:5120',
            'tipe'           => 'required',
            'status'         => 'required',
        ];
    }

    // Position
    public function position()
    {
        $this->breadcrumbs[] = [
            'text' => 'Change Position Secondary Sliding Banner',
            'route' => route('admin.homepage.sliding-banner.position')
        ];

        $data = SlidingBanner::where([
            'tipe'   => 'secondary_banner',
            'status' => true,
        ])
        ->orderBy('position', 'ASC')
        ->get();

        $data = collect($data)->transform(function($item){
            $item->name = $item->title;
            $item->position = $item->position;
            $item->id = $item->id;

            return $item->only(['name','position','id']);
        });

        return Inertia::render('Admin/Homepage/SlidingBanner/Position', [
            'breadcrumbs' => $this->breadcrumbs,
            'data'        => $data
        ]);
    }

    public function store_position(Request $request)
    {
        DB::beginTransaction();
        try {
            foreach ($request->list as $key => $value) {
                $data = SlidingBanner::find($value['id']);
                $data->position =  $key + 2;
                $data->save();
            }
    
            log_activity(
                'Change Position Secondary Sliding Banner', []
            );

            DB::commit();
            return redirect()->route('admin.homepage.sliding-banner.index')->with('alertState', 'success')->with('alertMessage', 'Secondary sliding banner position successfully changed.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }
}
