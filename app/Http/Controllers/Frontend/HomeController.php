<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Admin\Homepage\SupportedByController;
use App\Http\Controllers\Controller;
use App\Mail\UserRegistrationVerifiedNotificationMail;
use App\Models\HomeAbout;
use App\Models\SlidingBanner;
use App\Models\MetaTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Session;

class HomeController extends Controller
{
    public function __construct(Request $request)
    {
        $this->default = [
            'meta' => MetaTag::where('slug', 'homepage')->first(),
            'getintouch' => []
        ];

        $this->default_login = [
            'meta'       => MetaTag::where('slug', 'frontend-login')->first(),
            'notGetInTouch' => true
        ];
    }

    public function verify(Request $request)
    {
        $data = Karyawan::find(base64_decode($request->code));

        if ($data) {
            $data->status = true;
            $data->approval_status = 'Verified';
            $data->save();
            $msg = 'Success Verify Your Account! You can login to your account';

            Mail::to($data->email)->send(new UserRegistrationVerifiedNotificationMail($data));
        } else {
            $msg = 'Failed Verify Your Account! Your account has been deleted because the 3 hour time limit for verify has passed';
        }

        return view('frontend.login.index', $this->default_login)->with([
            'histories'         => History::get(),
            'body_class'        => 'bg-cream',
            'message'           => $msg
        ]);
    }

    public function index()
    {
        $sliding_banner = SlidingBanner::where('status', 1)->orderBy('position', 'ASC')->take(4)->get();

        $about = HomeAbout::first();

        return view('frontend.homepage.index', [
            'sliding_banner' => [],
            'about' => [],
            'news' => [],
            'project' => [],
            'supported_by' => [],
            'partnership' => [],
            'getintouch' => [],
            'research_catalogue' => [],
            'private_sector' => [],
            'feature_project' => [],
            'countries' => [],
            'message' => null
        ])->with($this->default);
    }
}
