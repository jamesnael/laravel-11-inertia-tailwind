@php
    $isImage = true;
    if (strpos($sliding_banner[0]->desktop_banner, '.mp4') !== false) {
        $isImage = false;
    }
@endphp
<section class="hero d-none d-md-block" id="bgBanner" style="background: {{ $isImage ? 'url(' . $sliding_banner[0]->desktop_banner . ')' : '#083E62' }} no-repeat center center/cover;">
    <div class="overlay"></div>
    <div class="container-lg content-hero">
        <div class="bg {{ $isImage ? 'd-none' : 'd-block' }}">
            <video autoplay muted loop playsinline id="vidBanner" class="w-100 d-none d-md-block" style="z-index: -1">
                <source id="vidDesktop"  src="{{ !$isImage ? $sliding_banner[0]->desktop_banner : '' }}" type="video/mp4">
                Your browser does not support HTML5 video.
            </video>
        </div>

        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper main-slide w-100">
            <div class="swiper-wrapper">
                @foreach ($sliding_banner as $banner)
                    <div class="swiper-slide" data-desktop="{{ $banner->desktop_banner }}" data-mobile="{{ $banner->mobile_banner }}">
                        <div class="row align-items-center">
                            <div class="col-md-7">
                                <h1 class="sliding-banner-title">
                                    {{ $banner->title }}
                                </h1>
                                <p class="py-4 sliding-banner-subtitle">
                                    {{ $banner->subtitle }}
                                </p>
                                @if ($banner->button_text)
                                    <div class="mt-4">
                                        <a href="{{ $banner->button_link }}" class="btn btn-warning px-4 py-2">
                                            {{ $banner->button_text }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- <div class="swiper-pagination paging-main"></div> --}}
        </div>
        <div thumbsSlider="" class="swiper thumb-slide w-100">
            <div class="swiper-wrapper">
                @foreach ($sliding_banner as $banner)
                    <div class="swiper-slide" data-desktop="{{ $banner->desktop_banner }}" data-mobile="{{ $banner->mobile_banner }}">
                        <div class="progress-wrapper sliding-banner-progress {{ $loop->first ? 'sliding-banner-active' : '' }}">
                            <div style="display:block;background: #ef6c4f; z-index: 1; width: 0%; height:2px;" class="progress progress-{{ $loop->index }}">
                                &nbsp;
                            </div>
                        </div>

                        <p class="mb-0 mt-2 banner-title {{ $loop->first ? 'banner-active' : '' }}">
                            {{ $banner->title }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- <img src="images/hero-bg.png" class="w-100" alt=""> -->
</section>

<section class="hero d-block d-md-none" id="bgBannerMobile" style="background: {{ $isImage ? 'url(' . $sliding_banner[0]->mobile_banner . ')' : '#083E62' }} no-repeat center center/cover;">
    <div class="container-lg content-hero">
        <div class="bg bg-mobile {{ $isImage ? 'd-none' : 'd-block' }}">
            <video autoplay muted loop playsinline id="vidBannerMobile" class="w-100 d-block d-md-none">
                <source id="vidMobile"  src="{{ !$isImage ? $sliding_banner[0]->mobile_banner : '' }}" type="video/mp4">
                Your browser does not support HTML5 video.
            </video>
        </div>

        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper main-slide-mobile w-100">
            <div class="swiper-wrapper">
                @foreach ($sliding_banner as $banner)
                    <div class="swiper-slide" data-desktop="{{ $banner->desktop_banner }}" data-mobile="{{ $banner->mobile_banner }}">
                        <div class="row align-items-center">
                            <div class="col-md-7">
                                <h1 class="sliding-banner-title">
                                    {{ $banner->title }}
                                </h1>
                                <p class="py-4 sliding-banner-subtitle">
                                    {{ $banner->subtitle }}
                                </p>
                                @if ($banner->button_text)
                                    <div class="mt-4">
                                        <a href="{{ $banner->button_link }}" class="btn btn-warning px-4 py-2">
                                            {{ $banner->button_text }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            <div class="swiper-pagination main-slide-mobile-paging"></div>
        </div>
    </div>
    <!-- <img src="images/hero-bg.png" class="w-100" alt=""> -->
</section>