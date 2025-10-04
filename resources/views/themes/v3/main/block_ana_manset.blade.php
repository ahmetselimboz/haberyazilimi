<div class="container">
    <div class="row">

        <div class="col-12 col-lg-8 mb-2">

            @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('main/ana_manset.json'))



                <div class="headline-block overflow-hidden rounded-1">
                    <div id="headlineCarousel" class="carousel" data-bs-ride="carousel" data-ride="carousel">
                        <div class="carousel-inner">

                            @php $sayim = 0; @endphp
                            @php $ana_mansetler = \Illuminate\Support\Facades\Storage::disk('public')->json('main/ana_manset.json'); @endphp
                            @php

                            $slider_data = [];
                                $ad_inserted = false;
                                
                                foreach ($ana_mansetler as $key => $manset) {
                                    if ($key >= 20) {
                                        break;
                                    }
                                    $slider_data[] = [
                                        'type' => 'news',
                                        'data' => $manset,
                                        'original_key' => $key
                                    ];
                                    
                                    if ($key == $magicbox['mansetsabitreklamno'] - 1 && 
                                        $magicbox['mansetsabitreklamno'] != null && 
                                        $ads21 != null && 
                                        adsCheck($ads21->id)) {
                                        $slider_data[] = [
                                            'type' => 'ad',
                                            'data' => adsCheck($ads21->id),
                                            'original_key' => $key
                                        ];
                                        $ad_inserted = true;
                                    }
                                }
                            @endphp

                            @foreach ($slider_data as $manset_key => $item)
                                @if ($magicbox['mansetsabitreklamno'] != null and $ads21 != null and adsCheck($ads21->id))
                                    @if ($sayim > 20)
                                        @break
                                    @endif
                                @endif

                                @php $sayim++; @endphp

                                @if ($item['type'] == 'news')
                                    <a href="{{ route('post', ['categoryslug' => isset($item['data']['categoryslug']) ? $item['data']['categoryslug'] : 'kategorisiz', 'slug' => $item['data']['slug'], 'id' => $item['data']['id']]) }}"
                                        class="externallink" title="{{ html_entity_decode($item['data']['title']) }}">
                                        <div class="carousel-item @if ($manset_key == 0) active @endif ">
                                            <div class="headline-item">

                                                <div class="headline-image"><img width="100%"
                                                        src="{{ route('resizeImage', ['i_url' => $item['data']['images'], 'w' => 777, 'h' => 510]) }}"
                                                        alt="{{ html_entity_decode($item['data']['title']) }}"
                                                        class="lazy"></div>

                                                <div class="headline-title">
                                                    @if (isset($item['data']['show_title_slide']) && $item['data']['show_title_slide'] == 0)
                                                        @if (isset($magicbox['mansetbaslik']) and $magicbox['mansetbaslik'] == 0)
                                                            <h1>{{ \Illuminate\Support\Str::limit(html_entity_decode($item['data']['title']), 150) }}
                                                            </h1>
                                                        @endif
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </a>
                                @elseif ($item['type'] == 'ad')
                                    @php $adsR = $manset_key; @endphp
                                    
                                    @if ($item['data']->type == 1)
                                        {!! $item['data']->code !!}
                                    @else
                                        <a href="{{ $item['data']->url }}" class="externallink"
                                            title="Reklam {{ $ads21->id }}">
                                            <div class="carousel-item @if ($manset_key == 0) active @endif ">
                                                <div class="headline-item">
                                                    <div class="headline-image"><img class="lazy"
                                                            src="{{ $item['data']->images }}"
                                                            alt="Reklam {{ $ads21->id }}"
                                                            data-type="{{ $item['data']->type }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                @endif
                            @endforeach
                            <button class="carousel-control-prev d-flex" type="button">
                                <span class="carousel-control-prev-icon" aria-hidden="true"
                                    data-bs-target="#headlineCarousel" data-bs-slide="prev"></span>
                                <span class="visually-hidden">@lang('frontend.previus')</span>
                            </button>

                            <button class="carousel-control-next d-flex" type="button">
                                <span class="carousel-control-next-icon" aria-hidden="true"
                                    data-bs-target="#headlineCarousel" data-bs-slide="next"></span>
                                <span class="visually-hidden">@lang('frontend.next')</span>
                            </button>
                        </div>

                        <div class="carousel-indicators">
                            @php $sayim = 1; @endphp

                            @foreach ($slider_data as $manset_key_number => $item)
                                @if ($magicbox['mansetsabitreklamno'] != null and $ads21 != null and adsCheck($ads21->id))
                                    @if ($sayim > 20)
                                        @break
                                    @endif
                                    
                                @endif


                                @if ($item['type'] == 'news')
                                    <button type="button" data-bs-config="{'delay':0}" data-bs-target="#headlineCarousel"
                                        data-bs-slide-to="{{ $manset_key_number }}"
                                        @if ($manset_key_number == 0) class="active" aria-current="true" @endif>
                                        {{ $sayim }}
                                    </button>
                                @elseif ($item['type'] == 'ad')
                                @php $sayim--; @endphp

                                    <button type="button" data-bs-config="{'delay':0}" data-bs-target="#headlineCarousel"
                                        data-bs-slide-to="{{ $manset_key_number }}"
                                        @if ($manset_key_number == 0) class="active" aria-current="true" @endif>
                                        R
                                    </button>
                                @endif

                                @php $sayim++; @endphp
                            @endforeach
                        </div>

                    </div>
                </div>
            @else
                <div class="alert alert-warning"> @lang('frontend.slider_not_found')</div>

            @endif

        </div>

        <div class="col-12 col-lg-4 mb-2 d-md-block d-none">
            <div class="spotlar">

                @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('main/mini_manset.json'))
                    @php $mini_mansetler = \Illuminate\Support\Facades\Storage::disk('public')->json('main/mini_manset.json'); @endphp
                    @foreach (collect($mini_mansetler)->take(2) as $minimanset_key => $mini_manset)
                        <div class="spot spotduz spotduztek spotduz-{{ $minimanset_key }}">
                            <a href="{{ route('post', ['categoryslug' => categoryCheck($mini_manset['category_id'])->slug, 'slug' => $mini_manset['slug'], 'id' => $mini_manset['id']]) }}"
                                title="{{ $mini_manset['title'] }}">
                                <b>{{ categoryCheck($mini_manset['category_id'])->title }}</b>
                                <div class="spot-resim"><img
                                        src="{{ route('resizeImage', ['i_url' => $mini_manset['images'], 'w' => 550, 'h' => 307]) }}"
                                        alt="{{ html_entity_decode($mini_manset['title']) }}"
                                        alt="{{ html_entity_decode($mini_manset['title']) }}" /></div>
                                <p><span>{{ html_entity_decode($mini_manset['title']) }}</span></p>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-warning"> @lang('frontend.mini_slider_not_found')</div>
                @endif

            </div>
        </div>

    </div>
</div>

<div class="tmz"></div>

@php
    $keyword1 = isset($magicbox['keyword1']) ? $magicbox['keyword1'] : '';
    $keyword2 = isset($magicbox['keyword2']) ? $magicbox['keyword2'] : '';
    $keyword3 = isset($magicbox['keyword3']) ? $magicbox['keyword3'] : '';
    $keyword4 = isset($magicbox['keyword4']) ? $magicbox['keyword4'] : '';
    $keyword5 = isset($magicbox['keyword5']) ? $magicbox['keyword5'] : '';
    $keyword6 = isset($magicbox['keyword6']) ? $magicbox['keyword6'] : '';
@endphp

@if (
    !blank($keyword1) ||
        !blank($keyword2) ||
        !blank($keyword3) ||
        !blank($keyword4) ||
        !blank($keyword5) ||
        !blank($keyword6))
    <style>
        .home-tags {
            border-radius: 10px;
            background-color: #93C225;
            width: 100%;
            color: white;
            text-transform: uppercase;
            transition: .1s ease-in-out;
        }

        .home-tags:hover {
            color: white;
            background-color: #6b8d19;

        }
    </style>
    <div class="container">
        <div class="row mb-4 mt-md-0 mt-4">
            <div class="col-6 col-md-2 mb-3">
                <a href="{{ route('search.get', ['search' => slug_format(trim($keyword1))]) }}"
                    class="home-tags externallink btn keyword-search d-flex align-items-center justify-content-center h-100">
                    #{{ trim($keyword1) }}
                </a>
            </div>
            <div class="col-6 col-md-2 mb-3">
                <a href="{{ route('search.get', ['search' => slug_format(trim($keyword2))]) }}"
                    class="home-tags externallink btn keyword-search d-flex align-items-center justify-content-center h-100">
                    #{{ trim($keyword2) }}
                </a>
            </div>
            <div class="col-6 col-md-2 mb-3">
                <a href="{{ route('search.get', ['search' => slug_format(trim($keyword3))]) }}"
                    class="home-tags externallink btn keyword-search d-flex align-items-center justify-content-center h-100">
                    #{{ trim($keyword3) }}
                </a>
            </div>
            <div class="col-6 col-md-2 mb-3">
                <a href="{{ route('search.get', ['search' => slug_format(trim($keyword4))]) }}"
                    class="home-tags externallink btn keyword-search d-flex align-items-center justify-content-center h-100">
                    #{{ trim($keyword4) }}
                </a>
            </div>
            <div class="col-6 col-md-2 mb-3">
                <a href="{{ route('search.get', ['search' => slug_format(trim($keyword5))]) }}"
                    class="home-tags externallink btn keyword-search d-flex align-items-center justify-content-center h-100">
                    #{{ trim($keyword5) }}
                </a>
            </div>
            <div class="col-6 col-md-2 mb-3">
                <a href="{{ route('search.get', ['search' => slug_format(trim($keyword6))]) }}"
                    class="home-tags externallink btn keyword-search d-flex align-items-center justify-content-center h-100">
                    #{{ trim($keyword6) }}
                </a>
            </div>
        </div>
    </div>
@endif
@php
    $social_media_link1 = isset($magicbox['social_media_link1']) ? $magicbox['social_media_link1'] : null;
    $social_media_link2 = isset($magicbox['social_media_link2']) ? $magicbox['social_media_link2'] : null;
@endphp

@if (!blank($social_media_link1) || !blank($social_media_link2))

    <div class="container">

        @if (!blank($social_media_link1) || !blank($social_media_link2))
            <div class="row">
                <div class="col-12">
                    <div class="news-headline-block justify-content-between mb-4"> <!--Block Başlık-->
                        <h2 class="text-black">@lang('frontend.sossial_media_content')</h2>
                        <div class="headline-block-indicator">
                            <div class="indicator-ball" style="background-color:#EC0000;"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row mb-4">
            @if (!blank($social_media_link1))
                <div class="col-6 col-md-6">
                    <div class="py-2 px-1 border-bottom border-info overflow-hidden video-link">
                        {!! $social_media_link1 !!}
                    </div>
                </div>
            @endif

            @if (!blank($social_media_link2))
                <div class="col-6 col-md-6">
                    <div class="py-2 px-1 border-bottom border-warning overflow-hidden video-link">
                        {!! $social_media_link2 !!}
                    </div>
                </div>
            @endif

        </div>

    </div>

@endif
