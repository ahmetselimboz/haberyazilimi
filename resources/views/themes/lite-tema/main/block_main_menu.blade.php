@if (isset($design))
    @if ($design == 'default' or $design == 0)

        <!-- Navbar -->
        <nav
            class="fixed top-0 left-0 right-0 z-[1002] lite-bg-secondary border-b lite-border h-auto flex items-center justify-between px-5 md:px-8 py-3 transition-all duration-300">
            <div class="flex items-center lg:gap-8 gap-4">
                <!-- Menü İkonu -->
                <button class="lite-btn-hover-accent p-2 rounded-md transition-all duration-300 text-2xl"
                    id="liteMenuToggle">
                    <i class="ri-menu-line"></i>
                </button>

                <div class="flex items-center justify-center">
                    <a href="{{ route('frontend.index') }}" title="{{ $magicbox['title'] }}">
                        <img src="{{ asset('uploads/' . $settings['logo']) }}" alt="{{ $magicbox['title'] }}"
                            class="h-auto w-36 lg:w-40 transition-opacity duration-300" id="liteBannerLogo">
                    </a>
                </div>
            </div>



            <!-- Kategoriler -->
            <div class="flex items-center justify-center gap-4">
                <ul class="hidden lg:flex items-center justify-center gap-4 list-none">
                    @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('menu' . $menu_id . '.json'))
                        @php $menus = \Illuminate\Support\Facades\Storage::disk('public')->json('menu' . $menu_id . '.json'); @endphp
                        @foreach ($menus as $mkey => $menu)
                            <li>
                                <a href="{{ $menu['url'] }}" title="{{ $menu['name'] }}"
                                    class="lite-hover-accent font-medium px-2 py-2 rounded-md transition-all duration-300 text-sm">
                                    {{ $menu['name'] }}
                                </a>
                            </li>
                            @if ($mkey == 12)
                                @break
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="flex items-center gap-2">
                <p class="text-sm lite-text-accent font-bold cursor-default hidden md:block ">{{ date('d.m.Y') }}</p>
            </div>
            <div class="flex items-center lg:gap-2 gap-1">
                <!-- Bileşenler Sayfası -->
                <a href="components.html"
                    class="lite-hover-accent  p-2 rounded-md transition-all duration-300 text-lg hidden md:hidden items-center gap-1"
                    title="Tasarım Bileşenleri">
                    <i class="ri-palette-line"></i>
                    <span class="text-sm">Bileşenler</span>
                </a>



                <!-- Arama Butonu -->
                <button class=" lite-btn-hover-accent p-2 rounded-md transition-all duration-300 text-xl"
                    id="liteSearchToggleDesktop">
                    <i class="ri-search-line"></i>
                </button>

                <!-- Bildirim Butonu -->
                <button class="lite-btn-hover-accent p-2 rounded-md transition-all duration-300 text-xl"
                    id="liteNotificationToggle">
                    <i class="ri-notification-line"></i>
                </button>


                @if (auth()->check())
                    <!-- User Butonu -->
                    <a href="{{ route('userprofile') }}" title="Profilim"
                        class="lite-btn-hover-accent p-2 rounded-md transition-all duration-300 text-xl">
                        <i class="ri-user-line"></i>
                    </a>
                @else
                    <!-- User Butonu -->
                    <button class="lite-btn-hover-accent p-2 rounded-md transition-all duration-300 text-xl"
                        id="liteUserToggle">
                        <i class="ri-user-line"></i>
                    </button>
                @endif


                <!-- Tema Toggle Butonu -->
                <button class="lg:block hidden lite-btn-hover-accent p-2 rounded-md transition-all duration-300 text-xl"
                    id="liteThemeToggleDesktop">
                    <i class="ri-sun-line" id="liteThemeIconDesktop"></i>
                </button>
            </div>
        </nav>

        <!-- Slide Menü -->
        <div class="fixed top-0 left-0 w-80 h-screen lite-bg-secondary border-r lite-border z-[1001] transform -translate-x-full transition-transform duration-300 lite-scrollbar overflow-y-auto"
            id="liteSlideMenu">
            @php
                $maxVisible = 6; // Görünecek maksimum kategori sayısı
                $visibleMenus = array_slice($menus, 0, $maxVisible);
                $moreMenus = array_slice($menus, $maxVisible);
            @endphp
            <!-- Menü Header -->
            <div class="flex items-center justify-between p-6 border-b lite-border">
                <h3 class="font-semibold lite-text-primary text-lg">Menü</h3>
                <button class="lite-hover-accent p-2 rounded-md transition-all duration-300 text-xl" id="liteMenuClose">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <!-- Menü İçeriği -->
            <div class="py-4">
                @foreach ($visibleMenus as $menu)
                    @if (!empty($menu['children']))
                        <div class="lite-submenu-container">
                            <button
                                class="w-full flex items-center justify-between px-6 py-4 lite-text-primary border-b lite-border transition-all duration-300 font-medium lite-hover-accent lite-submenu-toggle"
                                data-target="{{ $menu['name'] }}-submenu">
                                <span>{{ $menu['name'] }}</span>
                                <i class="ri-arrow-down-s-line transition-transform duration-300"></i>
                            </button>
                            <div class="lite-submenu" id="{{ $menu['name'] }}-submenu">
                                @foreach ($menu['children'] as $child)
                                    <a href="{{ $child['url'] }}" title="{{ $child['name'] }}"
                                        class="block px-10 py-3 lite-text-secondary border-b lite-border transition-all duration-300 lite-hover-accent text-sm"
                                        title="{{ $child['name'] }}">
                                        {{ $child['name'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $menu['url'] }}"
                            class="block px-6 py-4 lite-text-primary border-b lite-border transition-all duration-300 font-medium lite-hover-accent"
                            title="{{ $menu['name'] }}">
                            {{ $menu['name'] }}
                        </a>
                    @endif
                @endforeach
                <div class="w-full px-6 py-4 lg:hidden block ">
                    <!-- Tema Toggle Butonu -->
                    <button class="lite-btn lite-btn-outline  lite-btn-md p-2 rounded-md transition-all duration-300 "
                        id="liteThemeToggleDesktop">
                        <i class="ri-sun-line" id="liteThemeIconDesktop"></i>
                        Açık/Koyu Tema
                    </button>
                </div>

            </div>
        </div>

        <!-- Arama Kutusu -->
        <div class="fixed top-15 left-0 right-0 lite-bg-secondary border-b lite-border p-5 z-[1001] transform -translate-y-full transition-transform duration-300"
            id="liteSearchContainer">
            <form class="w-full max-w-2xl mx-auto relative" action="{{ route('search.get') }}" method="get" id="search-form">
                <input name="search" type="text"
                    class="w-full px-4 py-3 pr-12 border-2 lite-border rounded-lg text-base lite-bg-primary lite-text-primary outline-none transition-all duration-300 focus:lite-accent-border"
                    placeholder="Haber ara..." id="liteSearchInput">
                <button
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 lite-bg-accent text-white px-3 py-2 rounded-md cursor-pointer text-base"
                    id="liteSearchSubmit">
                    <i class="ri-search-line"></i>
                </button>
            </form>
        </div>

        <!-- Bildirim Popup -->
        <div class="fixed top-16 right-5 w-80 lite-bg-secondary border lite-border rounded-lg shadow-2xl z-[1002] opacity-0 invisible transform -translate-y-2 transition-all duration-300"
            id="liteNotificationPopup">
            <div class="px-5 py-4 border-b lite-border text-center font-semibold lite-text-primary">
                Haberleri Mail veya Whatsapp ile alın!
            </div>
            <div class="px-5 py-5 lite-text-secondary">
                <div class="flex flex-col   gap-2 w-full">
                    <label for="liteNotificationEmail" class="text-xs">Email</label>
                    <input type="email" id="liteNotificationEmail"
                        class="lite-bg-primary lite-text-primary border lite-border rounded-lg outline-none focus:lite-accent-border p-2 w-full  text-sm"
                        placeholder="Email">
                    <label for="liteNotificationWhatsapp" class="text-xs">Whatsapp</label>
                    <input type="tel" id="liteNotificationWhatsapp"
                        class="lite-bg-primary lite-text-primary border lite-border rounded-lg outline-none focus:lite-accent-border p-2 w-full text-sm"
                        placeholder="Whatsapp">


                </div>
                <button class="lite-btn lite-btn-primary lite-btn-md lite-btn-full mt-4" id="liteNotificationSubmit">
                    <i class="ri-send-plane-line"></i>
                    Gönder
                </button>
            </div>
        </div>

        <!-- Overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50 z-[998] opacity-0 invisible transition-all duration-300"
            id="liteOverlay"></div>

        <div class="fixed bottom-2 px-1 w-full z-[1000] lg:hidden block">
            <ul
                class="mobile-menu-container flex items-center justify-between gap-2 text-xs font-semibold w-full py-4 px-2  rounded-2xl lite-text-accent">

                <li>
                    <a href="">
                        <i class="ri-home-line"></i>
                        Anasayfa
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="ri-trending-line"></i>
                        Trendler
                    </a>
                </li>
                <li>
                    <a href="" class="active">
                        <i class="ri-share-line"></i>
                        Haber Gönder
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="ri-list-check"></i>
                        Kategoriler
                    </a>
                </li>
            </ul>
        </div>



        <div id="liteUserModal"
            class="fixed inset-0 bg-black bg-opacity-50 z-[1002] hidden flex items-center justify-center p-4">
            <div class="lite-bg-secondary rounded-lg shadow-xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0"
                id="liteUserModalContent">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b lite-border ">
                    <h3 class="text-xl font-semibold " id="liteUserModalTitle">Giriş Yap</h3>
                    <button id="liteUserModalClose"
                        class="lite-text-secondary hover:lite-text-accent transition-colors">
                        <i class="ri-close-line text-xl"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <!-- Tab Navigation -->
                    <div class="flex mb-6 border lite-border rounded-lg p-1">
                        <button id="liteLoginTab"
                            class="flex-1 py-2 px-4 text-sm font-medium rounded-md transition-all duration-200 lite-bg-accent lite-text-third shadow-sm">
                            Giriş Yap
                        </button>
                        <button id="liteRegisterTab"
                            class="flex-1 py-2 px-4 text-sm font-medium rounded-md transition-all duration-200 lite-text-secondary hover:lite-text-accent">
                            Kayıt Ol
                        </button>
                    </div>

                    <!-- Login Form -->
                    <form id="liteLoginForm" class="space-y-4">
                        <div>
                            <label for="liteLoginEmail"
                                class="block text-sm font-medium lite-text-secondary mb-2">E-posta</label>
                            <input type="email" id="liteLoginEmail"
                                class="w-full px-4 py-2 border-2 lite-border rounded-lg text-sm lite-bg-primary lite-text-primary outline-none transition-all duration-300 focus:lite-accent-border"
                                placeholder="ornek@email.com" required>
                        </div>
                        <div>
                            <label for="liteLoginPassword"
                                class="block text-sm font-medium lite-text-secondary mb-2">Şifre</label>
                            <input type="password" id="liteLoginPassword"
                                class="w-full px-4 py-2 border-2 lite-border rounded-lg text-sm lite-bg-primary lite-text-primary outline-none transition-all duration-300 focus:lite-accent-border"
                                placeholder="••••••••" required>
                        </div>
                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input type="checkbox"
                                    class="rounded border-lite-border cursor-pointer lite-text-accent focus:ring-lite-accent">
                                <span class="ml-2 text-sm lite-text-secondary">Beni hatırla</span>
                            </label>
                            <a href="#" class="text-sm lite-text-accent hover:underline">Şifremi
                                unuttum</a>
                        </div>
                        <button type="submit" class="lite-btn lite-btn-primary lite-btn-md w-full">
                            Giriş Yap
                        </button>
                    </form>

                    <!-- Register Form -->
                    <form id="liteRegisterForm" class="space-y-4 hidden">
                        <div>
                            <label for="liteRegisterName"
                                class="block text-sm font-medium lite-text-secondary mb-2">Ad
                                Soyad</label>
                            <input type="text" id="liteRegisterName"
                                class="w-full px-4 py-2 border-2 lite-border rounded-lg text-sm lite-bg-primary lite-text-primary outline-none transition-all duration-300 focus:lite-accent-border"
                                placeholder="Adınız Soyadınız" required>
                        </div>
                        <div>
                            <label for="liteRegisterEmail"
                                class="block text-sm font-medium lite-text-secondary mb-2">E-posta</label>
                            <input type="email" id="liteRegisterEmail"
                                class="w-full px-4 py-2 border-2 lite-border rounded-lg text-sm lite-bg-primary lite-text-primary outline-none transition-all duration-300 focus:lite-accent-border"
                                placeholder="ornek@email.com" required>
                        </div>
                        <div>
                            <label for="liteRegisterPassword"
                                class="block text-sm font-medium lite-text-secondary mb-2">Şifre</label>
                            <input type="password" id="liteRegisterPassword"
                                class="w-full px-4 py-2 border-2 lite-border rounded-lg text-sm lite-bg-primary lite-text-primary outline-none transition-all duration-300 focus:lite-accent-border"
                                placeholder="••••••••" required>
                        </div>
                        <div>
                            <label for="liteRegisterPasswordConfirm"
                                class="block text-sm font-medium lite-text-secondary mb-2">Şifre Tekrar</label>
                            <input type="password" id="liteRegisterPasswordConfirm"
                                class="w-full px-4 py-2 border-2 lite-border rounded-lg text-sm lite-bg-primary lite-text-primary outline-none transition-all duration-300 focus:lite-accent-border"
                                placeholder="••••••••" required>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="liteRegisterTerms"
                                class="rounded border-lite-border cursor-pointer lite-text-accent focus:ring-lite-accent"
                                required>
                            <label for="liteRegisterTerms" class="ml-2 text-sm lite-text-secondary">
                                <a href="#" class="lite-text-accent hover:underline">Kullanım
                                    şartlarını</a> kabul ediyorum
                            </label>
                        </div>
                        <button type="submit" class="w-full lite-btn lite-btn-primary lite-btn-md w-full">
                            Kayıt Ol
                        </button>
                    </form>

                    <!-- Social Login -->
                    <!-- <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">veya</span>
            </div>
        </div>
        <div class="mt-6 grid grid-cols-2 gap-3">
            <button
                class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                <i class="ri-google-fill text-lg mr-2"></i>
                Google
            </button>
            <button
                class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                <i class="ri-facebook-fill text-lg mr-2"></i>
                Facebook
            </button>
        </div>
    </div> -->
                </div>
            </div>
        </div>

        <button id="liteBackToTop"
            class="fixed lg:bottom-20 bottom-[15%] lg:right-5 right-4 w-12 h-12 lite-bg-accent text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 opacity-0 pointer-events-none z-50">
            <i class="ri-arrow-up-line"></i>
        </button>
    @elseif($design == 1)
        <!-- Footer -->
        <footer class="lite-bg-secondary border-t lite-border mt-16">
            <!-- Üst Alan -->
            <div class="max-w-6xl mx-auto px-5 py-12">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                    <!-- Sol - Logo ve Açıklama -->
                    <div class="lg:col-span-1">
                        <div class="mb-4">
                            <img src="{{ asset('uploads/' . $settings['logo']) }}" alt="{{ $magicbox['title'] }}"
                                class="h-10 w-auto transition-opacity duration-300" id="liteFooterLogo">
                        </div>
                        <p class="lite-text-secondary text-sm leading-relaxed">
                            {{ $settings['description'] }}
                        </p>
                        <div class="flex gap-3 mt-6">
                            <a href="{{ $magicbox['fb'] }}" class="lite-social-icon p-2 text-lg" title="Facebook">
                                <i class="ri-facebook-fill transition-transform duration-300"></i>
                            </a>
                            <a href="{{ $magicbox['tw'] }}" class="lite-social-icon p-2 text-lg" title="Twitter">
                                <i class="ri-twitter-x-fill transition-transform duration-300"></i>
                            </a>
                            <a href="{{ $magicbox['in'] }}" class="lite-social-icon p-2 text-lg" title="Instagram">
                                <i class="ri-instagram-fill transition-transform duration-300"></i>
                            </a>
                            <a href="{{ $magicbox['yt'] }}" class="lite-social-icon p-2 text-lg" title="YouTube">
                                <i class="ri-youtube-fill transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Orta - Sayfalar -->
                    <div class="lg:col-span-1">
                        <h3 class="font-semibold lite-text-primary mb-4 text-lg">Sayfalar</h3>
                        <div class="grid grid-cols-2 gap-2">
                            @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('menu' . $menu_id . '.json'))
                                @php $menus = \Illuminate\Support\Facades\Storage::disk('public')->json('menu'.$menu_id.'.json'); @endphp
                                @php
                                    // İlk 12 menüyü al
                                    $first12Menus = array_slice($menus, 0, 12);
                                    // 2 sütuna böl
                                    $columns = array_chunk($first12Menus, 6);
                                @endphp
                                @foreach ($columns as $column)
                                    <div class="space-y-3">
                                        @foreach ($column as $menu)
                                            <a href="{{ $menu['url'] }}" title="{{ $menu['name'] }}"
                                                class="lite-footer-link block lite-text-secondary text-sm uppercase">
                                                {{ $menu['name'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endforeach
                            @else
                                Menü Bulunamadı
                            @endif

                        </div>
                    </div>

                    <!-- Sağ - Son Dakika Haberleri -->
                    <div class="lg:col-span-1">
                        <h3 class="font-semibold lite-text-primary mb-4 text-lg flex items-center gap-2">
                            <i class="ri-flashlight-line lite-text-accent"></i>
                            Son Dakika
                        </h3>
                        <div class="space-y-4">
                            @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('main/hit_news.json'))
                                @php $son_dakikalar = \Illuminate\Support\Facades\Storage::disk('public')->json('main/hit_news.json'); @endphp
                                @foreach ($son_dakikalar as $mkey => $son_dakika)
                                    <a href="{{ route('post', ['categoryslug' => categoryCheck($son_dakika['category_id'])->slug, 'slug' => $son_dakika['slug'], 'id' => $son_dakika['id']]) }}"
                                        class="lite-footer-news block" title="{{ $son_dakika['title'] }}">
                                        <div class="flex gap-3">

                                            <div class="flex-1 min-w-0">
                                                <p
                                                    class="lite-footer-news-title lite-text-primary text-sm font-medium transition-colors duration-300 line-clamp-2">
                                                    {{ $son_dakika['title'] }}
                                                <p
                                                    class="lite-footer-news-time lite-text-secondary text-xs mt-1 transition-colors duration-300">
                                                    {{ \Carbon\Carbon::parse($son_dakika['created_at'])->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>

                                    @if ($mkey == 2)
                                        @break
                                    @endif
                                @endforeach
                            @else
                                <div class="text-white"> Haberlere Erişilemedi</div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            <!-- Alt Alan - Copyright -->
            <div class="border-t lite-border lite-bg-primary">
                <div class="max-w-6xl mx-auto px-5 py-6">
                    <div
                        class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm lite-text-secondary">
                        <div class="text-center md:text-left">
                            <p>&copy; 2025 Lite Tema. Tüm hakları saklıdır.</p>
                        </div>
                        <div class="text-center md:text-right">
                            <p>Yazılım
                                <a href="https://vmgmedya.com" target="_blank" rel="noopener noreferrer"
                                    class="lite-vmg-link lite-text-accent hover:underline font-medium">
                                    VMG Medya
                                </a>
                                tarafından yapılmıştır
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    @elseif($design == 2)
    @else
        <h5 class="text-danger">Menü ayarlanmamış!</h5>
    @endif
@endif
