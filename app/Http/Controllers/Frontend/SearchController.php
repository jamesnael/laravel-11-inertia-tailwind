<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\EPR;
use App\Models\Event;
use App\Models\ListCountry;
use App\Models\MetaTag;
use App\Models\News;
use App\Models\Plastic;
use App\Models\PracticalMeasure;
use App\Models\Product;
use App\Models\Publication;
use App\Models\ZeroOnPlastic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{

    public function __construct(Request $request)
    {
        $this->default = [
            'meta'          => MetaTag::where('slug', 'search-result')->first(),
            'notGetInTouch' => true
        ];
    }

    public function index(Request $request)
    {
        $params       = $request->input('query');
        $countries    = ListCountry::select('id as value', 'country as label')->get();

        // Search queries
        $results = [];
        if ($params != '') {
            $news       = News::select('category_id', 'country as country_id', 'created_at', 'title', 'slug', 'thumbnail_image')
                ->whereNull('deleted_at')
                ->where('title', 'LIKE', '%' . $params . '%');

            $events     = Event::select('category_id', 'country as country_id', 'created_at', 'title', 'slug', 'banner_image as thumbnail_image')
                ->whereNull('deleted_at')
                ->where('title', 'LIKE', '%' . $params . '%')
                ->where('status', true);

            $pMeasures  = PracticalMeasure::select('category_id', 'created_at as country_id',  'created_at', 'title', 'slug', 'thumbnail_image')
                ->whereNull('deleted_at')
                ->where('title', 'LIKE', '%' . $params . '%');

            $epr        = EPR::select('category_id', 'country_id', 'created_at', 'title', 'slug', 'thumbnail_image')
                ->whereNull('deleted_at')
                ->where('title', 'LIKE', '%' . $params . '%');

            $product    = Product::select('created_at as category_id', 'created_at as country_id', 'created_at', 'title', 'slug', 'thumbnail_image')
                ->whereNull('deleted_at')
                ->where('title', 'LIKE', '%' . $params . '%')
                ->where('status', 'Published');

            $pMangroves = Plastic::select('category_id', 'country_id', 'created_at', 'title', 'slug', 'thumbnail_image')
                ->whereNull('deleted_at')
                ->where('title', 'LIKE', '%' . $params . '%');

            $reports    = Publication::select('category_id', 'created_at as country_id', 'created_at', 'title', 'slug', 'cover as thumbnail_image')
                ->whereNull('deleted_at')
                ->where('title', 'LIKE', '%' . $params . '%')
                ->where('status', true);

            $zPlastics  = ZeroOnPlastic::select("created_at as category_id", 'country_id', 'created_at', 'title', 'slug', 'banner_image as thumbnail_image')
                ->whereNull('deleted_at')
                ->where('title', 'LIKE', '%' . $params . '%')
                ->where('status', true)
                ->orderBy('created_at', 'desc')
                ->union($events)
                ->union($news)
                ->union($pMeasures)
                ->union($epr)
                ->union($product)
                ->union($pMangroves)
                ->union($reports)
                ->get();

            $results = $zPlastics;

            if ($results != []) {
                $results->transform(function ($item) use ($params) {
                    $thumbnail = explode('/', $item->thumbnail_image);

                    if ($thumbnail[0] == 'https:') {
                        switch ($thumbnail[4]) {
                            case 'news':
                                $item->category = 'News';
                                $item->category_slug = Str::slug($item->category);
                                $item->url      = route('frontend.news.detail', [$item->slug]);
                                break;
                            case 'event':
                                $item->category = 'Event';
                                $item->category_slug = Str::slug($item->category);
                                $item->url      = route('frontend.events.detail', [$item->slug]);
                                break;
                            case 'practical_measure':
                                $item->category = 'Practical Measure';
                                $item->category_slug = Str::slug($item->category);
                                $item->url      = route('frontend.practical-measures.detail', [$item->slug]);
                                break;
                            case 'private_sector':
                                $item->category = 'Product';
                                $item->category_slug = Str::slug($item->category);
                                $item->url      = route('frontend.private-sector-platform.detail', [$item->slug]);
                                break;
                            case 'plastic':
                                $item->category = 'Plastic & Mangrove';
                                $item->category_slug = Str::slug($item->category);
                                $item->url      = route('frontend.plastic-waste-and-mangrove.detail', [$item->slug]);
                                break;
                            case 'epr':
                                $item->category = 'EPR';
                                $item->category_slug = Str::slug($item->category);
                                $item->url      = route('frontend.extended-producer-responsibility.detail', [$item->slug]);
                                break;
                            case 'on_plastic':
                                $item->category = 'Zero-in On Plastic';
                                $item->category_slug = Str::slug($item->category);
                                $item->url      = route('frontend.zero-in-on-plastic.detail', [$item->slug]);
                                break;
                            case 'publication':
                                $item->category = 'Reports & Publications';
                                $item->category_slug = Str::slug($item->category);
                                $item->url      = route('frontend.reports-publications.detail', [$item->slug]);
                                break;
                            default:
                                $item->category = 'TBD';
                                $item->category_slug = Str::slug($item->category);
                                $item->url      = '#';
                                break;
                        }
                    } else {
                        switch ($thumbnail[0]) {
                            case 'news':
                                $item->category        = 'News';
                                $item->category_slug   = Str::slug($item->category);
                                $item->url             = route('frontend.news.detail', [$item->slug]);
                                $item->thumbnail_image = 'storage/' . $item->thumbnail_image;
                                break;
                            case 'event':
                                $item->category        = 'Event';
                                $item->category_slug   = Str::slug($item->category);
                                $item->url             = route('frontend.events.detail', [$item->slug]);
                                $item->thumbnail_image = 'storage/' . $item->thumbnail_image;
                                break;
                            case 'practical_measure':
                                $item->category        = 'Practical Measure';
                                $item->category_slug   = Str::slug($item->category);
                                $item->url             = route('frontend.practical-measures.detail', [$item->slug]);
                                $item->thumbnail_image = 'storage/' . $item->thumbnail_image;
                                break;
                            case 'private_sector':
                                $item->category        = 'Product';
                                $item->category_slug   = Str::slug($item->category);
                                $item->url             = route('frontend.private-sector-platform.detail', [$item->slug]);
                                $item->thumbnail_image = 'storage/' . $item->thumbnail_image;
                                break;
                            case 'plastic':
                                $item->category        = 'Plastic & Mangrove';
                                $item->category_slug   = Str::slug($item->category);
                                $item->url             = route('frontend.plastic-waste-and-mangrove.detail', [$item->slug]);
                                $item->thumbnail_image = 'storage/' . $item->thumbnail_image;
                                break;
                            case 'epr':
                                $item->category        = 'EPR';
                                $item->category_slug   = Str::slug($item->category);
                                $item->url             = route('frontend.extended-producer-responsibility.detail', [$item->slug]);
                                $item->thumbnail_image = 'storage/' . $item->thumbnail_image;
                                break;
                            case 'on_plastic':
                                $item->category        = 'Zero-in On Plastic';
                                $item->category_slug   = Str::slug($item->category);
                                $item->url             = route('frontend.zero-in-on-plastic.detail', [$item->slug]);
                                $item->thumbnail_image = 'storage/' . $item->thumbnail_image;
                                break;
                            case 'publication':
                                $item->category        = 'Reports & Publications';
                                $item->category_slug   = Str::slug($item->category);
                                $item->url             = route('frontend.reports-publications.detail', [$item->slug]);
                                $item->thumbnail_image = 'storage/' . $item->thumbnail_image;
                                break;
                            default:
                                $item->category = 'TBD';
                                $item->category_slug = Str::slug($item->category);
                                $item->url      = '#';
                                break;
                        }
                    }

                    // highlight searched parameter in title
                    $item->title = preg_replace('/(' . $params . ')/i', '<span class="search-info-highlight">$1</span>', $item->title);

                    // get sub category
                    $item->sub_category = '';

                    // using created_at as category_id for any data which doesn't have a category field,
                    // so, to check if it's a valid category id
                    // is by verifying the category_id field value is not a date string
                    // a valid id doesn't have a -
                    // union method needs to selecting same number of field
                    // so, yeah it happens (pls forgive me)
                    if ($item->category_id && strpos($item->category_id, '-') === false) {
                        $category           = Category::where('id', $item->category_id)->first();
                        $item->sub_category = $category->category;
                    }

                    // check country_id
                    // same as above, no every data has country id
                    // so it needs to be checked
                    if ($item->country_id && strpos($item->country_id, '-') === false) {
                        // check if country is alphabet
                        if (preg_match("/[a-z]/i", $item->country_id) && $item->category_slug != 'product') {
                            // get the valid country id
                            $country          = ListCountry::where('country', $item->country_id)->first();
                            $item->country_id = (string) $country->id;
                        }
                    }

                    // reset country id
                    // if the item does not have country fields to begin with
                    if (strpos($item->country_id, '-') !== false) {
                        $item->country_id = null;
                    }

                    // if the item is product
                    // get all of its country ids
                    if ($item->category_slug == 'product') {
                        $product          = Product::with('product_country')->where('slug', $item->slug)->first();
                        $item->country_id = (string) implode(',', $product->product_country->pluck('country_id')->toArray());
                    }

                    return $item;
                });
            }
        }

        return view('frontend.search.index', $this->default)->with([
            'body_class'   => 'bg-cream',
            'param'        => $params,
            'countries'    => $countries,
            'results'      => $results
        ]);
    }
}
