<section class="section-news">
    <div class="container-lg">
        <div class="row align-items-end mb-5">
            <div class="col-md-8">
                <img class="mb-16" src="{{ asset('frontend/images/ornament.svg') }}" alt="">
                <h3 class="title text-dark mb-0">
                    Latest News
                </h3>
            </div>
            <div class="col-md-4 text-md-end text-start d-none d-md-block">
                <a href="{{ route('frontend.news') }} " class="btn btn-outline-warning m-none">VIEW MORE</a>
            </div>
        </div>
        <div class="row gy-5">
            @foreach ($news as $key => $value)
                @if ($key == 0)
                    <div class="col-md-7">
                        <a
                            href="{{ $value->tipe == 'Eksternal' ? $value->link : route('frontend.news.detail', [$value->slug]) }}">
                            <div class="news-big">
                                <div class="thumb-h">
                                    <img src="{{ $value->thumbnail_image }}" class="w-100" alt="">
                                </div>
                                @if ($value->category)
                                    <p class="latest-news-label-custom text-secondary font-weight-600 mb-1 mt-3">
                                        {{ $value->created_at->translatedFormat('d F Y') }} |
                                        {{ $value->category->category }}</p>
                                @else
                                    <p class="latest-news-label-custom text-secondary font-weight-600 mb-1 mt-3">
                                        {{ $value->created_at->translatedFormat('d F Y') }}</p>
                                @endif
                                <a href="{{ $value->tipe == 'Eksternal' ? $value->link : route('frontend.news.detail', [$value->slug]) }}"
                                    class="title-link">
                                    <h4 class="latest-news-title">{{ $value->title }}</h4>
                                </a>
                                <p class="font-16">
                                    {{ $value->sub_title }}
                                </p>
                                @if ($value->source && $value->link)
                                    <a href="{{ $value->link }}" target="_blank"
                                        class="link-dark latest-news-label-custom">{{ $value->source }} <i style="height: 20px;width:20px;" class="ico ico-link"></i></a>
                                @endif
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach

            <div class="col-md-5 d-none d-md-block">
                @foreach ($news as $key => $value)
                    @if ($key > 0)
                        <div class="news-small mb-4">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="small-thumb">
                                    <div class="thumb-b">
                                        <img src="{{ $value->thumbnail_image }}" class="w-100" alt="">
                                    </div>
                                </div>
                                <a
                                    href="{{ $value->tipe == 'Eksternal' ? $value->link : route('frontend.news.detail', [$value->slug]) }}">
                                    <div class="flex-1">
                                        @if ($value->category)
                                            <p class="latest-news-label-custom text-secondary font-weight-600 mb-1 mt-3">
                                                {{ $value->created_at->translatedFormat('d F Y') }} |
                                                {{ $value->category->category }}</p>
                                        @else
                                            <p class="latest-news-label-custom text-secondary font-weight-600 mb-1 mt-3">
                                                {{ $value->created_at->translatedFormat('d F Y') }}</p>
                                        @endif
                                        <a href="{{ $value->tipe == 'Eksternal' ? $value->link : route('frontend.news.detail', [$value->slug]) }}"
                                            class="title-link">
                                            <h5 class="line-2 latest-news-side-title">{{ $value->title }}</h5>
                                        </a>
                                        @if ($value->source && $value->link)
                                            <a href="{{ $value->link }}" target="_blank"
                                                class="link-dark latest-news-label-custom">{{ $value->source }} <i style="height: 20px;width:20px;" class="ico ico-link"></i></a>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="col-md-5 d-block d-md-none my-0 py-0">
                <div class="home-news-mobile-wrap py-4">
                    @foreach ($news as $key => $value)
                        @if ($key > 0)
                            <div class="home-news-mobile-content" style="border-right: {{ !$loop->last ? '1px solid #4D4F56' : 'none' }}">
                                <div>
                                    <a
                                        href="{{ $value->tipe == 'Eksternal' ? $value->link : route('frontend.news.detail', [$value->slug]) }}">
                                        <div class="flex-1">
                                            @if ($value->category)
                                                <p class="latest-news-label-custom text-secondary font-weight-600 mb-1 mt-3">
                                                    {{ $value->created_at->translatedFormat('d F Y') }} |
                                                    {{ $value->category->category }}</p>
                                            @else
                                                <p class="latest-news-label-custom text-secondary font-weight-600 mb-1 mt-3">
                                                    {{ $value->created_at->translatedFormat('d F Y') }}</p>
                                            @endif
                                            <a href="{{ $value->tipe == 'Eksternal' ? $value->link : route('frontend.news.detail', [$value->slug]) }}"
                                                class="title-link">
                                                <h5 class="line-2">{{ $value->title }}</h5>
                                            </a>
                                            @if ($value->source && $value->link)
                                                <a href="{{ $value->link }}" target="_blank"
                                                    class="link-dark latest-news-label-custom">{{ $value->source }} <i
                                                        style="height: 20px;width:20px;"
                                                        class="ico ico-link"></i></a>
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="my-4">
                    <a href="{{ route('frontend.news') }}" class="btn btn-outline-warning d-block my-4">VIEW MORE</a>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="wave" style="pointer-events: none;margin-top:-40px">
        <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;">
            <path d="M-5.45,81.15 C269.93,-39.31 285.17,184.69 501.31,46.30 L500.00,-0.00 L0.00,-0.00 Z"
                style="stroke: none; fill: #FBFBFB;"></path>
        </svg>
    </div> --}}
</section>
