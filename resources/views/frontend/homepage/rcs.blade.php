<section class="rcs">
    <img src="{{ asset('frontend/images/section-divider') }}-4.svg" class="divider-4" alt="">
    <div class="container-lg">
        <div class="d-none d-md-flex row align-items-center justify-content-end gy-5 my--9 mt-4 mt-md-0">
            <div
                class="col-md-6 {{ $research_catalogue->image_position == 'Right' ? 'order-md-1 order-2' : 'order-md-2 order-1' }}">
                <img src="{{ asset('frontend/images/ornament.svg') }}" alt="">
                <h3 class="home-title title">
                    {{ $research_catalogue->title ?? 'Research Expertise Catalogue' }}
                </h3>
                <p class="rcs-description text-20 my-4">
                    {{ $research_catalogue->description ?? 'The Research Expertise Catalogue covers information on marine plastic-related studies and researchers in the ASEAN+3 region.' }}'
                </p>
                @foreach ($research_catalogue->research_detail as $value)
                    <div class="d-flex gap-3 align-items-center mb-3">
                        <div>
                            <i class="ico"
                                style="background: url('{{ $value->icon }}') no-repeat center center/contain;width: 32px;height: 32px;"></i>
                        </div>
                        <div class="text-20 rcs-description">{{ $value->label }}</div>
                    </div>
                @endforeach

                @if ($research_catalogue->button_link && $research_catalogue->button_text)
                    <a href="{{ $research_catalogue->button_link }}"
                        class="btn btn-outline-warning btn-discover-homepage">{{ $research_catalogue->button_text }}</a>
                @endif
            </div>
            <div
                class="col-md-6 {{ $research_catalogue->image_position == 'Right' ? 'order-md-2 order-1' : 'order-md-1 order-2' }}">
                <img src="{{ $research_catalogue->image }}" class="w-100" alt="">
            </div>
        </div>

        <div class="d-md-none row align-items-center justify-content-end gy-5 my--9 mt-4 mt-md-0">
            <div class="col-md-6 {{ 'order-md-1 order-2' }}">
                <img src="{{ asset('frontend/images/ornament.svg') }}" alt="">
                <h3 class="home-title title">
                    {{ $research_catalogue->title ?? 'Research Expertise Catalogue' }}
                </h3>
                <p class="rcs-description text-20 my-4">
                    {{ $research_catalogue->description ?? 'The Research Expertise Catalogue covers information on marine plastic-related studies and researchers in the ASEAN+3 region.' }}'
                </p>
                @foreach ($research_catalogue->research_detail as $value)
                    <div class="d-flex gap-3 align-items-center mb-3">
                        <div>
                            <i class="ico"
                                style="background: url('{{ $value->icon }}') no-repeat center center/contain;width: 32px;height: 32px;"></i>
                        </div>
                        <div class="text-20 rcs-description">{{ $value->label }}</div>
                    </div>
                @endforeach

                @if ($research_catalogue->button_link && $research_catalogue->button_text)
                    <a href="{{ $research_catalogue->button_link }}"
                        class="btn btn-outline-warning btn-discover-homepage">{{ $research_catalogue->button_text }}</a>
                @endif
            </div>
            <div class="col-md-6 {{ 'order-md-2 order-1' }}">
                <img src="{{ $research_catalogue->image }}" class="w-100" alt="">
            </div>
        </div>

        <div class="d-none d-md-flex row align-items-center gy-4">
            <div
                class="col-md-6 {{ $private_sector->image_position == 'Right' ? 'order-md-2 order-1' : 'order-md-1 order-2' }}">
                <img src="{{ $private_sector->image }}" class="w-100" alt="">
            </div>
            <div
                class="col-md-6 {{ $private_sector->image_position == 'Right' ? 'order-md-1 order-2' : 'order-md-2 order-1' }}">
                <img src="{{ asset('frontend/images/ornament.svg') }}" alt="">
                <h3 class="home-title title">
                    {{ $private_sector->title ?? 'Private Sector Platform' }}
                </h3>
                <p class="rcs-description text-20 my-4">
                    {{ $private_sector->description ?? 'The Private Sector Platform (PSP) aims to promote good practices and innovative actions to reduce plastic waste taken by the private sector operating in ASEAN+3 region.' }}
                </p>
                @foreach ($private_sector->private_detail as $value)
                    <div class="d-flex gap-3 align-items-center mb-3">
                        <div>
                            <i class="ico"
                                style="background: url('{{ $value->icon }}') no-repeat center center/contain;width: 32px;height: 32px;"></i>
                        </div>
                        <div class="text-20 rcs-description">{{ $value->label }}</div>
                    </div>
                @endforeach

                @if ($private_sector->button_text && $private_sector->button_link)
                    <a href="{{ $private_sector->button_link }}"
                        class="btn btn-outline-warning btn-discover-homepage">{{ $private_sector->button_text }}</a>
                @endif
            </div>
        </div>

        <div class="d-md-none row align-items-center gy-4">
            <div class="col-md-6 {{ 'order-md-2 order-1' }}">
                <img src="{{ $private_sector->image }}" class="w-100" alt="">
            </div>
            <div class="col-md-6 {{ 'order-md-1 order-2' }}">
                <img src="{{ asset('frontend/images/ornament.svg') }}" alt="">
                <h3 class="home-title title">
                    {{ $private_sector->title ?? 'Private Sector Platform' }}
                </h3>
                <p class="rcs-description text-20 my-4">
                    {{ $private_sector->description ?? 'The Private Sector Platform (PSP) aims to promote good practices and innovative actions to reduce plastic waste taken by the private sector operating in ASEAN+3 region.' }}
                </p>
                @foreach ($private_sector->private_detail as $value)
                    <div class="d-flex gap-3 align-items-center mb-3">
                        <div>
                            <i class="ico"
                                style="background: url('{{ $value->icon }}') no-repeat center center/contain;width: 32px;height: 32px;"></i>
                        </div>
                        <div class="text-20 rcs-description">{{ $value->label }}</div>
                    </div>
                @endforeach

                @if ($private_sector->button_text && $private_sector->button_link)
                    <a href="{{ $private_sector->button_link }}"
                        class="btn btn-outline-warning btn-discover-homepage">{{ $private_sector->button_text }}</a>
                @endif
            </div>
        </div>
    </div>
</section>
