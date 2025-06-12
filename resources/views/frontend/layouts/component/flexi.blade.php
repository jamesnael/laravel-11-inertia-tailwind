<div class="flexi-wrapper m-0 p-0">
    @foreach ($section as $key => $content)
        @if ($loop->first)
            {{-- Paragraph --}}
            @if ($content['tipe'] == 'Paragraph')
                @php
                    if (isset($ispublication) && $ispublication == true) {
                        $defaultmarginbottom = 'margin-bottom:56px';
                    } else {
                        $defaultmarginbottom = 'margin-bottom:48px';
                    }
                @endphp

                @if ($content['title'] != '')
                    <{{ $content['title_size'] }} style="{{ $defaultmarginbottom }}">
                        {{ $content['title'] }}
                        </{{ $content['title_size'] }}>
                @endif
                {!! $content['content'] !!}

                @if (count($content['details']) > 0)
                    <div class="list-w-icon">
                        @foreach ($content['details'] as $detail)
                            <div class="item-list">
                                <div>
                                    <img src="{{ $detail['icon'] }}" alt="{{ $detail['title'] }}">
                                </div>
                                <div class="ps-4">
                                    <h5>{{ $detail['title'] }}</h5>
                                    
                                    <p class="mb-3">
                                        {{ $detail['description'] }}
                                    </p>

                                    @if(isset($detail['button_label']) && isset($detail['button_url']))
                                        <a href="{{ $detail['button_url'] }}" target="_blank" class="paragraph-detail-button">{{ $detail['button_label'] }}</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif

            {{-- Pull Quote --}}
            @if ($content['tipe'] == 'Pull Quote')
                <blockquote class="type-2 position-relative my-5 flexi-pull-quote" style="z-index: 1">
                    <h4>
                        {{ $content['quote'] }}
                    </h4>
                </blockquote>
            @endif

            {{-- Quote --}}
            @if ($content['tipe'] == 'Quote')
                <blockquote class="my-5">
                    <h4 class="flexi-quote">
                        {{ $content['quote'] }}
                    </h4>
                </blockquote>
                <p class="flexi-quote-author">{{ $content['author'] }}</p>
            @endif

            {{-- Table --}}
            @if ($content['tipe'] == 'Table')
                @php
                    $table = str_replace('colwidth', 'width', $content['content']);
                    $table = str_replace('table', 'table class="table table-striped"', $table);
                @endphp
                <div class="table-responsive flexi-table">
                    {!! $table !!}
                </div>
            @endif

            {{-- Media - Video --}}
            @if ($content['tipe'] == 'Video')
                @php
                    $youtube_id = explode('=', $content['video'])[1] ?? '';
                    $youtube_link = 'https://www.youtube.com/embed/' . $youtube_id . '?autoplay=0&playinfo=0&rel=0';
                    $video_url = $youtube_link;
                @endphp
                <div class="video-container pb-3" style="border-radius: 0">
                    <iframe width="100%" height="100%" src="{{ $video_url }}" title="Video Player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
                @if ($content['source'] != '')
                    <figure>{{ $content['source'] }}</figure>
                @endif
            @endif

            {{-- Media - Image --}}
            @if ($content['tipe'] == 'Image')
                <div class="image-container">
                    <a href="{{ $content['image'] }}" target="_blank">
                        <img src="{{ $content['image'] }}" alt="{{ $content['title'] }}">
                    </a>
                </div>
                @if ($content['source'] != '')
                    <figure class="flexi-image-caption">{{ $content['source'] }}</figure>
                @endif
                @php
                    $isNextTableOrHistory = false;
                    if (!$loop->last && ($section[$key + 1]['tipe'] == 'Table' || $section[$key + 1]['tipe'] == 'history')) {
                        $isNextTableOrHistory = true;
                    }
                @endphp
            @endif

            {{-- FAQ --}}
            @if ($content['tipe'] == 'FAQ')
                <h2>Frequently Asked Questions</h2>

                {{-- check for any specific layout change --}}
                @php
                    $style = '';
                    if (isset($isActorDetail) || isset($isEprDetail)) {
                        $style = 'background: #fff;';
                    }
                @endphp

                <div class="accordion accordion-flush pb-2" id="faqData{{ $content['id'] }}">
                    @foreach ($content['detail'] as $detail)
                        <div class="accordion-item">
                            <h5 class="accordion-header">
                                <button class="accordion-button faq-accordion collapsed" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapse{{ $loop->iteration }}{{ $content['id'] }}"
                                    aria-expanded="false"
                                    aria-controls="flush-collapse{{ $loop->iteration }}{{ $content['id'] }}"
                                    style="{{ $style }}">
                                    {{ $detail['question'] }}
                                </button>
                            </h5>
                            <div id="flush-collapse{{ $loop->iteration }}{{ $content['id'] }}"
                                class="accordion-collapse collapse" data-bs-parent="#faqData{{ $content['id'] }}">
                                <div class="accordion-body" style="{{ $style }}">
                                    {{ $detail['answer'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- REFERENCES --}}
            @if ($content['tipe'] == 'Reference')
                @php
                    $refClass = '';
                    if (isset($isActorDetail) || isset($isEprDetail) || isset($isPlasticMangroveDetail)) {
                        $refClass = 'organization-reference';
                    }
                @endphp

                <div class="{{ $refClass }} accordion reference" id="referenceData{{ $content['id'] }}">
                    @foreach ($content['detail'] as $detail)
                        <div class="accordion-item my-3">
                            <h5 class="accordion-header">
                                <button class="accordion-button p-4 collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#reference{{ $detail['id'] }}" aria-expanded="false"
                                    aria-controls="reference{{ $detail['id'] }}">
                                    {{ $detail['title'] }}
                                </button>
                            </h5>
                            <div id="reference{{ $detail['id'] }}" class="accordion-collapse collapse"
                                data-bs-parent="#referenceData{{ $content['id'] }}">
                                <div class="accordion-body p-4">
                                    {!! $detail['content'] !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @else
            {{-- check for margin change for any specific layout --}}
            @php
                $topMarginClass = 'flexi-mt-60';
                if (isset($isActorDetail) || isset($isEprDetail) || isset($isPlasticMangroveDetail) || isset($isPracticalMeasure)) {
                    $topMarginClass = 'flexi-mt-56';
                }
            @endphp

            {{-- Paragraph --}}
            @if ($content['tipe'] == 'Paragraph')
                @php
                    if (isset($ispublication) && $ispublication == true) {
                        $defaultmarginbottom = 'margin-bottom:56px';
                    } else {
                        $defaultmarginbottom = 'margin-bottom:48px';
                    }
                @endphp

                <div class="{{ $topMarginClass }} flexi-paragraph">
                    @if ($content['title'] != '')
                        <{{ $content['title_size'] }} style="{{ $defaultmarginbottom }}">
                            {{ $content['title'] }}
                            </{{ $content['title_size'] }}>
                    @endif
                    {!! $content['content'] !!}

                    @if (count($content['details']) > 0)
                        <div class="list-w-icon">
                            @foreach ($content['details'] as $detail)
                                <div class="item-list">
                                    <div>
                                        <img src="{{ $detail['icon'] }}" alt="{{ $detail['title'] }}">
                                    </div>
                                    <div class="ps-4">
                                        <h5>{{ $detail['title'] }}</h5>
                                        <p class="paragraph-detail-desc">
                                            {{ $detail['description'] }}
                                        </p>
                                        @if(isset($detail['button_label']) && isset($detail['button_url']))
                                            <a href="{{ $detail['button_url'] }}" class="see-more">{{ $detail['button_label'] }}</a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            {{-- Pull Quote --}}
            @if ($content['tipe'] == 'Pull Quote')
                <div class="{{ $topMarginClass }}">
                    <blockquote class="type-2 position-relative my-5 flexi-pull-quote" style="z-index: 1">
                        <h4>
                            {{ $content['quote'] }}
                        </h4>
                    </blockquote>
                </div>
            @endif

            {{-- Quote --}}
            @if ($content['tipe'] == 'Quote')
                <div class="{{ $topMarginClass }}">
                    <blockquote class="my-5">
                        <h4 class="flexi-quote">
                            {{ $content['quote'] }}
                        </h4>
                    </blockquote>
                    <p class="flexi-quote-author">{{ $content['author'] }}</p>
                </div>
            @endif

            {{-- Table --}}
            @if ($content['tipe'] == 'Table')
                <div class="{{ $topMarginClass }}">
                    @php
                        $table = str_replace('colwidth', 'width', $content['content']);
                        $table = str_replace('table', 'table class="table table-striped"', $table);
                    @endphp
                    <div class="table-responsive flexi-table">
                        {!! $table !!}
                    </div>
                </div>
            @endif

            {{-- Media - Video --}}
            @if ($content['tipe'] == 'Video')
                <div class="{{ $topMarginClass }}">
                    @php
                        $youtube_id = explode('=', $content['video'])[1] ?? '';
                        $youtube_link = 'https://www.youtube.com/embed/' . $youtube_id . '?autoplay=0&playinfo=0&rel=0';
                        $video_url = $youtube_link;
                    @endphp
                    <div class="video-container pb-3" style="border-radius: 0">
                        <iframe width="100%" height="100%" src="{{ $video_url }}" title="Video Player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                    @if ($content['source'] != '')
                        <figure>{{ $content['source'] }}</figure>
                    @endif
                </div>
            @endif

            {{-- Media - Image --}}
            @if ($content['tipe'] == 'Image')
                <div class="{{ $topMarginClass }}">
                    <div class="image-container">
                        <a href="{{ $content['image'] }}" target="_blank">
                            <img src="{{ $content['image'] }}" alt="{{ $content['title'] }}">
                        </a>
                    </div>
                    @if ($content['source'] != '')
                        <figure class="flexi-image-caption">{{ $content['source'] }}</figure>
                    @endif
                    @php
                        $isNextTableOrHistory = false;
                        if (!$loop->last && ($section[$key + 1]['tipe'] == 'Table' || $section[$key + 1]['tipe'] == 'history')) {
                            $isNextTableOrHistory = true;
                        }
                    @endphp
                </div>
            @endif

            {{-- FAQ --}}
            @if ($content['tipe'] == 'FAQ')
                <div class="{{ $topMarginClass }}">
                    <h2>Frequently Asked Questions</h2>

                    @php
                        $style = '';
                        if (isset($isActorDetail) || isset($isEprDetail) || isset($isNewsDetail)) {
                            $style = 'background: #fff !important;';
                        }
                    @endphp

                    <div class="accordion accordion-flush pb-2" id="faqData{{ $content['id'] }}">
                        @foreach ($content['detail'] as $detail)
                            <div class="accordion-item">
                                <h5 class="accordion-header">
                                    <button
                                        class="accordion-button faq-accordion collapsed faq-question"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapse{{ $loop->iteration }}{{ $content['id'] }}"
                                        aria-expanded="false"
                                        aria-controls="flush-collapse{{ $loop->iteration }}{{ $content['id'] }}"
                                        style="{{ $style }}"
                                    >
                                        {{ $detail['question'] }}
                                    </button>
                                </h5>
                                <div
                                    id="flush-collapse{{ $loop->iteration }}{{ $content['id'] }}"
                                    class="accordion-collapse collapse"
                                    data-bs-parent="#faqData{{ $content['id'] }}"
                                >
                                    <div class="accordion-body faq-answer" style="{{ $style }}">
                                        {{ $detail['answer'] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- REFERENCES --}}
            @if ($content['tipe'] == 'Reference')
                @php
                    $refClass = '';
                    if (isset($isActorDetail) || isset($isEprDetail) || isset($isPlasticMangroveDetail)) {
                        $refClass = 'organization-reference';
                    }
                @endphp

                <div class="{{ $topMarginClass }}">
                    <div class="{{ $refClass }} accordion reference" id="referenceData{{ $content['id'] }}">
                        @foreach ($content['detail'] as $detail)
                            <div class="accordion-item my-3" data-show="#reference{{ $detail['id'] }}">
                                <h5 class="accordion-header">
                                    <button class="accordion-button p-4 collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#reference{{ $detail['id'] }}"
                                        aria-expanded="false" aria-controls="reference{{ $detail['id'] }}">
                                        {{ $detail['title'] }}
                                    </button>
                                </h5>
                                <div id="reference{{ $detail['id'] }}" class="accordion-collapse collapse"
                                    data-bs-parent="#referenceData{{ $content['id'] }}">
                                    <div class="accordion-body p-4 accordion-reference">
                                        {!! $detail['content'] !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    @endforeach
</div>
