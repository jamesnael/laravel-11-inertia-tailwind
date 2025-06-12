@php
    $is_404 = true;
    $notGetInTouch = true;
@endphp
@extends('frontend.layouts.app')

@section('content')

<section class="not-found">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-6 section-title">
                <div class="grid-1">
                    <h1 class="mb-32">Page Not Found</h1>
                    <img class="mb-32" src="{{ asset('frontend/images/ornament.svg') }}" alt="">
                </div>
                <div class="grid-2">
                    <p class="mb-24">Lorem ipsum dolor sit amet consectetur. Sed lorem quis semper vulputate arcu nisl adipiscing. Ipsum diam malesuada quis donec.</p>
                    <a href="{{ route('frontend.home.index') }}" class="btn btn-outline-warning m-none">BACK TO HOME</a>
                </div>
            </div>
            <div class="col-md-6 section-image">
                <img class="" src="{{ asset('frontend/images/ubur_ubur.png') }}" alt="">
            </div>
        </div>
    </div>
</section>

@endsection
