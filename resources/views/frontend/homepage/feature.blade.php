<section class="feature">
    <div class="container-lg">
        <div class="row pb-3 pb-md-5">
            <div class="col-md-4 feature-content pe-md-5 pe-2">
                <div class="inner-content">
                    <div>
                        <img class="mb-16" src="{{ asset('frontend/images/ornament.svg') }}" alt="">
                        <h4 class="home-title title mb-4">{{ $feature_project->title }}</h4>
                        <p class="rcs-description text-20 mb-5">{{ $feature_project->description }}</p>
                        <a href="{{ route('frontend.our-projects') }}" class="d-none d-md-block btn btn-outline-warning m-none">VIEW MORE</a>
                    </div>
                    <div class="m-none">
                        <div class="feature-nav feature-prev me-2"><i class="ico ico-arrow-left"></i></div>
                        <div class="feature-nav feature-next"><i class="ico ico-arrow-left"></i></div>

                        <div class="swiper-pagination feature-paging"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="swiper feature-slide w-100">
                    <div class="swiper-wrapper feature-project-slide">
                        @foreach ($project as $value)
                            <div class="swiper-slide">
                                <a href="{{ route('frontend.our-projects.detail', [$value->slug]) }}">
                                    <div class="thumb-v">
                                        <img src="{{ $value->thumbnail_image }}" alt="">
                                    </div>
                                </a>
                                <a href="{{ route('frontend.our-projects.detail', [$value->slug]) }}" class="title-link">
                                    <h4 class="my-3 feature-project-title">
                                        {{ $value->project_name }}
                                    </h4>
                                </a>
                                <p class="text-16 mb-0 feature-project-lead">
                                    {{ \Str::limit($value->short_description, 150) }}
                                </p>
                            </div>
                        @endforeach

                    </div>

                </div>
            </div>
        </div>

        <a href="{{ route('frontend.our-projects') }}" class="btn btn-outline-warning d-block d-md-none my-4">DISCOVER</a>
    </div>
</section>
