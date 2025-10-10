<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (isset($magicbox['refresh']))
        <meta http-equiv="refresh" content="{{ $magicbox['refresh'] }}">
    @endif

    @if ($magicbox['noindex'] == 1)
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">
    @endif

    <link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}" />

    @yield('meta')

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('lite_tema/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('lite_tema/css/pagination.css') }}">



    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Slick Slider JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    spacing: {
                        '15': '60px',
                    }
                }
            },
            plugins: [
                function({
                    addUtilities
                }) {
                    addUtilities({
                        '.lite-accent-border': {
                            borderColor: 'var(--lite-accent-border)',
                        },
                        '.lite-bg-accent': {
                            backgroundColor: 'var(--lite-accent-primary)',
                        },
                        '.lite-text-accent': {
                            color: 'var(--lite-accent-primary)',
                        },
                    }, ['responsive', 'hover', 'focus']);
                }
            ]
        }
    </script>

    {!! $magicbox['headcode'] !!}

    @yield('custom_css')
</head>

<body class="font-inter lite-bg-primary lite-text-primary transition-all duration-300">
    {!! $magicbox['bodycode'] !!}
    <!-- Page Loader -->
    <div class="lite-page-loader" id="litePageLoader">
        <div class="lite-loader-content">
            <div class="lite-loader-logo">
                <img src="{{ asset('uploads/' . $settings['logo']) }}" alt="{{ $magicbox['title'] }}" class="lite-logo-light">
                <img src="{{ asset('uploads/' . $settings['logo']) }}" alt="{{ $magicbox['title'] }}" class="lite-logo-dark">
            </div>
            <div class="lite-loader-bar">
                <div class="lite-loader-progress"></div>
            </div>
        </div>
    </div>

    @include('themes.' . $theme . '.inc.header')

    <!-- Ana İçerik Alanı -->
    <main class="mt-12 lg:mt-24">
        @yield('content')
    </main>

    <!-- Comment Modal -->
    {{-- <div id="liteCommentModal"
        class="fixed inset-0 bg-black bg-opacity-50 z-[1005] hidden items-center justify-center p-4">
        <div class="lite-bg-secondary rounded-lg  lg:w-1/2 w-full p-6">
            <div class="flex items-center justify-between mb-6">

                <div class="flex flex-col gap-2">
                    <h3 class="text-xl font-bold lite-text-primary  flex items-center gap-2">

                        <i class="ri-chat-3-line lite-text-accent"></i>
                        Tüm Yorumlar (12)

                    </h3>
                    <div class="w-16 h-1 lite-bg-accent rounded-full"></div>
                </div>


                <button id="liteCommentModalClose" class="lite-hover-accent p-2 rounded-lg">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <div class="space-y-3 overflow-y-auto max-h-[60vh]">
                <div class="lite-bg-secondary border lite-border rounded-lg p-6">
                    <div class="flex gap-4">
                        <img src="assets/haber-gorsel.png" alt="Commenter"
                            class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h5 class="font-semibold lite-text-primary">Mehmet Kaya</h5>
                                <span class="text-xs lite-text-secondary">2 saat önce</span>
                            </div>
                            <p class="lite-text-primary leading-relaxed lg:text-base text-sm mb-3">
                                Çok kapsamlı bir analiz olmuş. Özellikle sektörel etkilere değinmeniz çok
                                faydalı.
                                2025'te gerçekten büyük değişimler yaşayacağız gibi görünüyor.
                            </p>

                        </div>
                    </div>
                </div>
                <div class="lite-bg-secondary border lite-border rounded-lg p-6">
                    <div class="flex gap-4">
                        <img src="assets/haber-gorsel.png" alt="Commenter"
                            class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h5 class="font-semibold lite-text-primary">Mehmet Kaya</h5>
                                <span class="text-xs lite-text-secondary">2 saat önce</span>
                            </div>
                            <p class="lite-text-primary leading-relaxed lg:text-base text-sm mb-3">
                                Çok kapsamlı bir analiz olmuş. Özellikle sektörel etkilere değinmeniz çok
                                faydalı.
                                2025'te gerçekten büyük değişimler yaşayacağız gibi görünüyor.
                            </p>

                        </div>
                    </div>
                </div>
                <div class="lite-bg-secondary border lite-border rounded-lg p-6">
                    <div class="flex gap-4">
                        <img src="assets/haber-gorsel.png" alt="Commenter"
                            class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h5 class="font-semibold lite-text-primary">Mehmet Kaya</h5>
                                <span class="text-xs lite-text-secondary">2 saat önce</span>
                            </div>
                            <p class="lite-text-primary leading-relaxed lg:text-base text-sm mb-3">
                                Çok kapsamlı bir analiz olmuş. Özellikle sektörel etkilere değinmeniz çok
                                faydalı.
                                2025'te gerçekten büyük değişimler yaşayacağız gibi görünüyor.
                            </p>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div> --}}

    <!-- Footer -->
    @include('themes.' . $theme . '.inc.footer')



    <!-- JavaScript -->
    <script src="{{ asset('lite_tema/js/script.js') }}"></script>

    @if (isset($magicbox['googleanalytics']))
        {!! $magicbox['googleanalytics'] !!}
    @endif

    @if (isset($magicbox['yandexanalytics']))
        {!! $magicbox['yandexanalytics'] !!}
    @endif

    @if (isset($magicbox['yandexmetricaid']))
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function(m, e, t, r, i, k, a) {
                m[i] = m[i] || function() {
                    (m[i].a = m[i].a || []).push(arguments)
                };
                m[i].l = 1 * new Date();
                for (var j = 0; j < document.scripts.length; j++) {
                    if (document.scripts[j].src === r) {
                        return;
                    }
                }
                k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(
                    k, a)
            })
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
            ym({{ $magicbox['yandexmetricaid'] }}, "init", {
                clickmap: true,
                trackLinks: true,
                accurateTrackBounce: true,
                webvisor: true
            });
        </script>
        <noscript>
            <div><img src="https://mc.yandex.ru/watch/{{ $magicbox['yandexmetricaid'] }}"
                    style="position:absolute; left:-9999px;" alt="" /></div>
        </noscript>
        <!-- /Yandex.Metrika counter -->
    @endif

    {!! $magicbox['footercode'] !!}

    @yield('custom_js')
</body>

</html>
