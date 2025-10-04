@if (isset($design))
    @if ($design == 'default' or $design == 0)

        @if (isset($magicbox['notifynewsbox']))
            @if ($magicbox['notifynewsbox'] == 1)
                <style>
                    .news-popup-mobile {
                        backdrop-filter: blur(5px);
                    }

                    #newsSubscription {
                        display: none !important;
                    }

                    .news-popup {
                        position: fixed;
                        right: 0;
                        bottom: 0;
                        z-index: 99999;
                        border-radius: 15px;
                        box-shadow: 0 0 15px 3px #00000075;
                        overflow: hidden;
                    }

                    .news-popup .modal-content {
                        border: none;
                        border-radius: 20px;
                        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
                        overflow: hidden;
                    }

                    .popup-header {
                        background-color: #93C225;
                        color: white;
                        padding: 30px 10px 30px 10px;
                        text-align: center;
                        position: relative;
                    }

                    .popup-header::before {
                        content: '';
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                    }

                    .popup-header-mobile {
                        background: #93C225;
                        color: white;
                        padding: 50px 10px 10px 10px;
                        text-align: center;
                        position: relative;
                    }

                    .popup-header-mobile::before {
                        content: '';
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><defs><radialGradient id="a" cx="50%" cy="0%" r="100%"><stop offset="0%" stop-color="white" stop-opacity="0.1"/><stop offset="100%" stop-color="white" stop-opacity="0"/></radialGradient></defs><rect width="100" height="20" fill="url(%23a)"/></svg>');
                    }

                    .popup-header i {
                        font-size: 1rem;

                        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
                    }

                    .popup-header-mobile i {
                        font-size: 1.2rem;

                        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
                    }

                    .popup-header h4 {
                        font-weight: 700;
                        margin-bottom: 10px;
                        font-size: 1.5rem;
                    }

                    .popup-header p {
                        opacity: 0.9;
                        margin-bottom: 0;
                        font-size: 1rem;
                    }

                    .popup-body {
                        padding: 20px 20px 40px 20px;
                        background: white;
                    }

                    .form-floating {
                        margin-bottom: 20px;
                        width: 100%;
                    }

                    .form-floating>.form-control {
                        border: 2px solid #e9ecef;
                        border-radius: 12px;
                        padding: 1rem 0.75rem;
                        transition: all 0.3s ease;
                    }

                    .form-floating>.form-control:focus {
                        border-color: #4CAF50;
                        box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.1);
                    }

                    .form-floating>label {
                        color: #6c757d;
                        font-weight: 500;
                        font-size: 12px;
                    }

                    .divider {
                        text-align: center;
                        margin: 25px 0;
                        position: relative;
                    }

                    .divider::before {
                        content: '';
                        position: absolute;
                        top: 50%;
                        left: 0;
                        right: 0;
                        height: 1px;
                        background: #dee2e6;
                    }

                    .divider span {
                        background: white;
                        padding: 0 20px;
                        color: #6c757d;
                        font-weight: 500;
                        position: relative;
                    }

                    .popup-submit-btn {
                        background: #93C225;
                        border: none;
                        border-radius: 12px;
                        padding: 10px 30px;
                        font-weight: 600;
                        font-size: .9rem;
                        transition: all 0.3s ease;
                        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
                    }

                    .popup-submit-btn:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
                        background: linear-gradient(135deg, #45a049, #4CAF50);
                    }

                    .popup-submit-btn:disabled {
                        opacity: 0.7;
                        transform: none;
                        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
                    }

                    .popup-close-btn {
                        position: absolute;
                        top: 15px;
                        right: 20px;
                        background: rgba(255, 255, 255, 0.2);
                        border: none;
                        color: white;
                        width: 20px;
                        height: 20px;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        transition: all 0.3s ease;
                    }

                    .popup-close-btn-mobile:hover {
                        background: rgba(255, 255, 255, 0.3);
                        transform: rotate(90deg);
                    }

                    .popup-close-btn-mobile {
                        position: absolute;
                        top: 15px;
                        right: 20px;
                        background: rgba(255, 255, 255, 0.2);
                        border: none;
                        color: white;
                        width: 25px;
                        height: 25px;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        transition: all 0.3s ease;
                    }

                    .popup-close-btn:hover {
                        background: rgba(255, 255, 255, 0.3);
                        transform: rotate(90deg);
                    }

                    .loading-spinner {
                        width: 20px;
                        height: 20px;
                        border: 2px solid transparent;
                        border-top: 2px solid white;
                        border-radius: 50%;
                        animation: spin 1s linear infinite;
                    }

                    @keyframes spin {
                        0% {
                            transform: rotate(0deg);
                        }

                        100% {
                            transform: rotate(360deg);
                        }
                    }

                    .success-message {
                        display: none;
                        text-align: center;
                        padding: 40px 20px;
                    }

                    .success-message i {
                        font-size: 4rem;
                        color: #4CAF50;
                        margin-bottom: 20px;
                    }

                    .error-message {
                        color: #dc3545;
                        font-size: 0.875rem;
                        margin-top: 5px;
                        display: none;
                    }

                    @media (max-width: 768px) {
                        .popup-body {
                            padding: 30px 10px;
                        }

                        .popup-header {
                            padding: 25px 15px 15px;
                        }


                        .form-floating>label {

                            font-size: 9px;
                        }
                    }


                    .mobile-news-side-btn {
                        position: fixed;
                        top: 35%;
                        right: 10px;
                        z-index: 1050;
                        border-radius: 5px;
                        background-color: #93C225;
                        border: none;
                        box-shadow: 0 4px 20px rgba(76, 175, 80, 0.4);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        /*transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);*/
                        /*animation: mobile-news-pulse 2s infinite;*/
                    }

                    .button-inner {
                        padding: 25px 15px;
                        position: relative;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .vertical-text {
                        writing-mode: vertical-lr;
                        /*text-orientation: upright;*/
                        color: #fff;
                        font-weight: bold;
                        font-size: 18px;
                        letter-spacing: 8px;
                        text-align: center;
                        line-height: 0;
                        margin: 0;
                        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
                    }

                    .letter {
                        display: inline-block;
                        transition: all 0.3s ease;
                    }

                    .vertical-button-container:hover .letter {
                        color: #3498db;
                        transform: scale(1.05);
                    }

                    .vertical-button-container::before {
                        content: '';
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background: linear-gradient(45deg,
                                rgba(255, 255, 255, 0.1) 0%,
                                transparent 50%,
                                rgba(255, 255, 255, 0.1) 100%);
                        opacity: 0;
                        transition: opacity 0.3s ease;
                    }

                    .vertical-button-container:hover::before {
                        opacity: 1;
                    }

                    /* Responsive tasarım */
                    @media (max-width: 768px) {
                        .vertical-text {
                            font-size: 11px;
                            letter-spacing: 0px;
                        }

                        .vertical-button-container {
                            padding: 15px 6px;
                        }

                        .button-inner {
                            padding: 20px 7px;
                        }
                    }
                </style>

                <button type="button" class="mobile-news-side-btn d-md-none" data-bs-toggle="modal"
                    data-bs-target="#newsSubscriptionMobile" title="Haber Aboneliği">
                    <div class="button-inner">
                        <p class="vertical-text">
                            <span class="letter">H</span>
                            <span class="letter">A</span>
                            <span class="letter">B</span>
                            <span class="letter">E</span>
                            <span class="letter">R</span>
                            <span class="letter"></span>
                            <span class="letter"></span>
                            <span class="letter">B</span>
                            <span class="letter">İ</span>
                            <span class="letter">L</span>
                            <span class="letter">D</span>
                            <span class="letter">İ</span>
                            <span class="letter">R</span>
                            <span class="letter">İ</span>
                            <span class="letter">M</span>
                            <span class="letter">İ</span>
                        </p>
                    </div>
                </button>
                <div class="modal fade news-popup-mobile d-md-none " id="newsSubscriptionMobile" tabindex="-1"
                    aria-labelledby="newsSubscriptionModalLabel" aria-hidden="true" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 overflow-hidden">
                            <div class="popup-header-mobile">
                                <button type="button" class="popup-close-btn-mobile" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="fa fa-times"></i>
                                </button>
                                <i class="fas fa-newspaper"></i>

                                <p style="font-size: 18px;">Haberler Mail veya WhatsApp olarak gelsin!</p>
                            </div>

                            <div class="popup-body">
                                <form id="subscriptionFormMobile">
                                    <span class="text-muted text-center d-block mb-2">Mail ya da Whatsapp için telefon
                                        numarası giriniz</span>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="form-floating">
                                                <input type="email" class="form-control" id="emailInputMobile"
                                                    placeholder="E-posta adresiniz">
                                                <label for="emailInput"><i class="fa fa-envelope me-2"></i>E-posta
                                                    Adresiniz</label>
                                                <div class="error-message" id="emailError"></div>
                                            </div>
                                            <div class="form-floating">
                                                <input type="tel" class="form-control" id="phoneInputMobile"
                                                    placeholder="WhatsApp için telefon numarası">
                                                <label for="phoneInput"><i class="fa fa-whatsapp me-2"></i>WhatsApp için
                                                    Telefon Numarası</label>
                                                <div class="error-message" id="phoneError"></div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success popup-submit-btn">
                                            <span class="btn-text">
                                                <i class="fa fa-paper-plane me-2"></i>Gönder
                                            </span>
                                            <div class="loading-spinner d-none"></div>
                                        </button>
                                    </div>

                                    <div class="error-message text-center mt-3" id="generalErrorMobile"></div>
                                </form>

                                <div class="success-message" id="successMessageMobile">
                                    <i class="fa fa-check-circle"></i>
                                    <h5 class="text-success mb-3">Başarılı!</h5>
                                    <p class="text-muted">Aboneliğiniz başarıyla oluşturuldu. Artık güncel haberlerden
                                        haberdar olacaksınız!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="news-popup d-none d-md-block" id="newsSubscription">
                    <div class="popup-header">
                        <button type="button" class="popup-close-btn">
                            <i class="fa fa-times"></i>
                        </button>
                        <i class="fas fa-newspaper"></i>

                        <p>Haberler Mail veya WhatsApp olarak gelsin!</p>
                    </div>

                    <div class="popup-body">
                        <form id="subscriptionForm">
                            <span class="text-muted text-center d-block mb-2">Mail ya da Whatsapp için telefon numarası
                                giriniz</span>

                            <div class="form-floating">
                                <input type="email" class="form-control" id="emailInput"
                                    placeholder="E-posta adresiniz">
                                <label for="emailInput"><i class="fa fa-envelope me-2"></i>E-posta Adresiniz</label>
                                <div class="error-message" id="emailError"></div>
                            </div>

                            <!--<div class="divider">-->
                            <!--    <span>ya da</span>-->
                            <!--</div>-->

                            <div class="form-floating">
                                <input type="tel" class="form-control" id="phoneInput"
                                    placeholder="WhatsApp için telefon numarası">
                                <label for="phoneInput"><i class="fa fa-whatsapp me-2"></i>WhatsApp için Telefon
                                    Numarası</label>
                                <div class="error-message" id="phoneError"></div>
                            </div>



                            <div class="d-grid">
                                <button type="submit" class="btn btn-success popup-submit-btn">
                                    <span class="btn-text">
                                        <i class="fa fa-paper-plane me-2"></i>Gönder
                                    </span>
                                    <div class="loading-spinner d-none"></div>
                                </button>
                            </div>

                            <div class="error-message text-center mt-3" id="generalError"></div>
                        </form>

                        <div class="success-message" id="successMessage">
                            <i class="fa fa-check-circle"></i>
                            <h5 class="text-success mb-3">Başarılı!</h5>
                            <p class="text-muted">Aboneliğiniz başarıyla oluşturuldu. <br /> Artık güncel haberlerden
                                haberdar olacaksınız!</p>
                        </div>
                    </div>
                </div>
            @endif
        @endif



        <style>
            .menu {
                list-style: none;
                padding-left: 0;
                margin: 0;
            }

            .menu-item {
                margin-bottom: 8px;
            }

            .menu-link {
                display: block;
                padding: 8px 12px;

                color: #333;
                text-decoration: none;
                transition: background-color 0.3s ease;
                cursor: pointer;
            }

            .menu-link:hover {
                background-color: #eee;
            }


            .submenu {
                display: none;
                /* Başta gizli */
                list-style: none;
                padding-left: 15px;
                margin-top: 5px !important;
            }

            .submenu-item {
                margin-bottom: 5px;
            }

            .submenu-link {
                display: block;
                padding: 6px 10px !important;
                color: #555;
                text-decoration: none;
                transition: background-color 0.2s ease;
                display: flex;

                align-items: center;
            }

            .submenu-link:hover {
                background-color: #eee;
            }

            .menu-empty {
                color: #999;
                font-style: italic;
            }

            .has-children {
                width: 50%;
            }

            .click-menu {

                cursor: pointer;

            }

            .click-menu2 {

                cursor: pointer;

            }

            .more-menu button {
                float: left;
                width: 100%;
                /* height: auto; */
                overflow: hidden;
                margin: 0px 0px 0px 0px;
                padding: 15px 0px 15px 0px;
                border: 0px;
                color: #252525;
                font-size: 17px;
                font-weight: 600;
                text-decoration: none;
                text-align: start;
                background-color: #fff;
            }

            .more-menu button:hover {
                background-color: #fff;
            }
        </style>

        @if (isset($magicbox['thintopbar']))
            @if ($magicbox['thintopbar'] == 1)
                <style>
                    .top-bar-menu {
                        opacity: 1;
                        display: flex;
                        align-items: center;
                        height: auto;
                    }

                    .top-bar-menu:hover {
                        opacity: 0.8;
                    }

                    @media (max-width: 768px) {
                        .top-bar-menu {
                            height: 16px;
                        }
                    }

                    .top-bar-ul {
                        list-style: none;
                        font-size: 14px;
                        font-weight: 600
                    }

                    @media (max-width: 768px) {
                        .top-bar-ul {
                            font-size: 9px;
                        }
                    }

                    .blinking-circle {

                        font-size: 16px;
                        animation: blink 1s infinite;
                    }

                    @keyframes blink {

                        0%,
                        100% {
                            opacity: 1;
                        }

                        50% {
                            opacity: 0.5;
                        }
                    }
                </style>

                <div style="background-color:#0A74B7;">
                    <div class="container">
                        <div class="row flex-row justify-content-between">
                            <div style="width:fit-content" class="px-md-2 p-0 d-flex align-items-center">
                                <ul class="d-flex my-2 p-0" style="list-style: none;font-size:14px;">
                                    <li>
                                        <a href="{{ $magicbox['fb'] }}" target="_blank"
                                            class="text-white px-2 border-end"><i class="fa fa-facebook"></i></a>
                                    </li>
                                    <li>
                                        <a href="{{ $magicbox['tw'] }}" target="_blank"
                                            class="text-white px-2 border-end"><i class="fa fa-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="{{ $magicbox['in'] }}" target="_blank"
                                            class="text-white px-2 border-end"><i class="fa fa-instagram"></i></a>
                                    </li>
                                    <li>
                                        <a href="{{ $magicbox['yt'] }}" target="_blank"
                                            class="text-white px-2 border-end"><i class="fa fa-youtube"></i></a>
                                    </li>
                                    <li>
                                        <a href="{{ $magicbox['ln'] }}" target="_blank" class="text-white px-2"><i
                                                class="fa fa-linkedin"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <div style="width:fit-content " class="px-md-2 p-0 d-flex align-items-center">
                                <ul class="d-flex m-0 p-0 top-bar-ul">
                                    <li class="d-flex align-items-center">
                                        <a href="{{ route('video_galleries') }}" target="_blank"
                                            class="text-white text-uppercase px-2 top-bar-menu border-end">
                                            VİDEO GALERİ
                                        </a>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <a href="{{ route('authors') }}" target="_blank"
                                            class="text-white text-uppercase px-2 top-bar-menu border-end">
                                            YAZARLAR
                                        </a>
                                    </li>
                                    @if (isset($magicbox['live_stream_name']) && isset($magicbox['live_stream_link']))
                                        <li class="d-flex align-items-center">
                                            <a href="{{ $magicbox['live_stream_link'] }} " target="_blank"
                                                class="text-white text-uppercase px-2 top-bar-menu">
                                                <i class="fa fa-play-circle text-danger blinking-circle me-1"></i>
                                                {{ $magicbox['live_stream_name'] }}
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
        @endif

        <div class="header" id="site">
            <div class="container">

                <div class="logo">
                    <a href="{{ route('frontend.index') }}" title="{{ $magicbox['title'] }}"><img
                            src="{{ asset('uploads/' . $settings['logo']) }}" alt="{{ $magicbox['title'] }}" /></a>
                </div>

                <div class="logosag">

                    <div class="ustmenu mobyok">
                        <ul>
                            @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('menu' . $menu_id . '.json'))
                                @php $menus = \Illuminate\Support\Facades\Storage::disk('public')->json('menu'.$menu_id.'.json'); @endphp
                                @foreach ($menus as $mkey => $menu)
                                    <li><a href="{{ $menu['url'] }}"
                                            title="{{ $menu['name'] }}">{{ $menu['name'] }}</a></li>
                                    @if ($mkey == 12)
                                        @break
                                    @endif
                                @endforeach
                            @else
                                Menü Bulunamadı
                            @endif
                        </ul>
                    </div>

                    <div class="eklink">

                        <button id="menuBtnu" onclick="menuac()"><i class="fa fa-list"></i></button>

                        <button id="searching-btn"><i class="fa fa-search"></i></button>

                        @if (auth()->check())
                            <a href="{{ route('userprofile') }}" title="Profilim"><i class="fa fa-user"></i></a>
                        @else
                            <button id="signIn"><i class="fa fa-user"></i></button>
                        @endif

                    </div>

                </div>

            </div>
        </div>

        <div class="tmz"></div>

        <div class="mobilustmenu">
            <ul>
                @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('menu' . $menu_id . '.json'))
                    @php $menus = \Illuminate\Support\Facades\Storage::disk('public')->json('menu'.$menu_id.'.json'); @endphp
                    @foreach ($menus as $mkey => $menu)
                        <li><a href="{{ $menu['url'] }}" title="{{ $menu['name'] }}">{{ $menu['name'] }}</a></li>
                        @if ($mkey == 14)
                            @break
                        @endif
                    @endforeach
                @else
                    Menü Bulunamadı
                @endif
            </ul>
        </div>

        <div class="tmz"></div>

        <div class="sondakika d-flex align-items-center">
            <div class="container">

                <div class="sondakikalar mt-0">
                    <div class="marquee-content">

                        @php $ssay = 0; @endphp
                        @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('main/sondakika_manset.json'))
                            @php $son_dakikalar = \Illuminate\Support\Facades\Storage::disk('public')->json('main/sondakika_manset.json'); @endphp
                            @foreach ($son_dakikalar as $mkey => $son_dakika)
                                <a href="{{ route('post', ['categoryslug' => $son_dakika['categoryslug'], 'slug' => $son_dakika['slug'], 'id' => $son_dakika['id']]) }}"
                                    title="{{ $son_dakika['title'] }}" class="d-md-flex">
                                    <span
                                        class="d-md-block d-none">{{ date('H:i', strtotime($son_dakika['created_at'])) }}</span>
                                    <p class="d-md-block d-none m-0">
                                        {{ \Illuminate\Support\Str::limit(html_entity_decode($son_dakika['title']), 70) }}
                                    </p>
                                    <p class="d-md-none d-block m-0">
                                        {{ \Illuminate\Support\Str::limit(html_entity_decode($son_dakika['title']), 40) }}
                                    </p>
                                </a>
                                @php $ssay++; @endphp
                                @if ($mkey >= 3)
                                    @break
                                @endif
                            @endforeach

                    </div>
                </div>
            @else
                <div class="alert alert-warning  d-none"> @lang('frontend.hit_news_not_found')</div>

    @endif

    </div>

    </div>

    <div class="tmz"></div>

    @if ($magicbox['apiservicestatus'] == 0)
        @if ($magicbox['currency_status'] == 0)

            <div class="doviz">
                <div class="container">

                    @if (isset($magicbox['parapiyasacolor']))
                        <style>
                            .bgcolorcustom {
                                background-color: {{ $magicbox['parapiyasacolor'] }} !important;
                            }

                            .currency-block:after {
                                border-right: 2px solid {{ $magicbox['parapiyasacolor'] }} !important;
                            }
                        </style>
                    @endif

                    @if (isset($magicbox['parapiyasacolortext']))
                        <style>
                            .currency-title {
                                color: {!! $magicbox['parapiyasacolortext'] !!} !important;
                            }
                        </style>
                    @endif
                    @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('bist.json'))
                        @php $bist = \Illuminate\Support\Facades\Storage::disk('public')->json('bist.json');@endphp
                    @endif

                    @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('currency.json'))
                        @php $currency = \Illuminate\Support\Facades\Storage::disk('public')->json('currency.json');@endphp
                    @endif

                    @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('gold.json'))
                        @php $gold = \Illuminate\Support\Facades\Storage::disk('public')->json('gold.json');@endphp
                    @endif

                    @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('coin.json'))
                        @php $coin = \Illuminate\Support\Facades\Storage::disk('public')->json('coin.json');@endphp
                    @endif

                    <div class="dovizalan">

                        <div class="currency-slider overflow-hidden d-flex justify-content-start flex-nowrap"
                            id="currencySlider">

                            @if (isset($bist['result']) and count($bist['result']) > 0)
                                <div class="currency-block">
                                    <div class="currency-title d-flex flex-nowrap">
                                        BIST 100 <span class="icon-currency-down"></span>
                                    </div>
                                    <div class="currency-parameter">
                                        {{ $bist['result'][0]['current'] }}
                                    </div>
                                </div>
                            @endif

                            @if (isset($currency['result']) and count($currency['result']) > 0)

                                <div class="currency-block">
                                    <div class="currency-title d-flex flex-nowrap">
                                        DOLAR
                                        @if (strpos($currency['result'][0]['rate'], '-') !== false)
                                            <span class="icon-currency-down"></span>
                                        @else
                                            <span class="icon-currency-up"></span>
                                        @endif
                                    </div>
                                    <div class="currency-parameter">
                                        {{ $currency['result'][0]['buying'] }}
                                    </div>
                                </div>

                                <div class="currency-block">
                                    <div class="currency-title d-flex flex-nowrap">
                                        EURO
                                        @if (strpos($currency['result'][1]['rate'], '-') !== false)
                                            <span class="icon-currency-down"></span>
                                        @else
                                            <span class="icon-currency-up"></span>
                                        @endif
                                    </div>
                                    <div class="currency-parameter">
                                        {{ $currency['result'][1]['buying'] }}
                                    </div>
                                </div>

                                <div class="currency-block">
                                    <div class="currency-title d-flex flex-nowrap">
                                        GBP
                                        @if (strpos($currency['result'][2]['rate'], '-') !== false)
                                            <span class="icon-currency-down"></span>
                                        @else
                                            <span class="icon-currency-up"></span>
                                        @endif
                                    </div>
                                    <div class="currency-parameter">
                                        {{ $currency['result'][2]['buying'] }}
                                    </div>
                                </div>

                                <div class="currency-block">
                                    <div class="currency-title d-flex flex-nowrap">
                                        RUB
                                        @if (strpos($currency['result'][5]['rate'], '-') !== false)
                                            <span class="icon-currency-down"></span>
                                        @else
                                            <span class="icon-currency-up"></span>
                                        @endif
                                    </div>
                                    <div class="currency-parameter">
                                        {{ $currency['result'][5]['buying'] }}
                                    </div>
                                </div>

                            @endif

                            @if (isset($gold['result']) and count($gold['result']) > 0)

                                <div class="currency-block">
                                    <div class="currency-title d-flex flex-nowrap">
                                        GRAM ALTIN
                                        @if (strpos($gold['result'][0]['rate'], '-') !== false)
                                            <span class="icon-currency-down"></span>
                                        @else
                                            <span class="icon-currency-up"></span>
                                        @endif
                                    </div>
                                    <div class="currency-parameter">
                                        {{ $gold['result'][0]['buying'] }}
                                    </div>
                                </div>

                                <div class="currency-block">
                                    <div class="currency-title d-flex flex-nowrap">
                                        GÜMÜŞ
                                        @if (strpos($gold['result'][20]['rate'], '-') !== false)
                                            <span class="icon-currency-down"></span>
                                        @else
                                            <span class="icon-currency-up"></span>
                                        @endif
                                    </div>
                                    <div class="currency-parameter">
                                        {{ $gold['result'][20]['buying'] }}
                                    </div>
                                </div>

                            @endif

                            @if (isset($coin['result']))
                                <div class="currency-block">
                                    <div class="currency-title d-flex flex-nowrap">
                                        BTC
                                        @if (strpos($coin['result'][0]['changeDay'], '-') !== false)
                                            <span class="icon-currency-down"></span>
                                        @else
                                            <span class="icon-currency-up"></span>
                                        @endif
                                    </div>
                                    <div class="currency-parameter">
                                        {{ $coin['result'][0]['pricestr'] }}
                                    </div>
                                </div>
                            @endif

                        </div>

                        {{-- <div class="light-pagination position-absolute"> --}}
                        {{-- <div class="light-prev" id="currencyPrev"></div> --}}
                        {{-- <div class="light-next" id="currencyNext"></div> --}}
                        {{-- </div> --}}

                    </div>

                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

                    <script>
                        $(document).ready(function() {
                            $('#currencySlider').slick({
                                dots: false,
                                infinite: true,
                                speed: 300,
                                variableWidth: false,
                                nextArrow: '#currencyNext',
                                prevArrow: '#currencyPrev',
                                centerMode: false,
                                swipeToSlide: false,
                                slidesToShow: 3, // Number of slides visible
                                slidesToScroll: 1, // Number of slides to scroll
                                autoplay: true, // Enables auto sliding
                                autoplaySpeed: 2000, // Delay between slides (in ms)
                                responsive: [{
                                        breakpoint: 1000,
                                        settings: {
                                            slidesToShow: 3
                                        }
                                    },
                                    {
                                        breakpoint: 768,
                                        settings: {
                                            slidesToShow: 2
                                        }
                                    },
                                    {
                                        breakpoint: 320,
                                        settings: {
                                            slidesToShow: 1
                                        }
                                    }
                                ]
                            });
                        })
                    </script>
                @else
                    <div class="alert alert-warning d-none"> Para Piyasası modülü kapalı</div>

        @endif

        </div>
        </div>

    @endif

    <div class="tmz"></div>
    <div class="bos30"></div>
    <div class="tmz"></div>

    <div class="position-relative" id="burger-menu-contain">
        <div class="before-overlay"></div>
        <div class="big-menu rounded-1 pb-2 bg-white" id="burger-menu">
            <div class="big-menu-header p-2 pb-0">
                <div class="menu-close-btn text-end" id="menu-close"><i class="icon-close2 d-inline-block"></i>
                </div>
            </div>
            @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('menu' . $menu_id . '.json'))
                @php $menus = \Illuminate\Support\Facades\Storage::disk('public')->json('menu'.$menu_id.'.json'); @endphp @foreach ($menus as $mkey => $menu)
                    @if ($mkey > 8)
                        <div class="nav-item"><a class="nav-link externallink" href="{{ $menu['url'] }}"
                                title="{{ $menu['name'] }}">{{ $menu['name'] }}</a></div>
                    @endif
                @endforeach
            @else
                Menü Bulunamadı
            @endif
            <div class="nav-item"><a class="nav-link externallink" href="{{ route('authors') }}"
                    title="Yazarlar">Yazarlar</a></div>
            <div class="nav-item"><a class="nav-link externallink" href="{{ route('photo_galleries') }}"
                    title="Foto Galeri">Foto Galeri</a></div>
            <div class="nav-item"><a class="nav-link externallink" href="{{ route('video_galleries') }}"
                    title="Video Galeri">Video Galeri</a></div>
        </div>
    </div>

    <div class="tmz"></div>

    <div id="anamenu">

        <div class="mlogo">
            <a href="{{ route('frontend.index') }}" title="{{ $magicbox['title'] }}"><img
                    src="{{ asset('uploads/' . $settings['logo']) }}" alt="{{ $magicbox['title'] }}" /></a>
        </div>

        <div class="kapat"><a onclick="menukapat()" href="#">x</a></div>

        <div class="tmz"></div>

        <div class="sekmenu">
            <p><a href="{{ $magicbox['fb'] }}" style="background: #30487b;"><i class="fa fa-facebook"></i></a></p>
            <p><a href="{{ $magicbox['tw'] }}" style="background: #2ba9e1;"><i class="fa fa-twitter"></i></a></p>
            <p><a href="{{ $magicbox['in'] }}" style="background: #BD0082;"><i class="fa fa-instagram"></i></a></p>
            <p><a href="{{ $magicbox['yt'] }}" style="background: #f74c53;"><i class="fa fa-youtube"></i></a></p>
            <p><a href="{{ $magicbox['ln'] }}" style="background: #005f8d;"><i class="fa fa-linkedin"></i></a></p>
        </div>

        <div class="tmz"></div>

        @php
            $maxVisible = 6; // Görünecek maksimum kategori sayısı
            $visibleMenus = array_slice($menus, 0, $maxVisible);
            $moreMenus = array_slice($menus, $maxVisible);
        @endphp

        <ul class="menu">
            @foreach ($visibleMenus as $menu)
                <li class="menu-item">
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="{{ $menu['url'] }}"
                            class="menu-link {{ isset($menu['children']) ? 'has-children' : '' }}"
                            title="{{ $menu['name'] }}">
                            {{ $menu['name'] }}
                        </a>
                        @if (!empty($menu['children']))
                            <i class="fa fa-chevron-down click-menu d-flex justify-content-end has-children"></i>
                        @endif
                    </div>

                    @if (!empty($menu['children']))
                        <ul class="submenu">
                            @foreach ($menu['children'] as $child)
                                <li class="submenu-item">
                                    <a href="{{ $child['url'] }}" class="submenu-link"
                                        title="{{ $child['name'] }}">
                                        <i class="fa fa-caret-right mx-4"></i>
                                        {{ $child['name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach

            @if (count($moreMenus) > 0)
                <li class="menu-item more-menu">
                    <div class="d-flex align-items-center justify-content-between click-menu2">
                        <button type="button" class="menu-link  has-children">Daha Fazla</button>
                        <i class="fa  fa-chevron-down  d-flex justify-content-end has-children"></i>
                    </div>

                    <ul class="submenu">
                        @foreach ($moreMenus as $menu)
                            <li class="submenu-item">
                                <a href="{{ $menu['url'] }}" class="submenu-link" title="{{ $menu['name'] }}">
                                    <i class="fa fa-caret-right mx-4"></i>
                                    {{ $menu['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
        </ul>


        <div class="tmz"></div>

        <div class="ekmenu">
            <a href="/"><i class="fa fa-clock-o"></i>@lang('frontend.hit_news')</a>     
            <a href="{{ 'https://wa.me/' . $magicbox['phone'] }}"><i class="fa fa-whatsapp"></i>@lang('frontend.send_news')</a>
            <a href="/video-galeriler"><i class="fa fa-camera"></i>@lang('frontend.video')</a>
            <a href="/yazarlar"><i class="fa fa-users"></i>@lang('frontend.authors')</a>
            <a href="/sayfa/kunye"><i class="fa fa-suitcase"></i>@lang('frontend.corporate')</a>
            <a href="/sayfa/iletisim"><i class="fa fa-envelope"></i>@lang('frontend.contact')</a>
        </div>

    </div>

    <script type="text/javascript">
        function menuac() {
            document.getElementById('anamenu').style.display = "block";
        }

        function menukapat() {
            document.getElementById('anamenu').style.display = "none";
        }


        document.addEventListener('click', function(e) {
            const menu = document.getElementById('anamenu');
            const button = document.getElementById('menuBtnu');
            if (!menu.contains(e.target) && !button.contains(e.target)) {
                menukapat();
            }
        });

        document.getElementById('anamenu').addEventListener('click', function(e) {
            e.stopPropagation();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") {
                menukapat();
            }
        });
    </script>

    <div class="tmz"></div>
@elseif($design == 1)
    @php
        $trend_news = collect(\Illuminate\Support\Facades\Storage::disk('public')->json('main/hit_news.json'));
        $remaining_news = $trend_news->slice(15);
        $news_groups = $remaining_news->chunk(6)->take(4);
    @endphp

    <style>
        footer .nav-link:hover {
            color: #ffffff !important;
        }

        .new-footer-list-elem a:hover {
            color: #b6bbbf !important;
            text-decoration: underline;
        }
    </style>

    <div class="tmz"></div>



    <div class="tmz"></div>

    <footer class="new-footer">

        <div class="container">

            <div class="new-footer-top">

                <style>
                    .footer-head-container {
                        margin-bottom: 80px;
                        font-size: 16px;
                        width: fit-content;
                    }

                    .footer-head-tag {
                        background-color: #97979780;

                    }

                    .footer-head-tag:hover {
                        background-color: #a5a5a5cf;
                    }
                </style>


                <div class="container mx-0 px-md-4 footer-head-container">
                    <div class="d-flex flex-wrap gap-2" style="font-weight: 600;">
                        @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('menu' . $menu_id . '.json'))
                            @php $menus = \Illuminate\Support\Facades\Storage::disk('public')->json('menu'.$menu_id.'.json'); @endphp
                            @foreach ($menus as $mkey => $menu)
                                <a href="{{ $menu['url'] }}" class="text-white px-2 py-1 mx-1 footer-head-tag"
                                    title="{{ $menu['name'] }}">{{ $menu['name'] }}</a>
                                @if ($mkey == 10)
                                    @break
                                @endif
                            @endforeach
                        @else
                            Menü Bulunamadı
                        @endif
                    </div>
                </div>


                <div class="row my-4">
                    <style>
                        .footer-body-logo {
                            border-right: 1px solid #4f4f4f;

                        }

                        @media (max-width: 768px) {
                            .footer-body-logo {
                                border-right: 0px solid #4f4f4f;
                                border-bottom: 1px solid #4f4f4f;
                                padding-bottom: 20px;
                                text-align: center;
                                display: flex;
                                flex-direction: column;
                                align-items: center
                            }
                        }
                    </style>
                    <div class="col-md-5 col-12 px-4">
                        <div class="px-md-4 footer-body-logo">
                            <div class="footer-logo mb-3">
                                <a href="{{ route('frontend.index') }}" title="{{ $magicbox['title'] }}">
                                    <img src="{{ asset('uploads/' . $settings['logo']) }}"
                                        alt="{{ $magicbox['title'] }}" class="img-fluid" />
                                </a>
                            </div>
                            <div class="footer-description text-white">
                                <p>{{ $settings['description'] }}</p>
                            </div>
                            <div class="d-flex justify-content-start  pt-lg-3 mt-3 mb-5">
                                <div class="px-1">
                                    <a href="{{ $magicbox['tw'] }}" class="btn social-rounded-button externallink"
                                        target="_blank">
                                        <div class="icon-social-x"></div>
                                    </a>
                                </div>
                                <div class="px-1">
                                    <a href="{{ $magicbox['fb'] }}" class="btn social-rounded-button externallink"
                                        target="_blank">
                                        <div class="icon-social-facebook"></div>
                                    </a>
                                </div>
                                <div class="px-1">
                                    <a href="{{ $magicbox['in'] }}" class="btn social-rounded-button externallink"
                                        target="_blank">
                                        <div class="icon-social-instagram"></div>
                                    </a>
                                </div>
                                <div class="px-1">
                                    <a href="{{ $magicbox['yt'] }}" class="btn social-rounded-button externallink"
                                        target="_blank">
                                        <div class="icon-social-youtube"></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="px-md-4">
                            <div class="text-start text-white mb-2 mt-md-0 mt-5">
                                <h5>
                                    @lang('frontend.corporate')
                                    <hr style="width: 40%;" />
                                </h5>
                            </div>
                            <div>
                                <ul>
                                    <li class="mb-2">
                                        <a href="/sayfa/iletisim" title="Künye" class="footer-body-news"
                                            style="font-size:16px;">
                                            @lang('frontend.contact')
                                        </a>
                                    </li>
                                    <li class="mb-2">
                                        <a href="/sayfa/kunye" title="Künye" class="footer-body-news"
                                            style="font-size:16px;">
                                            @lang('frontend.about')
                                        </a>
                                    </li>
                                    <li class="mb-2">
                                        <a href="/sayfa/gizlilik-politikasi" title="Künye" class="footer-body-news"
                                            style="font-size:16px;">
                                            @lang('frontend.privacy_policy')
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>


                    </div>

                    <div class="col-md-7 col-12 ">
                        <div class="row">
                            <div class="col-md-6 col-12 px-4 my-md-0 my-4">
                                <style>
                                    .footer-body-news {
                                        color: white;
                                        text-decoration: none;
                                        font-size: 14px;
                                    }

                                    .footer-body-news:hover {
                                        text-decoration: underline;
                                    }
                                </style>


                                <div class="text-start text-white mb-2">
                                    <h5>
                                        @lang('frontend.most_read_news')
                                        <hr style="width: 40%;" />
                                        </h4>
                                </div>
                                <div>
                                    <ul>
                                        @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('main/hit_news.json'))
                                            @php $son_dakikalar = \Illuminate\Support\Facades\Storage::disk('public')->json('main/hit_news.json');  @endphp
                                            @foreach ($son_dakikalar as $mkey => $son_dakika)
                                                @if ($mkey > 3 && $mkey <= 11)
                                                    <li class="mb-2">
                                                        <a href="{{ route('post', ['categoryslug' => categoryCheck($son_dakika['category_id'])->slug, 'slug' => $son_dakika['slug'], 'id' => $son_dakika['id']]) }}"
                                                            title="{{ $son_dakika['title'] }}"
                                                            class="footer-body-news">
                                                            {{ $son_dakika['title'] }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @else
                                            <div class="text-white"> Haberlere Erişilemedi</div>
                                        @endif
                                    </ul>
                                </div>





                            </div>
                            <div class="col-md-6 col-12 px-4">

                                <div class="text-start text-white mb-2 invisible d-md-block d-none">
                                    <h5>
                                        Haberler
                                        <hr style="width: 40%;" />
                                        </h4>
                                </div>
                                <div>
                                    <ul>
                                        @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('main/hit_news.json'))
                                            @php $son_dakikalar = \Illuminate\Support\Facades\Storage::disk('public')->json('main/hit_news.json'); @endphp
                                            @foreach ($son_dakikalar as $mkey => $son_dakika)
                                                @if ($mkey > 11 && $mkey <= 19)
                                                    <li class="mb-2">
                                                        <a href="{{ route('post', ['categoryslug' => categoryCheck($son_dakika['category_id'])->slug, 'slug' => $son_dakika['slug'], 'id' => $son_dakika['id']]) }}"
                                                            title="{{ $son_dakika['title'] }}"
                                                            class="footer-body-news">
                                                            {{ $son_dakika['title'] }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @else
                                            <div class="text-white"> Haberlere Erişilemedi</div>
                                        @endif
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="new-footer-bottom" style="background:#000;">
            <div class="container">
                <div class="new-footer-bottom-flex">

                    <div class="new-footer-copyright-text">
                    @lang('frontend.All rights reserved') - 2025 - @lang('frontend.Unauthorized Content Cannot be used')
                    </div>

                    <p class="mb-0 new-footer-copyright-text" style="cursor:default;">@lang('frontend.Software'): <a
                            href="https://medyayazilimlari.com/" target="_blank" class=" text-white new-footer-link"
                            rel="dofollow">MEDYA YAZILIMLARI</a></p>

                </div>
            </div>
        </div>

        <div class="container" style="display: none !important">

            <div class="row mb-4">
                <div class="col-12 col-lg-4">
                    <div class="d-flex flex-lg-nowrap justify-content-center justify-content-lg-start py-4">
                        <div>
                            <a class="" href="{{ route('frontend.index') }}"
                                title="{{ $magicbox['title'] }}">
                                <img src="{{ asset('uploads/' . $settings['logo']) }}"
                                    alt="{{ $magicbox['title'] }}" class="brand-logo" width="102">
                            </a>
                        </div>
                        <div class="footer-logo-capital ps-3">
                            <div class="fw-bold footer-logo-capital-title text-dark">{{ $magicbox['title'] }}</div>
                            <div class="fw-medium footer-logo-capital-desc text-dark">
                                © {{ $magicbox['copyright'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8 social-icons-new">
                    <div class="d-flex justify-content-center justify-content-lg-end mb-4 mb-lg-0 pt-lg-3 mt-3">
                        <div class="px-1">
                            <a href="{{ $magicbox['tw'] }}" class="btn social-rounded-button externallink"
                                target="_blank">
                                <div class="icon-social-x"></div>
                            </a>
                        </div>
                        <div class="px-1">
                            <a href="{{ $magicbox['fb'] }}" class="btn social-rounded-button externallink"
                                target="_blank">
                                <div class="icon-social-facebook"></div>
                            </a>
                        </div>
                        <div class="px-1">
                            <a href="{{ $magicbox['in'] }}" class="btn social-rounded-button externallink"
                                target="_blank">
                                <div class="icon-social-instagram"></div>
                            </a>
                        </div>
                        <div class="px-1">
                            <a href="{{ $magicbox['yt'] }}" class="btn social-rounded-button externallink"
                                target="_blank">
                                <div class="icon-social-youtube"></div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <hr class="border-gray m-0">
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    <div class="d-lg-flex justify-content-lg-between footer-categories">
                        @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('menu' . $menu_id . '.json'))
                            @php
                                $menus = \Illuminate\Support\Facades\Storage::disk('public')->json(
                                    'menu' . $menu_id . '.json',
                                );
                                $collection = collect($menus);
                                $chunks = $collection->chunk(6);
                                $menus = $chunks->toArray();
                            @endphp
                            @foreach ($menus as $six)
                                <div class="pe-2 float-start float-lg-none">
                                    <div class="row">
                                        @foreach ($six as $sie)
                                            <div class="col-6 col-lg-12">
                                                <a class="nav-link px-0 text-white" href="{{ $sie['url'] }}"
                                                    title="{{ $sie['name'] }}">{{ $sie['name'] }}</a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @else
                            Menü Bulunamadı
                        @endif
                    </div>
                </div>
            </div>
        @elseif($design == 2)
            <div class="row">
                <div class="col-12">
                    <hr class="border-gray m-0 mb-3">
                </div>
                <div class="col-12">
                    <nav class="navbar navbar-expand-md">
                        @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('menu' . $menu_id . '.json'))
                            @php $menus = \Illuminate\Support\Facades\Storage::disk('public')->json('menu'.$menu_id.'.json'); @endphp
                            <div class="navbar-nav">
                                @foreach ($menus as $mkey => $menu)
                                    <a class="nav-link px-0 text-white externallink" href="{{ $menu['url'] }}"
                                        title="{{ $menu['name'] }}">{{ $menu['name'] }}</a>
                                @endforeach
                            </div>
                        @else
                            Menü Bulunamadı
                        @endif
                    </nav>
                    <p class="mb-4">
                        <small class="text-white-50">
                            Türkiye'den ve Dünya’dan son dakika haberleri, köşe yazıları, magazinden siyasete,
                            spordan seyahate bütün konuların tek adresi haber içerikleri izin alınmadan, kaynak
                            gösterilerek dahi iktibas edilemez. Kanuna aykırı ve izinsiz olarak kopyalanamaz,
                            başka yerde yayınlanamaz.
                        </small>
                    </p>
                </div>
            </div>

        </div>

    </footer>

    <div class="bosver" style="display:none !important;"></div>

    <div class="altsabit" style="display:none !important;">

        @if (isset($magicbox['live_stream_link']) ?? !blank($magicbox['live_stream_link']))
            <a style="width:33.3%; background:#ef0000;color:#FFFFFF;" href="{{ route('frontend.index') }}"><i
                    class="fa fa-home" style="font-size: 20px;"></i> @lang('frontend.home')</a>
            <a style="width:33.3%; background:#2a3e81;color:#FFFFFF;" onclick="menuac()"><i class="fa fa-list"></i>
            @lang('frontend.categories')</a>
            <a style="width:33.3%; background:#ef0000;color:#FFFFFF;" href="{{ $magicbox['live_stream_link'] }}"
                title="link" target="_blank"><i class="fa fa-video-camera"></i>
                {{ $magicbox['live_stream_name'] }}</a>
        @else
            <a style="width:50%; background:#ef0000;color:#FFFFFF;" href="{{ route('frontend.index') }}"><i
                    class="fa fa-home" style="font-size: 20px;"></i> @lang('frontend.home')</a>
            <a style="width:50%; background:#2a3e81;color:#FFFFFF;" onclick="menuac()"><i class="fa fa-list"></i>
            @lang('frontend.categories')</a>
        @endif

    </div>
@else
    <h5 class="text-danger">Menü ayarlanmamış!</h5>

@endif

@endif <a href="#" class="back-to-top"><i class="fa fa-arrow-circle-up"></i></a> <a
    href="javascript:history.back()" class="back-to-topx mobvar"><i class="fa fa-arrow-circle-left"></i></a>
<style>
    a.back-to-top {
        background: #93C225;
        color: #FFFFFF;
        z-index: 9999;
        border: 0px;
        position: fixed;
        display: none;
        bottom: 10px;
        right: 10px;
        width: 44px;
        height: 44px !important;
        text-align: center;
        overflow: hidden;
        border-radius: 100%;
        padding: 0px 0px 0px 0px !important;
    }

    a.back-to-topx {
        background: #93C225;
        color: #FFFFFF;
        z-index: 9999;
        border: 0px;
        position: fixed;
        display: none;
        bottom: 50%;
        left: 5px;
        width: 44px;
        height: 44px !important;
        text-align: center;
        overflow: hidden;
        border-radius: 100%;
        padding: 0px 0px 0px 0px !important;
    }

    a.back-to-top i,
    a.back-to-topx i {
        float: left;
        width: 100%;
        height: auto;
        overflow: hidden;
        margin: 0px 0px 0px 0px;
        padding: 10px 0px 0px 0px;
        border: 0px;
        text-align: center;
        color: #1d222e;
        font-size: 24px;
        text-decoration: none;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        box-sizing: border-box;
    }

    a.back-to-top:hover,
    a.back-to-topx:hover {
        text-decoration: none;
    }

    body.scrolled a.back-to-top {
        display: block;
    }

    body.scrolled .header {
        position: fixed;
        top: 0;
    }

    @media only screen and (max-width: 1000px) {
        body.scrolled a.back-to-topx {
            display: block;
        }
    }
</style>
<script>
    window.addEventListener('scroll', function() {
        if (window.scrollY > 350) {
            document.body.classList.add('scrolled');
        } else {
            document.body.classList.remove('scrolled');
        }
    });
</script>
