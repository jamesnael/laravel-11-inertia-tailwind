@if (!isset($notGetInTouch))
    @include('frontend.homepage.get-in-touch')
@endif
    <div class="footer" style="position: relative">
        <svg class="wave-footer" width="100%" height="100%" viewBox="0 0 1441 62" fill="#093554" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 23.243s301-52.296 720.5 0c419.5 52.295 720.5 0 720.5 0V61.5H0V23.243z" fill="url(#a)"/>
            <defs>
                <linearGradient id="a" x1="720.5" y1="-323.461" x2="720.5" y2="302.039" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#14527D"/><stop offset="0" stop-color="#093554"/><stop offset="1" stop-color="#093554"/>
                </linearGradient>
            </defs>
        </svg>
        <div class="container-lg">
        <div class="row gy-5">
            <div class="col-md-6 text-md-start text-center">
                <img src="{{asset('frontend/images/logo-white.png')}}" alt="">
                <div class="nav ps-md-4 ps-0 mt-4 justify-content-md-start justify-content-center" style="position: relative; z-index: 99">
                    <a href="https://www.linkedin.com/showcase/regional-knowledge-centre-for-marine-plastic-debris" target="_blank" class="nav-link pe-2">
                        <img src="{{asset('frontend/images/icons/in.svg')}}" alt="">
                    </a>
                    <a href="https://twitter.com/rkcmpd_eria" target="_blank" class="nav-link px-2">
                        <img src="{{asset('frontend/images/icons/x.svg')}}" alt="">
                    </a>
                    <a href="https://www.facebook.com/rkcmpd.eria" target="_blank" class="nav-link px-2">
                        <img src="{{asset('frontend/images/icons/facebook.svg')}}" alt="">
                    </a>
                    <a href="https://www.instagram.com/rkcmpd_eria" target="_blank" class="nav-link px-2">
                        <img src="{{asset('frontend/images/icons/ig.svg')}}" alt="">
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <h5 class="footer-subscribe">Subscribe to our newsletter</h5>
                <div class="subscribe d-none d-md-flex">
                    <div class="w-100">
                        <input type="text" class="form-control email-subscribe" placeholder="Enter your email">
                    </div>
                    <div>
                        <a href="#" class="btn btn-outline-warning">SUBMIT</a>
                    </div>
                </div>

                <div class="d-block d-md-none">
                    <div class="w-100">
                        <input type="text" class="form-control" placeholder="Enter your email">
                    </div>
                    <div class="mt-4">
                        <a href="#" class="d-block btn btn-outline-warning">SUBMIT</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="copy">
            <div class="row">
                <div class="col-md-6 text-md-start text-center">
                    Copyright © 2023 ERIA. All rights reserved.<a href="{{route('frontend.privacy-policy')}}" style="margin-left: 16px">Privacy Policy</a>
                </div>
                <div class="col-md-6 text-md-end text-center">
                    Designed and developed by <a href="#">Catalyze</a>
                </div>
            </div>
        </div>
    </div>
</div>