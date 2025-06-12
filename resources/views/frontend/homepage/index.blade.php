@extends('frontend.layouts.app')

@section('content')
    @include('frontend.homepage.banner')

    <div class="gradient-blue-2"></div>

    @include('frontend.homepage.about')

    @include('frontend.homepage.news')

    @include('frontend.homepage.location')

    <div class="wave d-none d-md-block" style="margin-top: -150px;pointer-events: none">
        <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;">
            <path d="M-9.97,130.93 C167.80,23.41 316.21,149.84 502.44,101.06 L500.00,150.33 L-1.50,160.79 Z" style="stroke: none; fill: #FCF3EC;"></path>
        </svg>
    </div>

    <div class="wave d-block d-md-none" style="margin-top: -68px;pointer-events: none; height: 70px">
        <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;">
            <path d="M-9.97,130.93 C167.80,23.41 316.21,149.84 502.44,101.06 L500.00,150.33 L-1.50,160.79 Z" style="stroke: none; fill: #FCF3EC;"></path>
        </svg>
    </div>

    @include('frontend.homepage.rcs')

    @include('frontend.homepage.feature')

    @include('frontend.homepage.support')

@endsection

@section('script')
<script>
    var message = "{{ $message }}";

    if(message) {
        Swal.fire({
            icon: "success",
            allowOutsideClick: false,
            allowEscapeKey: false,
            title: "Thank You!",
            text: message,
            customClass: {
                confirmButton: 'bg-primary'
            },
        });
    }
</script>
<script type="text/javascript" src="{{ asset('frontend/js/homepage.js') }}?v={{ time() }}"></script>
@endsection
