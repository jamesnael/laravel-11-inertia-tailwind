<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper\FlexyPageHelperController;
use App\Mail\AdminDeletedProductNotificationMail;
use App\Mail\AdminProductNotificationMail;
use App\Mail\AdminUpdatedProductNotificationMail;
use App\Mail\UserApprovedProductNotificationMail;
use App\Mail\UserDeletedProductNotificationMail;
use App\Mail\UserRejectedProductNotificationMail;
use App\Mail\UserUnpublishedProductNotificationMail;
use App\Mail\UserUpdatedProductNotificationMail;
use App\Models\FlexyPage;
use App\Models\Karyawan;
use App\Models\Kategori;
use App\Models\ListCountry;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCompany;
use App\Models\ProductCountry;
use App\Models\ProductPhoto;
use App\Models\ProductRelatedFile;
use App\Models\ProductSubCategory;
use App\Models\SubKategori;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    function __construct()
    {
        $this->breadcrumbs = [
            [
                'text' => 'Dashboard',
                'route' => route('user.product.index')
            ],
            [
                'text' => 'Product',
                'route' => route('user.product.index')
            ]
        ];
    }

    public function index()
    {
        return Inertia::render('User/Product/Index', [
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    public function create()
    {
        $this->breadcrumbs[] = [
            'text'  => 'Create Product',
            'route' => route('user.product.create')
        ];

        if (\Auth::user()->jabatan->is_admin != 1) {
            $company = ProductCompany::whereHas('user',function($item) {
                $item->where('status',true);
                $item->where('approval_status','Verified');

                return $item;
            })->where('user_id', \Auth::user()->id)->select('id as value', 'title as label')->get();
        } else {
            $company = ProductCompany::whereHas('user',function($item) {
                $item->where('status',true);
                $item->where('approval_status','Verified');
                
                return $item;
            })->select('id as value', 'title as label')->get();
        }

        return Inertia::render('User/Product/Create', [
            'breadcrumbs'    => $this->breadcrumbs,
            'categories'     => Kategori::select('id as value', 'nama as label')->get(),
            'sub_categories' => SubKategori::select('id as value', 'nama as label', 'kategori_id')->get(),
            'countryOptions'  => ListCountry::select('id as value', 'country as label')->get(),
            'companyOptions' => $company
        ]);
    }

    public function store(Request $request)
    {
        if ($request->media) {
            foreach ($request->media as $value) {
                if ($value['tipe'] == 'Photo') {
                    $image = getimagesize($value['image']);

                    $width = $image[0];
                    $height = $image[1];

                    if($width < 1024) {
                        return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', 'Media image width cannot under 1024');
                    }

                    if($height < 536) {
                        return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', 'Media image height cannot under 536');
                    }
                }
            }
        }

        $request->validate($this->validationRules(), [
            'category_id.required' => "The category field is required",
            'country_id.required'  => "The country field is required",
        ]);

        $request->merge([
            'is_responsible' => false,
            'is_agree'      => false,
            'approval_status' => 'Waiting Approval',
            'status'          => 'Unpublished'
        ]);

        DB::beginTransaction();
        try {
            $product = Product::create($request->except(['is_admin_approved', 'thumbnail_image']));

            if ($request->hasFile('thumbnail_image')) {
                $file_name                = $product->slug . '-' . uniqid() . '.' . $request->file('thumbnail_image')->getClientOriginalExtension();
                $path                     = Storage::disk('public')->putFileAs('private_sector/thumbnail_image', $request->file('thumbnail_image'), $file_name);
                $product->thumbnail_image = $path;
            }

            $product->save();

            foreach ($request->category_id as $value) {
                $insert = [
                    'product_id' => $product->id,
                    'category_id'      => $value['value'],
                ];

                ProductCategory::create($insert);
            }

            foreach ($request->country_id as $value) {
                $insert = [
                    'product_id' => $product->id,
                    'country_id'      => $value['value'],
                ];

                ProductCountry::create($insert);
            }

            //Assign Related Files
            if ($request->related_files) {
                foreach ($request->related_files as $value) {
                    $file = '';
                    if (isset($value['file'])) {
                        $file_name = uniqid() . '.' . $value['file']->getClientOriginalExtension();
                        $path = Storage::disk('public')->putFileAs('product/related_files', $value['file'], $file_name);
                        $file = $path;
                    }

                    ProductRelatedFile::create([
                        'product_id'      => $product->id,
                        'file'          => $file ?? null,
                        'file_name'          => $value['file_name']
                    ]);
                }
            }

            //Assign Media
            if ($request->media) {
                foreach ($request->media as $value) {
                    if ($value['tipe'] == 'Photo') {
                        $file = '';

                        if (isset($value['image'])) {
                            $file_name = uniqid() . '.' . $value['image']->getClientOriginalExtension();
                            $path = Storage::disk('public')->putFileAs('product/image', $value['image'], $file_name);
                            $file = $path;
                        }

                        ProductPhoto::create([
                            'product_id' => $product->id,
                            'image'      => $file,
                            'copyright'  => $value['copyright']
                        ]);
                    } else if ($value['tipe'] == 'Video Upload') {
                        $file = '';

                        if (isset($value['video'])) {
                            $file_name = uniqid() . '.' . $value['video']->getClientOriginalExtension();
                            $path = Storage::disk('public')->putFileAs('product/video', $value['video'], $file_name);
                            $file = $path;
                        }

                        ProductPhoto::create([
                            'product_id' => $product->id,
                            'video'      => $file,
                            'copyright'  => $value['copyright']
                        ]);
                    } else if ($value['tipe'] == 'Video Link') {
                        ProductPhoto::create([
                            'product_id' => $product->id,
                            'video_link' => $value['video_link'],
                            'copyright'  => $value['copyright']
                        ]);
                    }
                }
            }

            if ($request->section) {
                $flexypage = FlexyPage::create([
                    'page' => 'Product',
                    'is_product' => true,
                    'title' =>  $product->title,
                    'product_id' => $product->id,
                ]);

                $helper = new FlexyPageHelperController;
                $helper->store_flexy_section($request->section, $flexypage);
            }

            // send mail notification for admins
            $admins = Karyawan::whereHas('jabatan',function($query) {
                $query->where('is_admin',true);
            })->get();

            $product->subject = 'New Product Uploaded by '.$product->product_company->title.' - Action Required';

            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new AdminProductNotificationMail($product));
            }

            log_activity(
                'Create Product ' . $product->title,
                $product
            );

            DB::commit();
            return redirect()->route('user.product.index')->with('alertState', 'success')->with('alertMessage', 'Product successfully added.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    public function draft(Request $request)
    {
        if ($request->media) {
            foreach ($request->media as $value) {
                if ($value['tipe'] == 'Photo') {
                    $image = getimagesize($value['image']);

                    $width = $image[0];
                    $height = $image[1];

                    if($width < 1024) {
                        return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', 'Media image width cannot under 1024');
                    }

                    if($height < 536) {
                        return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', 'Media image height cannot under 536');
                    }
                }
            }
        }

        $request->validate($this->validationRulesDraft());

        $request->merge([
            'is_responsible' => false,
            'is_agree'      => false,
            'approval_status' => 'Draft',
            'status'          => 'Draft'
        ]);

        DB::beginTransaction();
        try {
            $product = Product::create($request->except(['is_admin_approved', 'thumbnail_image']));

            if ($request->hasFile('thumbnail_image')) {
                $file_name                = $product->slug . '-' . uniqid() . '.' . $request->file('thumbnail_image')->getClientOriginalExtension();
                $path                     = Storage::disk('public')->putFileAs('private_sector/thumbnail_image', $request->file('thumbnail_image'), $file_name);
                $product->thumbnail_image = $path;
            }

            $product->save();

            if($request->category_id) {
                foreach ($request->category_id as $value) {
                    $insert = [
                        'product_id' => $product->id,
                        'category_id'      => $value['value'],
                    ];

                    ProductCategory::create($insert);
                }
            }

            if($request->country_id) {
                foreach ($request->country_id as $value) {
                    $insert = [
                        'product_id' => $product->id,
                        'country_id'      => $value['value'],
                    ];

                    ProductCountry::create($insert);
                }
            }

            //Assign Related Files
            if ($request->related_files) {
                foreach ($request->related_files as $value) {
                    $file = '';
                    if (isset($value['file'])) {
                        $file_name = uniqid() . '.' . $value['file']->getClientOriginalExtension();
                        $path = Storage::disk('public')->putFileAs('product/related_files', $value['file'], $file_name);
                        $file = $path;
                    }

                    ProductRelatedFile::create([
                        'product_id'      => $product->id,
                        'file'          => $file ?? null,
                        'file_name'          => $value['file_name']
                    ]);
                }
            }

            //Assign Media
            if ($request->media) {
                foreach ($request->media as $value) {
                    if ($value['tipe'] == 'Photo') {
                        $file = '';

                        if (isset($value['image'])) {
                            $file_name = uniqid() . '.' . $value['image']->getClientOriginalExtension();
                            $path = Storage::disk('public')->putFileAs('product/image', $value['image'], $file_name);
                            $file = $path;
                        }

                        ProductPhoto::create([
                            'product_id' => $product->id,
                            'image'      => $file,
                            'copyright'  => $value['copyright']
                        ]);
                    } else if ($value['tipe'] == 'Video Upload') {
                        $file = '';

                        if (isset($value['video'])) {
                            $file_name = uniqid() . '.' . $value['video']->getClientOriginalExtension();
                            $path = Storage::disk('public')->putFileAs('product/video', $value['video'], $file_name);
                            $file = $path;
                        }

                        ProductPhoto::create([
                            'product_id' => $product->id,
                            'video'      => $file,
                            'copyright'  => $value['copyright']
                        ]);
                    } else if ($value['tipe'] == 'Video Link') {
                        ProductPhoto::create([
                            'product_id' => $product->id,
                            'video_link' => $value['video_link'],
                            'copyright'  => $value['copyright']
                        ]);
                    }
                }
            }

            if ($request->section) {
                $flexypage = FlexyPage::create([
                    'page' => 'Product',
                    'is_product' => true,
                    'title' =>  $product->title,
                    'product_id' => $product->id,
                ]);

                $helper = new FlexyPageHelperController;
                $helper->store_flexy_section($request->section, $flexypage);
            }

            // send mail notification for admins
            // $admins = Karyawan::where('id_jabatan', 1)->get();
            // $product->subject = 'A user has creating a product';
            // foreach ($admins as $admin) {
            //     Mail::to($admin->email)->send(new AdminProductNotificationMail($product));
            // }

            log_activity(
                'Create Product as draft ' . $product->title,
                $product
            );

            DB::commit();
            return redirect()->route('user.product.index')->with('alertState', 'success')->with('alertMessage', 'Product successfully added.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        $this->breadcrumbs[] = [
            'text'  => 'Edit Product',
            'route' => route('user.product.edit', [$product->slug])
        ];

        $product->load(['product_category.category', 'product_country.country', 'product_photo', 'product_creator','product_company']);

        $product->product_category = collect($product->product_category)->transform(function ($item) {
            $item->value = $item->category->id;
            $item->label = $item->category->nama;

            return $item->only(['value', 'label']);
        });

        $product->product_country = collect($product->product_country)->transform(function ($item) {
            $item->value = $item->country->id;
            $item->label = $item->country->country;

            return $item->only(['value', 'label']);
        });

        if (\Auth::user()->jabatan->is_admin != 1) {
            $company = ProductCompany::where('user_id', \Auth::user()->id)->select('id as value', 'title as label')->get();
        } else {
            $company = ProductCompany::select('id as value', 'title as label')->get();
        }

        $flexy = $product->flexy;

        return Inertia::render('User/Product/Edit', [
            'breadcrumbs'    => $this->breadcrumbs,
            'product'        => $product,
            'categories'     => Kategori::select('id as value', 'nama as label')->get(),
            'countryOptions'  => ListCountry::select('id as value', 'country as label')->get(),
            'companyOptions' => $company,
            'paragraph'       => $flexy ? $flexy->paragraph->load('detail') : null,
            'table'           => $flexy ? $flexy->table : null,
            'media'           => $flexy ? $flexy->media : null,
            'quote'           => $flexy ? $flexy->quote : null,
            'faq'             => $flexy ? $flexy->faq->load('detail') : null,
            'reference'       => $flexy ? $flexy->reference->load('detail') : null,
            'history'         => $flexy ? $flexy->history : null,
            'data_related_files' => $product->related_file,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        if ($request->media) {
            foreach ($request->media as $value) {
                if ($value['tipe'] == 'Photo') {
                    if($value['image'] != null) {
                        $image = getimagesize($value['image']);
                        
                        $width = $image[0];
                        $height = $image[1];

                        if($width < 1024) {
                            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', 'Media image width cannot under 1024');
                        }

                        if($height < 536) {
                            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', 'Media image height cannot under 536');
                        }
                    }

                }
            }
        }

        if($request->is_draft) {
            $request->validate($this->validationRulesDraft());
        } else {
            $request->validate($this->validationRules($product), [
                'category_id.required' => "The category field is required",
                'country_id.required'  => "The country field is required",
            ]);
        }
            
        DB::beginTransaction();
        try {
            if($product->status == $request->status) {
                if($request->approval_status == 'Approved') {
                    $request->merge(['status'=>'Published']);
                }
            }
            
            $old_approval_status = $product->approval_status;
            $old_status = $product->status;

            if($product->approval_status == 'Draft' && !$request->is_draft) {
                $request->merge([
                    'status'=>'Unpublished',
                    'approval_status'=>'Waiting Approval'
                ]);
            }

            $product->update($request->except([
                'admin_comment',
                'photo',
                'is_responsible',
                'is_agree',
                'thumbnail_image'
            ]));

            if ($request->hasFile('thumbnail_image')) {
                $file_name                = $product->slug . '-' . uniqid() . '.' . $request->file('thumbnail_image')->getClientOriginalExtension();
                $path                     = Storage::disk('public')->putFileAs('private_sector/thumbnail_image', $request->file('thumbnail_image'), $file_name);
                $product->thumbnail_image = $path;
            }

            $product->save();

            if($old_approval_status == 'Draft' && !$request->is_draft) {
                // send mail notification for admins
                $admins = Karyawan::whereHas('jabatan',function($query) {
                    $query->where('is_admin',true);
                })->get();

                $product->subject = 'New Product Uploaded by '.$product->product_company->title.' - Action Required';

                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new AdminProductNotificationMail($product));
                }
            }

            if($request->status == 'Unpublished' && $old_status == 'Published') {
                // send mail notification user unpublished product
                $admins = Karyawan::whereHas('jabatan',function($query) {
                    $query->where('is_admin',true);
                })->get();

                $product->subject = $product->product_company->title.' Removed a Product / Service - Action May Be Required';

                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new UserUnpublishedProductNotificationMail($product));
                }
            } else {
                if($product->approval_status != 'Draft') {
                    // send mail notification for admins jika user update content
                    $admins = Karyawan::whereHas('jabatan',function($query) {
                        $query->where('is_admin',true);
                    })->get();
                    $product->subject = 'Company '.$product->product_company->title.' has updated their product';
                    
                    foreach ($admins as $admin) {
                        Mail::to($admin->email)->send(new UserUpdatedProductNotificationMail($product));
                    }
                }
            }


            //Assign Related Files
            if ($request->related_files) {
                $id = [];
                foreach ($request->related_files as $value) {
                    if (isset($value['id'])) {
                        $id[] = $value['id'];
                        $data = ProductRelatedFile::find($value['id']);

                        if (isset($value['file'])) {
                            $file_name = uniqid() . '.' . $value['file']->getClientOriginalExtension();
                            $path = Storage::disk('public')->putFileAs('product/related_files', $value['file'], $file_name);
                            $data->file = $path;
                        }

                        $data->file_name = $value['file_name'];
                        $data->save();
                    } else {
                        $file = '';
                        if (isset($value['file'])) {
                            $file_name = uniqid() . '.' . $value['file']->getClientOriginalExtension();
                            $path = Storage::disk('public')->putFileAs('product/related_files', $value['file'], $file_name);
                            $file = $path;
                        }

                        $related_files = ProductRelatedFile::create([
                            'product_id'      => $product->id,
                            'file'         => $file ?? null,
                            'file_name'        => $value['file_name']
                        ]);

                        $id[] = $related_files->id;
                    }
                }
                $delete = ProductRelatedFile::whereNotIn('id', $id)->where('product_id', $product->id)->delete();
            } else {
                $delete = ProductRelatedFile::where('product_id', $product->id)->delete();
            }

            if ($request->media) {
                $id = [];
                foreach ($request->media as $value) {
                    if ($value['tipe'] == 'Photo') {
                        if (isset($value['id'])) {
                            $id[] = $value['id'];
                            $data = ProductPhoto::find($value['id']);

                            if (isset($value['image'])) {
                                $file_name = uniqid() . '.' . $value['image']->getClientOriginalExtension();
                                $path = Storage::disk('public')->putFileAs('product/photo', $value['image'], $file_name);
                                $data->image = $path;
                            }

                            $data->copyright = $value['copyright'];
                            $data->save();
                        } else {
                            $file = '';
                            if (isset($value['image'])) {
                                $file_name = uniqid() . '.' . $value['image']->getClientOriginalExtension();
                                $path = Storage::disk('public')->putFileAs('product/image', $value['image'], $file_name);
                                $file = $path;

                                $photo = ProductPhoto::create([
                                    'product_id' => $product->id,
                                    'image'      => $file ?? null,
                                    'copyright'  => $value['copyright'],
                                ]);
                            }
                            $id[] = $photo->id;
                        }
                    } else if ($value['tipe'] == 'Video Upload') {
                        if (isset($value['id'])) {
                            $id[] = $value['id'];
                            $data = ProductPhoto::find($value['id']);

                            if (isset($value['video'])) {
                                $file_name = uniqid() . '.' . $value['video']->getClientOriginalExtension();
                                $path = Storage::disk('public')->putFileAs('product/video', $value['video'], $file_name);
                                $data->video = $path;
                            }

                            $data->copyright = $value['copyright'];
                            $data->save();
                        } else {
                            $file = '';
                            if (isset($value['video'])) {
                                $file_name = uniqid() . '.' . $value['video']->getClientOriginalExtension();
                                $path = Storage::disk('public')->putFileAs('product/video', $value['video'], $file_name);
                                $file = $path;

                                $photo = ProductPhoto::create([
                                    'product_id' => $product->id,
                                    'video'      => $file ?? null,
                                    'copyright'  => $value['copyright'],
                                ]);
                            }
                            $id[] = $photo->id;
                        }
                    } else if ($value['tipe'] == 'Video Link') {
                        if (isset($value['id'])) {
                            $id[] = $value['id'];
                            $data = ProductPhoto::find($value['id']);
                            $data->video_link = $value['video_link'];
                            $data->copyright  = $value['copyright'];
                            $data->save();
                        } else {
                            $file = '';
                            if (isset($value['video'])) {
                                $photo = ProductPhoto::create([
                                    'product_id' => $product->id,
                                    'video_link' => $value['video_link'],
                                    'copyright'  => $value['copyright'],
                                ]);
                            }
                            $id[] = $photo->id;
                        }
                    }
                }
                $delete = ProductPhoto::whereNotIn('id', $id)->where('product_id', $product->id)->delete();
            } else {
                $delete = ProductPhoto::where('product_id', $product->id)->delete();
            }

            if ($request->section) {
                $helper = new FlexyPageHelperController;
                $helper->update_flexy_section($request->section, $product->flexy);
            }

            if ($request->category_id) {
                $id = [];
                foreach ($request->category_id as $value) {
                    $id[] = $value['value'];
                    $check = ProductCategory::where('product_id', $product->id)->where('category_id', $value['value'])->first();

                    if (!$check) {
                        $insert = [
                            'product_id' => $product->id,
                            'category_id'      => $value['value'],
                        ];

                        $category = ProductCategory::create($insert);
                        $id[] = $category->id;
                    }
                }

                //delete unused productcategory
                ProductCategory::where('product_id', $product->id)->whereNotIn('category_id', $id)->delete();
            }

            if ($request->country_id) {
                $id = [];
                foreach ($request->country_id as $value) {
                    $id[] = $value['value'];
                    $check = ProductCountry::where('product_id', $product->id)->where('country_id', $value['value'])->first();

                    if (!$check) {
                        $insert = [
                            'product_id' => $product->id,
                            'country_id'      => $value['value'],
                        ];

                        $country = ProductCountry::create($insert);
                        $id[] = $country->id;
                    }
                }

                //delete unused ProductCountry
                ProductCountry::where('product_id', $product->id)->whereNotIn('country_id', $id)->delete();
            }

            $product->load(['product_creator']);

            $old = collect([
                'old' => $product->getOriginal()
            ]);

            log_activity(
                'Edit Product ' . $product->title,
                $product,
                $old
            );

            DB::commit();
            return redirect()->route('user.product.index')->with('alertState', 'success')->with('alertMessage', 'Product successfully updated.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            $admins = Karyawan::whereHas('jabatan',function($query) {
                $query->where('is_admin',true);
            })->get();
            
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new UserDeletedProductNotificationMail($product));
            }

            $product->delete();

            log_activity(
                'Delete Product ' . $product->title,
                $product
            );

            DB::commit();
            return redirect()->route('user.product.index')->with('alertState', 'success')->with('alertMessage', 'Product successfully deleted.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('alertState', 'error')->with('alertMessage', $e->getMessage());
        }
    }

    public function table(Request $request)
    {
        return response()->json(Product::where('user_id',\Auth::user()->id)->with('product_creator','product_category.category','product_country.country','product_company')->orderBy('created_at', 'DESC')->filter($request->all())->paginateFilter());
    }

    public function validationRules($product = null)
    {
        if (!$product) {
            return [
                'title'            => 'required',
                'category_id'      => 'required',
                'country_id'       => 'required',
                'company_id'       => 'required',
                'thumbnail_image'  => 'required',
                'description'      => 'required',
            ];
        }

        return [
            'category_id'        => 'required',
            'country_id'         => 'required',
            'company_id'         => 'required',
            'thumbnail_image'    => 'nullable',
            'admin_comment' => 'required_if:approval_status,Rejected',
            'description'  => 'required',
            'status'           => 'required',
        ];
    }

    public function validationRulesDraft($product = null)
    {
        return [
            'title'            => 'required',
            'company_id'            => 'required',
        ];
    }
}
