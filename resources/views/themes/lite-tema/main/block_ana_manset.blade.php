 <!-- Manşet Bölümü -->
 <section class="max-w-7xl mx-auto lg:px-5 px-2 py-4 mb-0 lg:mb-6">

    <!-- Manşet İçeriği -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        <!-- Yan Haberler (Sağ taraf - 1/3) -->
        <div class="lg:col-span-1 lg:block hidden">
            <div class="lite-manset-sidebar flex flex-col gap-2 justify-between text-base mt-2">
                <a href="#" class="lite-manset-sidebar-link block lite-text-secondary ">
                    <i class="ri-profile-line"></i>Biyografiler
                </a>
                <div class="w-full h-[2px] lite-manset-sidebar-divider"></div>

                <a href="#" class="lite-manset-sidebar-link block lite-text-secondary ">
                    <i class="ri-notification-3-line"></i>Duyurular
                </a>
                <div class="w-full h-[2px] lite-manset-sidebar-divider"></div>

                <a href="#" class="lite-manset-sidebar-link block lite-text-secondary ">
                    <i class="ri-flashlight-line"></i>Elektrik Kesintileri
                </a>
                <div class="w-full h-[2px] lite-manset-sidebar-divider"></div>




                <a href="#" class="lite-manset-sidebar-link block lite-text-secondary ">
                    <i class="ri-cloudy-line"></i>Hava Durumu
                </a>
                <div class="w-full h-[2px] lite-manset-sidebar-divider"></div>

                <a href="#" class="lite-manset-sidebar-link block lite-text-secondary ">
                    <i class="ri-moon-clear-line"></i>Namaz Vakitleri
                </a>
                <div class="w-full h-[2px] lite-manset-sidebar-divider"></div>

                <a href="#" class="lite-manset-sidebar-link block lite-text-secondary ">
                    <i class="ri-capsule-line"></i>Nöbetçi Eczaneler
                </a>
                <div class="w-full h-[2px] lite-manset-sidebar-divider"></div>

                <a href="#" class="lite-manset-sidebar-link block lite-text-secondary ">
                    <i class="ri-bus-line"></i>Otobüs Saatleri
                </a>
                <div class="w-full h-[2px] lite-manset-sidebar-divider"></div>

                <a href="#" class="lite-manset-sidebar-link block lite-text-secondary ">
                    <i class="ri-movie-line"></i>Sinemalar
                </a>
                <div class="w-full h-[2px] lite-manset-sidebar-divider"></div>

                <a href="#" class="lite-manset-sidebar-link block lite-text-secondary ">
                    <i class="ri-water-flash-line"></i>Su Kesintileri
                </a>
                <div class="w-full h-[2px] lite-manset-sidebar-divider"></div>

                <a href="#" class="lite-manset-sidebar-link block lite-text-secondary ">
                    <i class="ri-calendar-event-line"></i>Tarihte Bugün
                </a>
                <div class="w-full h-[2px] lite-manset-sidebar-divider"></div>

                <a href="#" class="lite-manset-sidebar-link block lite-text-secondary ">
                    <i class="ri-road-map-line"></i>Trafik Durumu
                </a>
                <div class="w-full h-[2px] lite-manset-sidebar-divider"></div>

                <a href="#" class="lite-manset-sidebar-link block lite-text-secondary ">
                    <i class="ri-emotion-sad-line"></i>Vefatlar
                </a>
                <div class="w-full h-[2px] lite-manset-sidebar-divider"></div>

                <a href="#" class="lite-manset-sidebar-link block lite-text-secondary ">
                    <i class="ri-radio-line"></i>Yerel Radyolar
                </a>
            </div>

        </div>
       
        <!-- Ana Manşet Slider (Sol taraf - 2/3) -->
        <div class="lg:col-span-3">
            <div class="lite-manset-slider rounded-lg  mb-6 lg:mb-0">
                @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('main/ana_manset.json'))
                @php $ana_mansetler = \Illuminate\Support\Facades\Storage::disk('public')->json('main/ana_manset.json'); @endphp
                <div class="lite-manset-container lite-slider">
                    
                    @foreach($ana_mansetler as $ana_manset)
                    <!-- Manşet Haberi 1 -->
                    <div class="lite-manset-item">
                        <div
                            class="relative overflow-hidden  rounded-lg  h-[550px] lg:h-[600px] lg:mb-0 mb-2 lite-bg-primary border lite-border">
                            <div
                                class="absolute top-2 left-1 py-2 px-3 z-20 glass-effect text-white flex items-center gap-4 text-xs rounded-full">
                                <span><i class="ri-time-line mr-1"></i> {{ \Carbon\Carbon::parse($ana_manset['created_at'])->diffForHumans() }}</span>

                            </div>
                            <div class="flex items-center gap-1 absolute top-2 right-1 z-20">
                                <span id="liteCommentLoadMore"
                                    class="hover:scale-105 transition-all duration-300 glass-effect text-white cursor-pointer  text-base lg:text-lg   px-2 py-1 rounded-lg">
                                    <i class="ri-chat-3-line "></i>
                                </span>
                                <span
                                    class="hover:scale-105 transition-all duration-300 glass-effect text-white cursor-pointer  text-base lg:text-lg   px-2 py-1 rounded-lg">
                                    <i class="ri-share-line  "></i>
                                </span>
                                <span
                                    class="hover:scale-105 transition-all duration-300 glass-effect text-white cursor-pointer  text-base lg:text-lg   px-2 py-1 rounded-lg">
                                    <i class="ri-bookmark-line   "></i>
                                </span>
                            </div>
                            <a href="{{ route('post', ['categoryslug' => $ana_manset['categoryslug'], 'slug' => $ana_manset['slug'], 'id' => $ana_manset['id']]) }}"
                                class="block group relative overflow-hidden h-fit border-b lite-border">

                                <div class="h-[340px]  lg:h-[400px]  overflow-hidden">
                                    <img src="{{ asset($ana_manset['images']) }}" alt="{{ $ana_manset['title'] }}"
                                        class=" object-cover transition-transform duration-500  group-hover:scale-105">
                                </div>


                                <div class="lite-bg-primary  pt-3 px-6 pb-3">
                                    <h3
                                        class="lite-text-secondary text-xl line-clamp-2  lg:text-2xl font-bold mb-3 leading-tight group-hover:lite-text-accent transition-colors duration-300">
                                        {{ $ana_manset['title'] }}
                                    </h3>
                                    <p class="lite-text-secondary  text-xs lg:text-xs mb-3 line-clamp-2 ">
                                        {{ $ana_manset['description'] }}
                                    </p>


                                </div>

                            </a>
                            <div class="flex flex-col pt-3 px-6 pb-3">
                                <div class="flex items-center justify-between gap-4 lite-text-secondary ">
                                    <span class="text-sm flex items-center lite-btn lite-btn-ghost  px-2">
                                        <i class="ri-heart-line mr-1 cursor-pointer text-xl lite-text-accent"></i>
                                        Beğen
                                    </span>
                                    <div class="flex items-center gap-1 lg:w-full w-5/6">
                                        <div class="w-full">
                                            <input type="text" name="name" placeholder="Yorumunuzu yazınız..."
                                                class="w-full px-2 py-2 text-xs rounded-lg border-2 lite-border lite-bg-primary lite-text-primary outline-none transition-all duration-300 focus:lite-accent-border" />
                                        </div>
                                        <div class="w-fit">
                                            <button class="lite-btn lite-btn-primary lite-btn-sm w-full">
                                                <i class="ri-send-plane-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>

                    </div>
                 
                    @endforeach

                </div>
                @endif
            </div>
        </div>


        <!-- Yan Haberler (Sağ taraf - 1/3) -->
        <div class="lg:col-span-1 lg:block hidden">
            <div class="lite-manset-sidebar space-y-6">

                <!-- Trend 1 -->
                <div class="flex flex-col">
                    <span class="text-xs text-gray-400">Gündem</span>
                    <a href="#" class="font-bold text-base hover:underline hover:lite-text-accent">Güllü</a>
                    <span class="text-xs text-gray-500">21K görüntülenme</span>
                </div>

                <!-- Trend 2 -->
                <div class="flex flex-col">
                    <span class="text-xs text-gray-400">Spor</span>
                    <a href="#" class="font-bold text-base hover:underline hover:lite-text-accent">Arda
                        Güler</a>
                    <span class="text-xs text-gray-500">32.6K görüntülenme</span>
                </div>

                <!-- Trend 3 -->
                <div class="flex flex-col">
                    <span class="text-xs text-gray-400">Teknoloji</span>
                    <a href="#" class="font-bold text-base hover:underline hover:lite-text-accent">Iphone
                        Air</a>
                    <span class="text-xs text-gray-500">5,393 görüntülenme</span>
                </div>

                <!-- Trend 4 -->
                <div class="flex flex-col">
                    <span class="text-xs text-gray-400">Finans</span>
                    <a href="#" class="font-bold text-base hover:underline hover:lite-text-accent">#altın</a>
                    <span class="text-xs text-gray-500">3,411 görüntülenme</span>
                </div>
                <!-- Trend 1 -->
                <div class="flex flex-col">
                    <span class="text-xs text-gray-400">Gündem</span>
                    <a href="#" class="font-bold text-base hover:underline hover:lite-text-accent">Güllü</a>
                    <span class="text-xs text-gray-500">21K görüntülenme</span>
                </div>

                <!-- Trend 2 -->
                <div class="flex flex-col">
                    <span class="text-xs text-gray-400">Spor</span>
                    <a href="#" class="font-bold text-base hover:underline hover:lite-text-accent">Arda
                        Güler</a>
                    <span class="text-xs text-gray-500">32.6K görüntülenme</span>
                </div>

                <!-- Trend 3 -->
                <div class="flex flex-col">
                    <span class="text-xs text-gray-400">Teknoloji</span>
                    <a href="#" class="font-bold text-base hover:underline hover:lite-text-accent">Iphone
                        Air</a>
                    <span class="text-xs text-gray-500">5,393 görüntülenme</span>
                </div>



            </div>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto lg:px-5 px-2 py-4 mb-0 lg:mb-6 lg:hidden block">
    <div class="lite-manset-sidebar grid grid-cols-2 gap-6">
        <!-- Trend 1 -->
        <div class="flex flex-col p-4 border rounded-lg">
            <span class="text-xs text-gray-400">Gündem</span>
            <a href="#" class="font-bold text-base hover:underline hover:lite-text-accent">Güllü</a>
            <span class="text-xs text-gray-500">21K görüntülenme</span>
        </div>

        <!-- Trend 2 -->
        <div class="flex flex-col p-4 border rounded-lg">
            <span class="text-xs text-gray-400">Spor</span>
            <a href="#" class="font-bold text-base hover:underline hover:lite-text-accent">Arda Güler</a>
            <span class="text-xs text-gray-500">32.6K görüntülenme</span>
        </div>

        <!-- Trend 3 -->
        <div class="flex flex-col p-4 border rounded-lg">
            <span class="text-xs text-gray-400">Teknoloji</span>
            <a href="#" class="font-bold text-base hover:underline hover:lite-text-accent">Iphone Air</a>
            <span class="text-xs text-gray-500">5,393 görüntülenme</span>
        </div>

        <!-- Trend 4 -->
        <div class="flex flex-col p-4 border rounded-lg">
            <span class="text-xs text-gray-400">Finans</span>
            <a href="#" class="font-bold text-base hover:underline hover:lite-text-accent">#altın</a>
            <span class="text-xs text-gray-500">3,411 görüntülenme</span>
        </div>
        <!-- Trend 3 -->
        <div class="flex flex-col p-4 border rounded-lg">
            <span class="text-xs text-gray-400">Teknoloji</span>
            <a href="#" class="font-bold text-base hover:underline hover:lite-text-accent">Iphone Air</a>
            <span class="text-xs text-gray-500">5,393 görüntülenme</span>
        </div>

        <!-- Trend 4 -->
        <div class="flex flex-col p-4 border rounded-lg">
            <span class="text-xs text-gray-400">Finans</span>
            <a href="#" class="font-bold text-base hover:underline hover:lite-text-accent">#altın</a>
            <span class="text-xs text-gray-500">3,411 görüntülenme</span>
        </div>
    </div>

    <div class="lite-manset-sidebar grid grid-cols-2 gap-4 text-base mt-8">
        <a href="#" class="lite-manset-sidebar-link flex items-center gap-2 lite-text-secondary">
            <i class="ri-profile-line"></i> Biyografiler
        </a>

        <a href="#" class="lite-manset-sidebar-link flex items-center gap-2 lite-text-secondary">
            <i class="ri-notification-3-line"></i> Duyurular
        </a>

        <a href="#" class="lite-manset-sidebar-link flex items-center gap-2 lite-text-secondary">
            <i class="ri-flashlight-line"></i> Elektrik Kesintileri
        </a>

        <a href="#" class="lite-manset-sidebar-link flex items-center gap-2 lite-text-secondary">
            <i class="ri-cloudy-line"></i> Hava Durumu
        </a>

        <a href="#" class="lite-manset-sidebar-link flex items-center gap-2 lite-text-secondary">
            <i class="ri-moon-clear-line"></i> Namaz Vakitleri
        </a>

        <a href="#" class="lite-manset-sidebar-link flex items-center gap-2 lite-text-secondary">
            <i class="ri-capsule-line"></i> Nöbetçi Eczaneler
        </a>

        <a href="#" class="lite-manset-sidebar-link flex items-center gap-2 lite-text-secondary">
            <i class="ri-bus-line"></i> Otobüs Saatleri
        </a>

        <a href="#" class="lite-manset-sidebar-link flex items-center gap-2 lite-text-secondary">
            <i class="ri-movie-line"></i> Sinemalar
        </a>

        <a href="#" class="lite-manset-sidebar-link flex items-center gap-2 lite-text-secondary">
            <i class="ri-water-flash-line"></i> Su Kesintileri
        </a>

        <a href="#" class="lite-manset-sidebar-link flex items-center gap-2 lite-text-secondary">
            <i class="ri-calendar-event-line"></i> Tarihte Bugün
        </a>

        <a href="#" class="lite-manset-sidebar-link flex items-center gap-2 lite-text-secondary">
            <i class="ri-road-map-line"></i> Trafik Durumu
        </a>

        <a href="#" class="lite-manset-sidebar-link flex items-center gap-2 lite-text-secondary">
            <i class="ri-emotion-sad-line"></i> Vefatlar
        </a>

        <a href="#" class="lite-manset-sidebar-link flex items-center gap-2 lite-text-secondary ">
            <i class="ri-radio-line"></i> Yerel Radyolar
        </a>
        <a href="#" class="lite-manset-sidebar-link flex items-center gap-2 lite-text-secondary ">
            <i class="ri-map-line"></i> Gezi Rehberi
        </a>
    </div>



</section>




