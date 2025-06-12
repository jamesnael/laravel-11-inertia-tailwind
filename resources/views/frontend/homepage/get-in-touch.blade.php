<section class="get-in-touch" style="background: url('{{ $getintouch->image }}') no-repeat center top/cover;">
    <svg class="divider-5"  width="100%" height="100%" viewBox="0 0 1439 75" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M1440 43.755s-306.5 67.213-691.5 4.213c-416.5-80-748.5-6-748.5-6V0h1440v43.755z" fill="{{$color ?? '#FBFBFB'}}"/>
    </svg>
    {{-- <svg class="divider-6" width="100%" height="100%" viewBox="0 0 1441 62" fill="#093554" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 23.243s301-52.296 720.5 0c419.5 52.295 720.5 0 720.5 0V61.5H0V23.243z" fill="url(#a)"/>
            <defs>
                <linearGradient id="a" x1="720.5" y1="-323.461" x2="720.5" y2="302.039" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#14527D"/><stop offset="0" stop-color="#093554"/><stop offset="1" stop-color="#093554"/>
                </linearGradient>
            </defs>
        </svg> --}}
    <div class="container-lg">
        <div class="row">
            <div class="col-md-5">
                <img class="mb-16" src="{{ asset('frontend/images/ornament.svg') }}" alt="">
                <h3 class="title">{{ $getintouch->title }}</h3>
                <p class="text-20 description">
                    {{ $getintouch->description }}
                </p>
                <a href="{{ $getintouch->button_link }}" class="btn btn-warning">{{ $getintouch->button_text }}</a>
            </div>
        </div>
    </div>
</section>
