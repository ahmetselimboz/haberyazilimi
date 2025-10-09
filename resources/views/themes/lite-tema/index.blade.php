@extends('themes.' . $theme . '.frontend_layout')


@section('meta')
    <title>{{ $settings['title'] }}</title>

    <meta name="description" content="{{ $settings['description'] }}">
    <meta name="keywords" content="{{ $magicbox['keywords'] }}">

    <meta property="og:title" content="{{ $settings['title'] }}" />
    <meta property="og:description" content="{{ $settings['description'] }}" />
    <meta property="og:image" content="{{ asset('uploads/' . $settings['logo']) }}" />
    <meta property="og:url" content="{{ 'https://' . $_SERVER['HTTP_HOST'] }}" />
    <meta property="og:type" content="website" />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@if (isset($magicbox['tw_name'])) {{ $magicbox['tw_name'] }} @endif" />
    <meta name="twitter:title" content="{{ $settings['title'] }}" />
    <meta name="twitter:description" content="{{ $settings['description'] }}" />
    <meta name="twitter:image" content="{{ asset('uploads/' . $settings['logo']) }}" />

    <script type="application/ld+json">{"@context": "https://schema.org/", "@type": "WebPage","@id": "#WebPage", "url": "{{ 'https://'.$_SERVER['HTTP_HOST'] }}", "name": "{{ $settings['title'] }}"}</script>
@endsection

@section('content')
    @php
        $sortabeJson = \Illuminate\Support\Facades\Storage::disk('public')->json('main/sortable_list.json');
    @endphp

    @if (!blank($sortabeJson))
        @foreach ($sortabeJson as $block)
            @if ($block['type'] == 'main')
                @if ($block['file'] == 'block_son_dakika')
                    @include($theme_path . '.main.block_son_dakika')
                    @continue
                @endif
                @if ($block['file'] == 'block_dortlu_manset')
                    @include($theme_path . '.main.block_stories')
                    @include($theme_path . '.main.block_dortlu_manset')
                    @continue
                @endif

                @if ($block['file'] == 'block_ana_manset')
                    @include($theme_path . '.main.block_ana_manset')
                    @continue
                @endif

                @if (\Illuminate\Support\Facades\View::exists($theme_path . '.main.' . $block['file']))
                    @include($theme_path . '.main.' . $block['file'],  ['design' => $block["design"],'block_id' => $block["id"],'block_category_id' => $block["category"],'limit'=>$block["limit"]])
                @endif
            @endif
        @endforeach
    @endif



    <!-- Firmalar Modülü -->
    {{-- <section class="max-w-7xl mx-auto lg:px-5 px-2 py-4">
        <div class="flex items-center justify-between gap-2 mb-8">
            <div class="">
                <h2 class="text-2xl md:text-3xl font-bold lite-text-primary mb-2">Firmalar</h2>
                <div class="w-16 h-1 lite-bg-accent rounded-full"></div>
            </div>
            <div class="flex items-center gap-2">
                <a href="#" class="lite-btn underline lite-btn-ghost lite-btn-md">Tümünü Gör</a>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="#"
                class="lite-bg-accent rounded-lg border p-4 lite-border overflow-hidden group hover:shadow-lg transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between mb-2 gap-2">
                    <div
                        class="w-24 h-24 rounded-lg overflow-hidden border-2 lite-border group-hover:lite-accent-border transition-all duration-300">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face"
                            alt="Dr. Mehmet Yılmaz"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <div class="">
                        <h3 class="font-semibold lite-text-third mb-2">Lite Yazılım A.Ş.</h3>
                    </div>
                </div>
                <p class="lite-text-third font-light text-sm">Lite Yazılım A.Ş. için yenilikçi yazılım çözümleri
                    sunan, sektörde öncü bir firmadır.</p>

            </a>
            <a href="#"
                class="lite-bg-accent rounded-lg border p-4 lite-border overflow-hidden group hover:shadow-lg transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between mb-2 gap-2">
                    <div
                        class="w-24 h-24 rounded-lg overflow-hidden border-2 lite-border group-hover:lite-accent-border transition-all duration-300">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face"
                            alt="Dr. Mehmet Yılmaz"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <div class="">
                        <h3 class="font-semibold lite-text-third mb-2">Lite Yazılım A.Ş.</h3>
                    </div>
                </div>
                <p class="lite-text-third font-light text-sm">Lite Yazılım A.Ş. için yenilikçi yazılım çözümleri
                    sunan, sektörde öncü bir firmadır.</p>

            </a>
            <a href="#"
                class="lite-bg-accent rounded-lg border p-4 lite-border overflow-hidden group hover:shadow-lg transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between mb-2 gap-2">
                    <div
                        class="w-24 h-24 rounded-lg overflow-hidden border-2 lite-border group-hover:lite-accent-border transition-all duration-300">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face"
                            alt="Dr. Mehmet Yılmaz"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <div class="">
                        <h3 class="font-semibold lite-text-third mb-2">Lite Yazılım A.Ş.</h3>
                    </div>
                </div>
                <p class="lite-text-third font-light text-sm">Lite Yazılım A.Ş. için yenilikçi yazılım çözümleri
                    sunan, sektörde öncü bir firmadır.</p>

            </a>
            <a href="#"
                class="lite-bg-accent rounded-lg border p-4 lite-border overflow-hidden group hover:shadow-lg transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between mb-2 gap-2">
                    <div
                        class="w-24 h-24 rounded-lg overflow-hidden border-2 lite-border group-hover:lite-accent-border transition-all duration-300">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face"
                            alt="Dr. Mehmet Yılmaz"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <div class="">
                        <h3 class="font-semibold lite-text-third mb-2">Lite Yazılım A.Ş.</h3>
                    </div>
                </div>
                <p class="lite-text-third font-light text-sm">Lite Yazılım A.Ş. için yenilikçi yazılım çözümleri
                    sunan, sektörde öncü bir firmadır.</p>

            </a>
        </div>
    </section> --}}

    <!-- Mini Anket Modülü -->
    {{-- <section class="max-w-7xl mx-auto lg:px-5 px-2 py-10">
        <div class="flex items-center justify-between mb-6">
            <h3 class="lite-text-primary font-semibold text-lg flex items-center gap-2">
                <i class="ri-bar-chart-2-line lite-text-accent"></i>
                Anketler / Testler
            </h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Mini Poll Item 1 -->
            <div class="lite-bg-secondary border lite-border rounded-lg p-5 lite-mini-poll" data-poll-id="mini1">
                <div class="lite-poll-question text-base mb-3">2025'te en çok hangi içerik formatını tüketiyorsunuz?
                </div>
                <div class="space-y-2 lite-mini-options">
                    <button class="lite-btn lite-btn-outline lite-btn-sm w-full lite-mini-poll-option"
                        data-votes="34">Kısa Video</button>
                    <button class="lite-btn lite-btn-outline lite-btn-sm w-full lite-mini-poll-option"
                        data-votes="22">Uzun Video</button>
                    <button class="lite-btn lite-btn-outline lite-btn-sm w-full lite-mini-poll-option"
                        data-votes="18">Makale</button>
                    <button class="lite-btn lite-btn-outline lite-btn-sm w-full lite-mini-poll-option"
                        data-votes="12">Podcast</button>
                </div>

            </div>

            <!-- Mini Poll Item 2 -->
            <div class="lite-bg-secondary border lite-border rounded-lg p-5 lite-mini-poll" data-poll-id="mini2">
                <div class="lite-poll-question text-base mb-3">Günde ortalama kaç haber okursunuz?</div>
                <div class="space-y-2 lite-mini-options">
                    <button class="lite-btn lite-btn-outline lite-btn-sm w-full lite-mini-poll-option"
                        data-votes="10">1-3</button>
                    <button class="lite-btn lite-btn-outline lite-btn-sm w-full lite-mini-poll-option"
                        data-votes="20">4-7</button>
                    <button class="lite-btn lite-btn-outline lite-btn-sm w-full lite-mini-poll-option"
                        data-votes="12">8-12</button>
                    <button class="lite-btn lite-btn-outline lite-btn-sm w-full lite-mini-poll-option"
                        data-votes="6">12+</button>
                </div>

            </div>

            <!-- Mini Poll Item 3 -->
            <div class="lite-bg-secondary border lite-border rounded-lg p-5 lite-mini-poll" data-poll-id="mini3">
                <div class="lite-poll-question text-base mb-3">Gece modu (dark mode) tercih ediyor musunuz?</div>
                <div class="space-y-2 lite-mini-options">
                    <button class="lite-btn lite-btn-outline lite-btn-sm w-full lite-mini-poll-option"
                        data-votes="28">Evet</button>
                    <button class="lite-btn lite-btn-outline lite-btn-sm w-full lite-mini-poll-option"
                        data-votes="9">Hayır</button>
                    <button class="lite-btn lite-btn-outline lite-btn-sm w-full lite-mini-poll-option"
                        data-votes="7">Farketmez</button>
                </div>

            </div>

            <!-- Mini Poll Item 4 -->
            <div class="lite-bg-secondary border lite-border rounded-lg p-5 lite-mini-poll" data-poll-id="mini4">
                <div class="lite-poll-question text-base mb-3">Haberleri hangi cihazdan takip ediyorsunuz?</div>
                <div class="space-y-2 lite-mini-options">
                    <button class="lite-btn lite-btn-outline lite-btn-sm w-full lite-mini-poll-option"
                        data-votes="30">Mobil</button>
                    <button class="lite-btn lite-btn-outline lite-btn-sm w-full lite-mini-poll-option"
                        data-votes="18">Masaüstü</button>
                    <button class="lite-btn lite-btn-outline lite-btn-sm w-full lite-mini-poll-option"
                        data-votes="8">Tablet</button>
                </div>

            </div>

        </div>
    </section> --}}

    <div class="fixed lg:flex hidden bottom-5 right-5 w-12 h-12 flex items-center justify-center text-2xl lite-text-third cursor-pointer lite-bg-accent border lite-border rounded-full shadow-lg hover:-translate-y-1 z-[1002] transition-all duration-300"
        id="liteWhatsappToggleDesktop">
        <i class="ri-whatsapp-line"></i>
    </div>

    <!-- Whatsapp Davet Popup -->
    <div class="fixed bottom-20 right-5 w-80 lite-bg-secondary border lite-border rounded-lg shadow-lg z-[1002] opacity-0 invisible transform -translate-y-2 transition-all duration-300"
        id="liteWhatsappPopup">
        <div class="px-5 py-4 border-b lite-border text-center font-semibold lite-text-primary">
            Whatsapp kanalımıza katılın!
        </div>
        <div class="px-5 py-5 lite-text-secondary">
            <span class="text-sm text-center">Whatsapp kanalımıza katılın ve güncel haberleri alın!</span>
            <button class="lite-btn lite-btn-primary lite-btn-md lite-btn-full mt-4" id="liteWhatsappSubmit">
                <i class="ri-whatsapp-line"></i>
                Katıl
            </button>
        </div>
    </div>
@endsection
