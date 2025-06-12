<section class="about-sm">
    <div class="container-lg overflow-hidden">
        <div class="row gx-5">
            <div class="col-md-6">
                {{-- <p class="text-24 text-white">
                    {{ $about->left_text }}
                </p> --}}
                <div class="text-white home-about-left-text">
                    {!! $about->left_text !!}
                </div>
                @if ($about->left_button_label && $about->left_button_link)
                    <div class="d-none d-md-block">
                        <a href="{{ $about->left_button_link }}" target="_blank" class="btn btn-outline-warning">
                            {{ $about->left_button_label }}
                        </a>
                    </div>
                    <div class="d-block d-md-none">
                        <a href="{{ $about->left_button_link }}" target="_blank" class="d-block btn btn-outline-warning">
                            {{ $about->left_button_label }}
                        </a>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <div class="cn-right">
                    <div class="text-white pb-5 home-about-right-text">
                        {!! $about->right_text !!}
                    </div>
                    @if ($about->right_button_label && $about->right_button_link)
                        <div class="d-none d-md-block">
                            <a href="{{ $about->right_button_link }}" target="_blank" class="btn btn-outline-warning">
                                {{ $about->right_button_label }}
                            </a>
                        </div>
                        <div class="d-block d-md-none">
                            <a href="{{ $about->right_button_link }}" target="_blank" class="d-block btn btn-outline-warning">
                                {{ $about->right_button_label }}
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</section>
