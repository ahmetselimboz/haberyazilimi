@if (\Illuminate\Support\Facades\Storage::disk('public')->exists('main/standart_haberler.json'))
    @php
        $global_posts = \Illuminate\Support\Facades\Storage::disk('public')->json('main/standart_haberler.json');
        $csay = 0;
        $c2say = 0;
    @endphp
    @if (categoryCheck($block_category_id) != false)
        @php
            $global_posts = categoryCheck($block_category_id)
                ? collect($global_posts)->where('category_id', $block_category_id)->values()->all()
                : $global_posts;
            $group_category = categoryCheck($block_category_id);
        @endphp

        @if (isset($design))

            @if ($design == 'default')
                <!-- Kategoriler Alanı -->
                <section class="max-w-7xl mx-auto lg:px-5 px-2 py-4 mb-4">
                    <!-- Haberler Başlığı -->
                    <div class="flex items-center justify-between gap-2 mb-8">
                        <div class="">
                            <h2 class="text-2xl md:text-3xl font-bold lite-text-primary mb-2">
                                {{ $group_category->title ?? __('frontend.not_found') }}
                            </h2>
                            <div class="w-16 h-1 lite-bg-accent rounded-full"></div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('category', ['slug' => $group_category->slug, 'id' => $group_category->id]) }}" class="lite-btn underline lite-btn-ghost lite-btn-md">Tümünü Gör</a>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div
                            class="lg:col-span-1 col-span-2 lite-news-item lite-bg-secondary  lg:p-0 p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300">
                            <a href="{{ route('post', ['categoryslug' => $global_posts[0]['categoryslug'], 'slug' => $global_posts[0]['slug'], 'id' => $global_posts[0]['id']]) }}" class="block relative">

                                <div
                                    class="lg:hidden flex items-center gap-1 glass-effect text-xs text-white rounded-full lg:px-2 px-3 lg:py-1 py-2 absolute lg:top-1 top-2 lg:left-1 left-2 z-20">
                                    <i class="ri-menu-search-line"></i>
                                    <span>{{ $global_posts[0]['categorytitle'] }}</span>
                                </div>
                                <div
                                    class="lg:hidden flex items-center gap-1 glass-effect text-xs text-white rounded-full lg:px-2 px-3 lg:py-1 py-2 absolute top-1 right-1 z-20">
                                    <i class="ri-time-line"></i>
                                    <span>{{ \Carbon\Carbon::parse($global_posts[0]['created_at'])->diffForHumans() }}</span>
                                </div>
                                <div class="relative rounded-lg">
                                    <img src="{{ asset($global_posts[0]['images']) }}" alt="{{ $global_posts[0]['title'] }}"
                                        class="w-full lg:h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                </div>
                                <div
                                    class="p-4 absolute bottom-0 left-0 right-0 lg:translate-y-12 translate-y-0 group-hover:translate-y-0   transition-all duration-300">
                                    <h4
                                        class="lite-text-third font-semibold lg:text-base text-lg mb-2 leading-tight  transition-colors duration-300">
                                        {{ $global_posts[0]['title'] }}
                                    </h4>
                                    <p class="lite-text-third  text-xs mb-3 line-clamp-2">
                                        {{ $global_posts[0]['description'] }}
                                    </p>

                                </div>
                            </a>
                        </div>
                        <div class="col-span-2 row-span-2 ">
                            <div
                                class="lite-news-item lite-bg-secondary  p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300">
                                <a href="{{ route('post', ['categoryslug' => $global_posts[1]['categoryslug'], 'slug' => $global_posts[1]['slug'], 'id' => $global_posts[1]['id']]) }}" class="block relative">
                                    <div
                                        class="flex items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 left-2 z-20">
                                        <i class="ri-menu-search-line"></i>
                                        <span>{{ $global_posts[1]['categorytitle'] }}</span>
                                    </div>
                                    <div
                                        class="flex items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 right-2 z-20">
                                        <i class="ri-time-line"></i>
                                        <span>{{ \Carbon\Carbon::parse($global_posts[1]['created_at'])->diffForHumans() }}</span>
                                    </div>
                                    <div class="relative rounded-lg">
                                        <img src="{{ asset($global_posts[1]['images']) }}" alt="{{ $global_posts[1]['title'] }}"
                                            class="w-full lg:h-[379px] object-cover transition-transform duration-500 group-hover:scale-105">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                                        </div>
                                    </div>
                                    <div
                                        class="p-4 absolute bottom-0 left-0 right-0 translate-y-0   transition-all duration-300">
                                        <h4
                                            class="lite-text-third font-semibold lg:text-2xl text-lg mb-2 leading-tight  transition-colors duration-300">
                                            {{ $global_posts[1]['title'] }}
                                        </h4>
                                        <p class="lite-text-third lg:text-base text-xs mb-3 line-clamp-2">
                                            {{ $global_posts[1]['description'] }}
                                        </p>

                                    </div>
                                </a>
                            </div>
                        </div>
                        <div
                            class="lite-news-item lite-bg-secondary  lg:p-0 p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300">
                            <a href="{{ route('post', ['categoryslug' => $global_posts[2]['categoryslug'], 'slug' => $global_posts[2]['slug'], 'id' => $global_posts[2]['id']]) }}" class="block relative">

                                <div
                                    class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-2 py-1 absolute top-1 left-1 z-20">
                                    <i class="ri-menu-search-line"></i>
                                    <span>{{ $global_posts[2]['categorytitle'] }}</span>
                                </div>
                                <div
                                    class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-2 py-1 absolute top-1 right-1 z-20">
                                    <i class="ri-time-line"></i>
                                    <span>{{ \Carbon\Carbon::parse($global_posts[2]['created_at'])->diffForHumans() }}</span>
                                </div>
                                <div class="relative rounded-lg">
                                    <img src="{{ asset($global_posts[2]['images']) }}" alt="{{ $global_posts[2]['title'] }}"
                                        class="w-full h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                </div>
                                <div
                                    class="p-4 absolute bottom-0 left-0 right-0 translate-y-12 group-hover:translate-y-0   transition-all duration-300">
                                    <h4
                                        class="lite-text-third font-semibold lg:text-base text-sm mb-2 leading-tight  transition-colors duration-300">
                                        {{ $global_posts[2]['title'] }}
                                    </h4>
                                    <p class="lite-text-third  text-xs mb-3 line-clamp-2">
                                        {{ $global_posts[2]['description'] }}
                                    </p>

                                </div>
                            </a>
                        </div>
                        <div
                            class="lite-news-item lite-bg-secondary  lg:p-0 p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300">
                            <a href="{{ route('post', ['categoryslug' => $global_posts[3]['categoryslug'], 'slug' => $global_posts[3]['slug'], 'id' => $global_posts[3]['id']]) }}" class="block relative">

                                <div
                                    class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-2 py-1 absolute top-1 left-1 z-20">
                                    <i class="ri-menu-search-line"></i>
                                    <span>{{ $global_posts[3]['categorytitle'] }}</span>
                                </div>
                                <div
                                    class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-2 py-1 absolute top-1 right-1 z-20">
                                    <i class="ri-time-line"></i>
                                    <span>{{ \Carbon\Carbon::parse($global_posts[3]['created_at'])->diffForHumans() }}</span>
                                </div>
                                <div class="relative rounded-lg">
                                    <img src="{{ asset($global_posts[3]['images']) }}" alt="{{ $global_posts[3]['title'] }}"
                                        class="w-full h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                </div>
                                <div
                                    class="p-4 absolute bottom-0 left-0 right-0 translate-y-12 group-hover:translate-y-0   transition-all duration-300">
                                    <h4
                                        class="lite-text-third font-semibold lg:text-base text-sm mb-2 leading-tight  transition-colors duration-300">
                                        {{ $global_posts[3]['title'] }}
                                    </h4>
                                    <p class="lite-text-third  text-xs mb-3 line-clamp-2">
                                        {{ $global_posts[3]['description'] }}
                                    </p>

                                </div>
                            </a>
                        </div>
                        <div
                            class="lite-news-item lite-bg-secondary  lg:p-0 p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300">
                            <a href="{{ route('post', ['categoryslug' => $global_posts[4]['categoryslug'], 'slug' => $global_posts[4]['slug'], 'id' => $global_posts[4]['id']]) }}" class="block relative">

                                <div
                                    class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-2 py-1 absolute top-1 left-1 z-20">
                                    <i class="ri-menu-search-line"></i>
                                    <span>{{ $global_posts[4]['categorytitle'] }}</span>
                                </div>
                                <div
                                    class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-2 py-1 absolute top-1 right-1 z-20">
                                    <i class="ri-time-line"></i>
                                    <span>{{ \Carbon\Carbon::parse($global_posts[4]['created_at'])->diffForHumans() }}</span>
                                </div>
                                <div class="relative rounded-lg">
                                    <img src="{{ asset($global_posts[4]['images']) }}" alt="{{ $global_posts[4]['title'] }}"
                                        class="w-full h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                </div>
                                <div
                                    class="p-4 absolute bottom-0 left-0 right-0 translate-y-12 group-hover:translate-y-0   transition-all duration-300">
                                    <h4
                                        class="lite-text-third font-semibold lg:text-base text-sm mb-2 leading-tight  transition-colors duration-300">
                                        {{ $global_posts[4]['title'] }}
                                    </h4>
                                    <p class="lite-text-third  text-xs mb-3 line-clamp-2">
                                        {{ $global_posts[4]['description'] }}
                                    </p>

                                </div>
                            </a>
                        </div>
                        <div class="lg:col-span-2 ">
                            <div
                                class="lite-news-item lite-bg-secondary  p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300">
                                <a href="{{ route('post', ['categoryslug' => $global_posts[5]['categoryslug'], 'slug' => $global_posts[5]['slug'], 'id' => $global_posts[5]['id']]) }}" class="block relative">
                                    <div
                                        class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 left-2 z-20">
                                        <i class="ri-menu-search-line"></i>
                                        <span>{{ $global_posts[5]['categorytitle'] }}</span>
                                    </div>
                                    <div
                                        class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 right-2 z-20">
                                        <i class="ri-time-line"></i>
                                        <span>{{ \Carbon\Carbon::parse($global_posts[5]['created_at'])->diffForHumans() }}</span>
                                    </div>
                                    <div class="relative rounded-lg">
                                        <img src="{{ asset($global_posts[5]['images']) }}" alt="{{ $global_posts[5]['title'] }}"
                                            class="w-full lg:h-[180px] h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                                        </div>
                                    </div>
                                    <div
                                        class="p-4 absolute bottom-0 left-0 right-0 lg:translate-y-14 translate-y-12 group-hover:translate-y-0   transition-all duration-300">
                                        <h4
                                            class="lite-text-third font-semibold lg:text-xl text-sm mb-2 leading-tight  transition-colors duration-300">
                                            {{ $global_posts[5]['title'] }}
                                        </h4>
                                        <p class="lite-text-third lg:text-sm text-xs mb-3 line-clamp-2">
                                            {{ $global_posts[5]['description'] }}
                                        </p>

                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-span-2 ">
                            <div
                                class="lite-news-item lite-bg-secondary  p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300">
                                <a href="{{ route('post', ['categoryslug' => $global_posts[6]['categoryslug'], 'slug' => $global_posts[6]['slug'], 'id' => $global_posts[6]['id']]) }}" class="block relative">
                                    <div
                                        class="flex items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 left-2 z-20">
                                        <i class="ri-menu-search-line"></i>
                                        <span>{{ $global_posts[6]['categorytitle'] }}</span>
                                    </div>
                                    <div
                                        class="flex items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 right-2 z-20">
                                        <i class="ri-time-line"></i>
                                        <span>{{ \Carbon\Carbon::parse($global_posts[6]['created_at'])->diffForHumans() }}</span>
                                    </div>
                                    <div class="relative rounded-lg">
                                        <img src="{{ asset($global_posts[6]['images']) }}" alt="{{ $global_posts[6]['title'] }}"
                                            class="w-full lg:h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                                        </div>
                                    </div>
                                    <div
                                        class="p-4 absolute bottom-0 left-0 right-0 lg:translate-y-14 translate-y-0 group-hover:translate-y-0   transition-all duration-300">
                                        <h4
                                            class="lite-text-third font-semibold lg:text-xl text-sm mb-2 leading-tight  transition-colors duration-300">
                                            {{ $global_posts[6]['title'] }}
                                        </h4>
                                        <p class="lite-text-third lg:text-sm text-xs mb-3 line-clamp-2">
                                            {{ $global_posts[6]['description'] }}
                                        </p>

                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                </section>
            @elseif($design == 1)
                <!-- Kategoriler Alanı -->
                <section class="max-w-7xl mx-auto lg:px-5 px-2 py-4 mb-4">
                    <!-- Haberler Başlığı -->
                    <div class="flex items-center justify-between gap-2 mb-8">
                        <div class="">
                            <h2 class="text-2xl md:text-3xl font-bold lite-text-primary mb-2">
                                {{ $group_category->title ?? __('frontend.not_found') }}
                            </h2>
                            <div class="w-16 h-1 lite-bg-accent rounded-full"></div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('category', ['slug' => $group_category->slug, 'id' => $group_category->id]) }}" class="lite-btn underline lite-btn-ghost lite-btn-md">Tümünü Gör</a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 ">
                        <div class="col-span-2 md:col-span-3 row-span-2 ">
                            <div
                                class="lite-news-item lite-bg-secondary  p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300">
                                <a href="{{ route('post', ['categoryslug' => $global_posts[0]['categoryslug'], 'slug' => $global_posts[0]['slug'], 'id' => $global_posts[0]['id']]) }}" class="block relative">
                                    <div
                                        class="flex items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 left-2 z-20">
                                        <i class="ri-menu-search-line"></i>
                                        <span>{{ $global_posts[0]['categorytitle'] }}</span>
                                    </div>
                                    <div
                                        class="flex items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 right-2 z-20">
                                        <i class="ri-time-line"></i>
                                        <span>{{ \Carbon\Carbon::parse($global_posts[0]['created_at'])->diffForHumans() }}</span>
                                    </div>
                                    <div class="relative rounded-lg">
                                        <img src="{{ asset($global_posts[0]['images']) }}" alt="{{ $global_posts[0]['title'] }}"
                                            class="w-full lg:h-[379px] object-cover transition-transform duration-500 group-hover:scale-105">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                                        </div>
                                    </div>
                                    <div
                                        class="p-4 absolute bottom-0 left-0 right-0 translate-y-0   transition-all duration-300">
                                        <h4
                                            class="lite-text-third font-semibold lg:text-2xl text-lg mb-2 leading-tight  transition-colors duration-300">
                                            {{ $global_posts[0]['title'] }}
                                        </h4>
                                        <p class="lite-text-third lg:text-base text-xs mb-3 line-clamp-2">
                                            {{ $global_posts[0]['description'] }}
                                        </p>

                                    </div>
                                </a>
                            </div>
                        </div>
                        <div
                            class="lite-news-item lite-bg-secondary  lg:p-0 p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300">
                            <a href="{{ route('post', ['categoryslug' => $global_posts[1]['categoryslug'], 'slug' => $global_posts[1]['slug'], 'id' => $global_posts[1]['id']]) }}" class="block relative">

                                <div
                                    class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-2 py-1 absolute top-1 left-1 z-20">
                                    <i class="ri-menu-search-line"></i>
                                    <span>{{ $global_posts[1]['categorytitle'] }}</span>
                                </div>
                                <div
                                    class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-2 py-1 absolute top-1 right-1 z-20">
                                    <i class="ri-time-line"></i>
                                    <span>{{ \Carbon\Carbon::parse($global_posts[1]['created_at'])->diffForHumans() }}</span>
                                </div>
                                <div class="relative rounded-lg">
                                    <img src="{{ asset($global_posts[1]['images']) }}" alt="{{ $global_posts[1]['title'] }}"
                                        class="w-full h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                </div>
                                <div
                                    class="p-4 absolute bottom-0 left-0 right-0 translate-y-12 group-hover:translate-y-0   transition-all duration-300">
                                    <h4
                                        class="lite-text-third font-semibold lg:text-base text-sm mb-2 leading-tight  transition-colors duration-300">
                                            {{ $global_posts[1]['title'] }}
                                    </h4>
                                    <p class="lite-text-third  text-xs mb-3 line-clamp-2">
                                        {{ $global_posts[1]['description'] }}
                                    </p>

                                </div>
                            </a>
                        </div>
                        <div
                            class="lite-news-item lite-bg-secondary  lg:p-0 p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300">
                            <a href="{{ route('post', ['categoryslug' => $global_posts[2]['categoryslug'], 'slug' => $global_posts[2]['slug'], 'id' => $global_posts[2]['id']]) }}" class="block relative">

                                <div
                                    class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-2 py-1 absolute top-1 left-1 z-20">
                                    <i class="ri-menu-search-line"></i>
                                    <span>{{ $global_posts[2]['categorytitle'] }}</span>
                                </div>
                                <div
                                    class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-2 py-1 absolute top-1 right-1 z-20">
                                    <i class="ri-time-line"></i>
                                    <span>{{ \Carbon\Carbon::parse($global_posts[2]['created_at'])->diffForHumans() }}</span>
                                </div>
                                <div class="relative rounded-lg">
                                    <img src="{{ asset($global_posts[2]['images']) }}" alt="{{ $global_posts[2]['title'] }}"
                                        class="w-full h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                </div>
                                <div
                                    class="p-4 absolute bottom-0 left-0 right-0 translate-y-12 group-hover:translate-y-0   transition-all duration-300">
                                    <h4
                                        class="lite-text-third font-semibold lg:text-base text-sm mb-2 leading-tight  transition-colors duration-300">
                                        {{ $global_posts[2]['title'] }}
                                    </h4>
                                    <p class="lite-text-third  text-xs mb-3 line-clamp-2">
                                        {{ $global_posts[2]['description'] }}
                                    </p>

                                </div>
                            </a>
                        </div>
                        <div
                            class="col-span-2 md:col-span-1  lite-news-item lite-bg-secondary  lg:p-0 p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300">
                            <a href="{{ route('post', ['categoryslug' => $global_posts[3]['categoryslug'], 'slug' => $global_posts[3]['slug'], 'id' => $global_posts[3]['id']]) }}" class="block relative">

                                <div
                                    class="flex items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 left-2 z-20">
                                    <i class="ri-menu-search-line"></i>
                                    <span>{{ $global_posts[3]['categorytitle'] }}</span>
                                </div>
                                <div
                                    class="flex items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 right-2 z-20">
                                    <i class="ri-time-line"></i>
                                    <span>{{ \Carbon\Carbon::parse($global_posts[3]['created_at'])->diffForHumans() }}</span>
                                </div>
                                <div class="relative rounded-lg">
                                    <img src="{{ asset($global_posts[3]['images']) }}" alt="{{ $global_posts[3]['title'] }}"
                                        class="w-full lg:h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                </div>
                                <div
                                    class="p-4 absolute bottom-0 left-0 right-0 lg:translate-y-12 translate-y-0 group-hover:translate-y-0   transition-all duration-300">
                                    <h4
                                        class="lite-text-third font-semibold lg:text-base text-lg mb-2 leading-tight  transition-colors duration-300">
                                        {{ $global_posts[3]['title'] }}
                                    </h4>
                                    <p class="lite-text-third text-xs mb-3 line-clamp-2">
                                        {{ $global_posts[3]['description'] }}
                                    </p>

                                </div>
                            </a>
                        </div>
                        <div class="col-span-2 md:col-span-3  ">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 ">
                                <div
                                    class="lite-news-item lite-bg-secondary  lg:p-0 p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300">
                                    <a href="{{ route('post', ['categoryslug' => $global_posts[4]['categoryslug'], 'slug' => $global_posts[4]['slug'], 'id' => $global_posts[4]['id']]) }}" class="block relative">
                                        <div
                                            class="flex items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 left-2 z-20">
                                            <i class="ri-menu-search-line"></i>
                                            <span>{{ $global_posts[4]['categorytitle'] }}</span>
                                        </div>
                                        <div
                                            class="flex items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 right-2 z-20">
                                            <i class="ri-time-line"></i>
                                            <span>{{ \Carbon\Carbon::parse($global_posts[4]['created_at'])->diffForHumans() }}</span>
                                        </div>
                                        <div class="relative rounded-lg">
                                            <img src="{{ asset($global_posts[4]['images']) }}" alt="{{ $global_posts[4]['title'] }}"
                                                class="w-full lg:h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                                            </div>
                                        </div>
                                        <div
                                            class="p-4 absolute bottom-0 left-0 right-0 lg:translate-y-12 translate-y-0 group-hover:translate-y-0   transition-all duration-300">
                                            <h4
                                                class="lite-text-third font-semibold lg:text-xl text-sm  mb-2 leading-tight  transition-colors duration-300">
                                                {{ $global_posts[4]['title'] }}
                                            </h4>
                                            <p class="lite-text-third text-xs mb-3 line-clamp-2">
                                                {{ $global_posts[4]['description'] }}
                                            </p>

                                        </div>
                                    </a>
                                </div>
                                <div
                                    class="lite-news-item lite-bg-secondary  lg:p-0 p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300">
                                    <a href="{{ route('post', ['categoryslug' => $global_posts[5]['categoryslug'], 'slug' => $global_posts[5]['slug'], 'id' => $global_posts[5]['id']]) }}" class="block relative">
                                        <div
                                            class="flex items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 left-2 z-20">
                                            <i class="ri-menu-search-line"></i>
                                            <span>{{ $global_posts[5]['categorytitle'] }}</span>
                                        </div>
                                        <div
                                            class="flex items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 right-2 z-20">
                                            <i class="ri-time-line"></i>
                                            <span>{{ \Carbon\Carbon::parse($global_posts[5]['created_at'])->diffForHumans() }}</span>
                                        </div>
                                        <div class="relative rounded-lg">
                                            <img src="{{ asset($global_posts[5]['images']) }}" alt="{{ $global_posts[5]['title'] }}"
                                                class="w-full lg:h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                                            </div>
                                        </div>
                                        <div
                                            class="p-4 absolute bottom-0 left-0 right-0 lg:translate-y-12 translate-y-0 group-hover:translate-y-0   transition-all duration-300">
                                            <h4
                                                class="lite-text-third font-semibold lg:text-xl text-sm  mb-2 leading-tight  transition-colors duration-300">
                                                {{ $global_posts[5]['title'] }}
                                            </h4>
                                            <p class="lite-text-third text-xs mb-3 line-clamp-2">
                                                {{ $global_posts[5]['description'] }}
                                            </p>

                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Haberler Listesi -->

                </section>
            @elseif($design == 2)
                <!-- Kategoriler Alanı -->
                <section class="max-w-7xl mx-auto lg:px-5 px-2 py-4 mb-4">
                    <!-- Haberler Başlığı -->
                    <div class="flex items-center justify-between gap-2 mb-8">
                        <div class="">
                            <h2 class="text-2xl md:text-3xl font-bold lite-text-primary mb-2">
                                {{ $group_category->title ?? __('frontend.not_found') }}
                            </h2>
                            <div class="w-16 h-1 lite-bg-accent rounded-full"></div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('category', ['slug' => $group_category->slug, 'id' => $group_category->id]) }}" class="lite-btn underline lite-btn-ghost lite-btn-md">Tümünü Gör</a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 ">
                        <div class="col-span-2">
                            <div
                                class="lite-news-item lite-bg-secondary  p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300">
                                <a href="{{ route('post', ['categoryslug' => $global_posts[0]['categoryslug'], 'slug' => $global_posts[0]['slug'], 'id' => $global_posts[0]['id']]) }}" class="block relative">
                                    <div
                                        class="flex items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 left-2 z-20">
                                        <i class="ri-menu-search-line"></i>
                                        <span>{{ $global_posts[0]['categorytitle'] }}</span>
                                    </div>
                                    <div
                                        class="flex items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 right-2 z-20">
                                        <i class="ri-time-line"></i>
                                        <span>{{ \Carbon\Carbon::parse($global_posts[0]['created_at'])->diffForHumans() }}</span>
                                    </div>
                                    <div class="relative rounded-lg">
                                        <img src="{{ asset($global_posts[0]['images']) }}" alt="{{ $global_posts[0]['title'] }}"
                                            class="w-full lg:h-[180px]  object-cover transition-transform duration-500 group-hover:scale-105">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                                        </div>
                                    </div>
                                    <div
                                        class="p-4 absolute bottom-0 left-0 right-0 lg:translate-y-14 translate-y-0 group-hover:translate-y-0   transition-all duration-300">
                                        <h4
                                            class="lite-text-third font-semibold lg:text-xl text-lg mb-2 leading-tight  transition-colors duration-300">
                                            {{ $global_posts[0]['title'] }}
                                        </h4>
                                        <p class="lite-text-third lg:text-sm text-xs mb-3 line-clamp-2">
                                            {{ $global_posts[0]['description'] }}
                                        </p>

                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-span-2 row-span-2 ">
                            <div
                                class="lite-news-item lite-bg-secondary  p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300">
                                <a href="{{ route('post', ['categoryslug' => $global_posts[1]['categoryslug'], 'slug' => $global_posts[1]['slug'], 'id' => $global_posts[1]['id']]) }}" class="block relative">
                                    <div
                                        class="flex items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 left-2 z-20">
                                        <i class="ri-menu-search-line"></i>
                                        <span>{{ $global_posts[1]['categorytitle'] }}</span>
                                    </div>
                                    <div
                                        class="flex items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 right-2 z-20">
                                        <i class="ri-time-line"></i>
                                        <span>{{ \Carbon\Carbon::parse($global_posts[1]['created_at'])->diffForHumans() }}</span>
                                    </div>
                                    <div class="relative rounded-lg">
                                        <img src="{{ asset($global_posts[1]['images']) }}" alt="{{ $global_posts[1]['title'] }}"
                                            class="w-full lg:h-[379px] object-cover transition-transform duration-500 group-hover:scale-105">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                                        </div>
                                    </div>
                                    <div
                                        class="p-4 absolute bottom-0 left-0 right-0 translate-y-0   transition-all duration-300">
                                        <h4
                                            class="lite-text-third font-semibold lg:text-2xl text-lg mb-2 leading-tight  transition-colors duration-300">
                                            {{ $global_posts[1]['title'] }}
                                        </h4>
                                        <p class="lite-text-third lg:text-base text-xs mb-3 line-clamp-2">
                                            {{ $global_posts[1]['description'] }}
                                        </p>

                                    </div>
                                </a>
                            </div>
                        </div>
                        <div
                            class="lg:row-span-2 lite-news-item lite-bg-secondary  lg:p-0 p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300">
                            <a href="{{ route('post', ['categoryslug' => $global_posts[2]['categoryslug'], 'slug' => $global_posts[2]['slug'], 'id' => $global_posts[2]['id']]) }}" class="block relative">

                                <div
                                    class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 left-2 z-20">
                                    <i class="ri-menu-search-line"></i>
                                    <span>{{ $global_posts[2]['categorytitle'] }}</span>
                                </div>
                                <div
                                    class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 right-2 z-20">
                                    <i class="ri-time-line"></i>
                                    <span>{{ \Carbon\Carbon::parse($global_posts[2]['created_at'])->diffForHumans() }}</span>
                                </div>
                                <div class="relative rounded-lg">
                                    <img src="{{ asset($global_posts[2]['images']) }}" alt="{{ $global_posts[2]['title'] }}"
                                        class="w-full lg:h-[379px] h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                </div>
                                <div
                                    class="p-4 absolute bottom-0 left-0 right-0 lg:translate-y-12 translate-y-12 group-hover:translate-y-0   transition-all duration-300">
                                    <h4
                                        class="lite-text-third font-semibold lg:text-base text-sm mb-2 leading-tight  transition-colors duration-300">
                                        {{ $global_posts[2]['title'] }}
                                    </h4>
                                    <p class="lite-text-third text-xs mb-3 line-clamp-2">
                                        {{ $global_posts[2]['description'] }}
                                    </p>

                                </div>
                            </a>
                        </div>
                        <div
                            class="lite-news-item lite-bg-secondary  lg:p-0 p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300">

                            <a href="{{ route('post', ['categoryslug' => $global_posts[3]['categoryslug'], 'slug' => $global_posts[3]['slug'], 'id' => $global_posts[3]['id']]) }}" class="block relative">

                                <div class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-2 py-1 absolute top-1 left-1 z-20"
                                    bis_skin_checked="1">
                                    <i class="ri-menu-search-line"></i>
                                    <span>{{ $global_posts[3]['categorytitle'] }}</span>
                                </div>
                                <div class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-2 py-1 absolute top-1 right-1 z-20"
                                    bis_skin_checked="1">
                                    <i class="ri-time-line"></i>
                                    <span>{{ \Carbon\Carbon::parse($global_posts[3]['created_at'])->diffForHumans() }}</span>
                                </div>
                                <div class="relative rounded-lg" bis_skin_checked="1">
                                    <img src="{{ asset($global_posts[3]['images']) }}" alt="{{ $global_posts[3]['title'] }}"
                                        class="w-full h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"
                                        bis_skin_checked="1">
                                    </div>
                                </div>
                                <div class="p-4 absolute bottom-0 left-0 right-0 translate-y-12 group-hover:translate-y-0   transition-all duration-300"
                                    bis_skin_checked="1">
                                    <h4
                                        class="lite-text-third font-semibold lg:text-base text-sm mb-2 leading-tight  transition-colors duration-300">
                                        {{ $global_posts[3]['title'] }}
                                    </h4>
                                    <p class="lite-text-third  text-xs mb-3 line-clamp-2">
                                        {{ $global_posts[3]['description'] }}
                                    </p>

                                </div>
                            </a>
                        </div>
                        <div class="lg:col-span-2 ">
                            <div class="lite-news-item lite-bg-secondary  p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300"
                                bis_skin_checked="1">
                                <a href="{{ route('post', ['categoryslug' => $global_posts[4]['categoryslug'], 'slug' => $global_posts[4]['slug'], 'id' => $global_posts[4]['id']]) }}" class="block relative">
                                    <div class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 left-2 z-20"
                                        bis_skin_checked="1">
                                        <i class="ri-menu-search-line"></i>
                                        <span>{{ $global_posts[4]['categorytitle'] }}</span>
                                    </div>
                                    <div class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 right-2 z-20"
                                        bis_skin_checked="1">
                                        <i class="ri-time-line"></i>
                                        <span>{{ \Carbon\Carbon::parse($global_posts[4]['created_at'])->diffForHumans() }}</span>
                                    </div>
                                    <div class="relative rounded-lg" bis_skin_checked="1">
                                        <img src="{{ asset($global_posts[4]['images']) }}" alt="{{ $global_posts[4]['title'] }}"
                                            class="w-full lg:h-[180px] h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"
                                            bis_skin_checked="1">
                                        </div>
                                    </div>
                                    <div class="p-4 absolute bottom-0 left-0 right-0 lg:translate-y-14 translate-y-12 group-hover:translate-y-0   transition-all duration-300"
                                        bis_skin_checked="1">
                                        <h4
                                            class="lite-text-third font-semibold lg:text-xl text-sm mb-2 leading-tight  transition-colors duration-300">
                                            {{ $global_posts[4]['title'] }}
                                        </h4>
                                        <p class="lite-text-third lg:text-sm text-xs mb-3 line-clamp-2">
                                            {{ $global_posts[4]['description'] }}
                                        </p>

                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="lite-news-item lite-bg-secondary  lg:p-0 p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300"
                            bis_skin_checked="1">

                            <a href="{{ route('post', ['categoryslug' => $global_posts[5]['categoryslug'], 'slug' => $global_posts[5]['slug'], 'id' => $global_posts[5]['id']]) }}" class="block relative">

                                <div class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-2 py-1 absolute top-1 left-1 z-20"
                                    bis_skin_checked="1">
                                    <i class="ri-menu-search-line"></i>
                                    <span>{{ $global_posts[5]['categorytitle'] }}</span>
                                </div>
                                <div class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-2 py-1 absolute top-1 right-1 z-20"
                                    bis_skin_checked="1">
                                    <i class="ri-time-line"></i>
                                    <span>{{ \Carbon\Carbon::parse($global_posts[5]['created_at'])->diffForHumans() }}</span>
                                </div>
                                <div class="relative rounded-lg" bis_skin_checked="1">
                                    <img src="{{ asset($global_posts[5]['images']) }}" alt="{{ $global_posts[5]['title'] }}"
                                        class="w-full h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"
                                        bis_skin_checked="1">
                                    </div>
                                </div>
                                <div class="p-4 absolute bottom-0 left-0 right-0 translate-y-12 group-hover:translate-y-0   transition-all duration-300"
                                    bis_skin_checked="1">
                                    <h4
                                        class="lite-text-third font-semibold lg:text-base text-sm mb-2 leading-tight  transition-colors duration-300">
                                        {{ $global_posts[5]['title'] }}
                                    </h4>
                                    <p class="lite-text-third  text-xs mb-3 line-clamp-2">
                                        {{ $global_posts[5]['description'] }}
                                    </p>

                                </div>
                            </a>
                        </div>
                    </div>

                </section>
            @elseif($design == 3)
    
                <!-- Kategoriler Alanı -->
                <section class="max-w-7xl mx-auto lg:px-5 px-2 py-4 mb-4">
                    <!-- Haberler Başlığı -->
                    <div class="flex items-center justify-between gap-2 mb-8">
                        <div class="">
                            <h2 class="text-2xl md:text-3xl font-bold lite-text-primary mb-2">
                                {{ $group_category->title ?? __('frontend.not_found') }}
                            </h2>
                            <div class="w-16 h-1 lite-bg-accent rounded-full"></div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('category', ['slug' => $group_category->slug, 'id' => $group_category->id]) }}"
                                class="lite-btn underline lite-btn-ghost lite-btn-md">Tümünü Gör</a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 ">
                        <div class="lite-news-item lite-bg-secondary  lg:p-0 p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300"
                            bis_skin_checked="1">
                            <a href="{{ route('post', ['categoryslug' => $global_posts[0]['categoryslug'], 'slug' => $global_posts[0]['slug'], 'id' => $global_posts[0]['id']]) }}" class="block relative">

                                <div class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-2 py-1 absolute top-1 left-1 z-20"
                                    bis_skin_checked="1">
                                    <i class="ri-menu-search-line"></i>
                                    <span>{{ $global_posts[0]['categorytitle'] }}</span>
                                </div>
                                <div class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-2 py-1 absolute top-1 right-1 z-20"
                                    bis_skin_checked="1">
                                    <i class="ri-time-line"></i>
                                    <span>{{ \Carbon\Carbon::parse($global_posts[0]['created_at'])->diffForHumans() }}</span>
                                </div>
                                <div class="relative rounded-lg" bis_skin_checked="1">
                                    <img src="{{ asset($global_posts[0]['images']) }}" alt="{{ $global_posts[0]['title'] }}"
                                        class="w-full h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"
                                        bis_skin_checked="1">
                                    </div>
                                </div>
                                <div class="p-4 absolute bottom-0 left-0 right-0 translate-y-12 group-hover:translate-y-0   transition-all duration-300"
                                    bis_skin_checked="1">
                                    <h4
                                        class="lite-text-third font-semibold lg:text-base text-sm mb-2 leading-tight  transition-colors duration-300">
                                        {{ $global_posts[0]['title'] }}
                                    </h4>
                                    <p class="lite-text-third  text-xs mb-3 line-clamp-2">
                                        {{ $global_posts[0]['description'] }}
                                    </p>

                                </div>
                            </a>
                        </div>
                        <div class="lg:col-span-2 lite-news-item lite-bg-secondary  p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300"
                            bis_skin_checked="1">
                            <a href="{{ route('post', ['categoryslug' => $global_posts[1]['categoryslug'], 'slug' => $global_posts[1]['slug'], 'id' => $global_posts[1]['id']]) }}" class="block relative">
                                <div class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 left-2 z-20"
                                    bis_skin_checked="1">
                                    <i class="ri-menu-search-line"></i>
                                    <span>{{ $global_posts[1]['categorytitle'] }}</span>
                                </div>
                                <div class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 right-2 z-20"
                                    bis_skin_checked="1">
                                    <i class="ri-time-line"></i>
                                    <span>{{ \Carbon\Carbon::parse($global_posts[1]['created_at'])->diffForHumans() }}</span>
                                </div>
                                <div class="relative rounded-lg" bis_skin_checked="1">
                                    <img src="{{ asset($global_posts[1]['images']) }}" alt="{{ $global_posts[1]['title'] }}"
                                        class="w-full lg:h-[180px] h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"
                                        bis_skin_checked="1">
                                    </div>
                                </div>
                                <div class="p-4 absolute bottom-0 left-0 right-0 lg:translate-y-14 translate-y-12 group-hover:translate-y-0   transition-all duration-300"
                                    bis_skin_checked="1">
                                    <h4
                                        class="lite-text-third font-semibold lg:text-xl text-sm mb-2 leading-tight  transition-colors duration-300">
                                        {{ $global_posts[1]['title'] }}
                                    </h4>
                                    <p class="lite-text-third lg:text-sm text-xs mb-3 line-clamp-2">
                                        {{ $global_posts[1]['description'] }}
                                    </p>

                                </div>
                            </a>
                        </div>
                        <div class="lg:col-span-1 col-span-2 lite-news-item lite-bg-secondary  lg:p-0 p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300"
                            bis_skin_checked="1">
                            <a href="{{ route('post', ['categoryslug' => $global_posts[2]['categoryslug'], 'slug' => $global_posts[2]['slug'], 'id' => $global_posts[2]['id']]) }}" class="block relative">

                                <div class="flex  items-center gap-1 glass-effect text-xs text-white rounded-full lg:px-2 px-3 lg:py-1 py-2 absolute lg:top-1 top-2 lg:left-1 left-2 z-20"
                                    bis_skin_checked="1">
                                    <i class="ri-menu-search-line"></i>
                                    <span>{{ $global_posts[2]['categorytitle'] }}</span>
                                </div>
                                <div class="flex items-center gap-1 glass-effect text-xs text-white rounded-full lg:px-2 px-3 lg:py-1 py-2 absolute lg:top-1 top-2 lg:right-1 right-2 z-20"
                                    bis_skin_checked="1">
                                    <i class="ri-time-line"></i>
                                    <span>{{ \Carbon\Carbon::parse($global_posts[2]['created_at'])->diffForHumans() }}</span>
                                </div>
                                <div class="relative rounded-lg" bis_skin_checked="1">
                                    <img src="{{ asset($global_posts[2]['images']) }}" alt="{{ $global_posts[2]['title'] }}"
                                        class="w-full lg:h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"
                                        bis_skin_checked="1">
                                    </div>
                                </div>
                                <div class="p-4 absolute bottom-0 left-0 right-0 translate-y-12 group-hover:translate-y-0   transition-all duration-300"
                                    bis_skin_checked="1">
                                    <h4
                                        class="lite-text-third font-semibold lg:text-base text-sm mb-2 leading-tight  transition-colors duration-300">
                                        {{ $global_posts[2]['title'] }}
                                    </h4>
                                    <p class="lite-text-third  text-xs mb-3 line-clamp-2">
                                        {{ $global_posts[2]['description'] }}
                                    </p>

                                </div>
                            </a>
                        </div>
                        <div class="col-span-2 row-span-2">
                            <div class="lite-news-item lite-bg-secondary  p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300"
                                bis_skin_checked="1">
                                <a href="{{ route('post', ['categoryslug' => $global_posts[3]['categoryslug'], 'slug' => $global_posts[3]['slug'], 'id' => $global_posts[3]['id']]) }}" class="block relative">
                                    <div class="flex items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 left-2 z-20"
                                        bis_skin_checked="1">
                                        <i class="ri-menu-search-line"></i>
                                        <span>{{ $global_posts[3]['categorytitle'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 right-2 z-20"
                                        bis_skin_checked="1">
                                        <i class="ri-time-line"></i>
                                        <span>{{ \Carbon\Carbon::parse($global_posts[3]['created_at'])->diffForHumans() }}</span>
                                    </div>
                                    <div class="relative rounded-lg" bis_skin_checked="1">
                                        <img src="{{ asset($global_posts[3]['images']) }}" alt="{{ $global_posts[3]['title'] }}"
                                            class="w-full lg:h-[379px] object-cover transition-transform duration-500 group-hover:scale-105">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"
                                            bis_skin_checked="1">
                                        </div>
                                    </div>
                                    <div class="p-4 absolute bottom-0 left-0 right-0 translate-y-0   transition-all duration-300"
                                        bis_skin_checked="1">
                                        <h4
                                            class="lite-text-third font-semibold lg:text-2xl text-lg mb-2 leading-tight  transition-colors duration-300">
                                            {{ $global_posts[3]['title'] }}
                                        </h4>
                                        <p class="lite-text-third lg:text-base text-xs mb-3 line-clamp-2">
                                            {{ $global_posts[3]['description'] }}
                                        </p>

                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="lg:col-span-2 lite-news-item lite-bg-secondary  p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300"
                            bis_skin_checked="1">
                            <a href="{{ route('post', ['categoryslug' => $global_posts[4]['categoryslug'], 'slug' => $global_posts[4]['slug'], 'id' => $global_posts[4]['id']]) }}" class="block relative">
                                <div class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 left-2 z-20"
                                    bis_skin_checked="1">
                                    <i class="ri-menu-search-line"></i>
                                    <span>{{ $global_posts[4]['categorytitle'] }}</span>
                                </div>
                                <div class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 right-2 z-20"
                                    bis_skin_checked="1">
                                    <i class="ri-time-line"></i>
                                    <span>{{ \Carbon\Carbon::parse($global_posts[4]['created_at'])->diffForHumans() }}</span>
                                </div>
                                <div class="relative rounded-lg" bis_skin_checked="1">
                                    <img src="{{ asset($global_posts[4]['images']) }}" alt="{{ $global_posts[4]['title'] }}"
                                        class="w-full lg:h-[180px] h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"
                                        bis_skin_checked="1">
                                    </div>
                                </div>
                                <div class="p-4 absolute bottom-0 left-0 right-0 lg:translate-y-14 translate-y-12 group-hover:translate-y-0   transition-all duration-300"
                                    bis_skin_checked="1">
                                    <h4
                                        class="lite-text-third font-semibold lg:text-xl text-sm mb-2 leading-tight  transition-colors duration-300">
                                        {{ $global_posts[4]['title'] }}
                                    </h4>
                                    <p class="lite-text-third lg:text-sm text-xs mb-3 line-clamp-2">
                                        {{ $global_posts[4]['description'] }}
                                    </p>

                                </div>
                            </a>
                        </div>
                        <div class="lg:col-span-2 lite-news-item lite-bg-secondary  p-0  border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300"
                            bis_skin_checked="1">
                            <a href="{{ route('post', ['categoryslug' => $global_posts[5]['categoryslug'], 'slug' => $global_posts[5]['slug'], 'id' => $global_posts[5]['id']]) }}" class="block relative">
                                <div class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 left-2 z-20"
                                    bis_skin_checked="1">
                                    <i class="ri-menu-search-line"></i>
                                    <span>{{ $global_posts[5]['categorytitle'] }}</span>
                                </div>
                                <div class="lg:flex hidden items-center gap-1 glass-effect text-xs text-white rounded-full px-3 py-2 absolute top-2 right-2 z-20"
                                    bis_skin_checked="1">
                                    <i class="ri-time-line"></i>
                                    <span>{{ \Carbon\Carbon::parse($global_posts[5]['created_at'])->diffForHumans() }}</span>
                                </div>
                                <div class="relative rounded-lg" bis_skin_checked="1">
                                    <img src="{{ asset($global_posts[5]['images']) }}" alt="{{ $global_posts[5]['title'] }}"
                                        class="w-full lg:h-[180px] h-[180px] object-cover transition-transform duration-500 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"
                                        bis_skin_checked="1">
                                    </div>
                                </div>
                                <div class="p-4 absolute bottom-0 left-0 right-0 lg:translate-y-14 translate-y-12 group-hover:translate-y-0   transition-all duration-300"
                                    bis_skin_checked="1">
                                    <h4
                                        class="lite-text-third font-semibold lg:text-xl text-sm mb-2 leading-tight  transition-colors duration-300">
                                        {{ $global_posts[5]['title'] }}
                                    </h4>
                                    <p class="lite-text-third lg:text-sm text-xs mb-3 line-clamp-2">
                                        {{ $global_posts[5]['description'] }}
                                    </p>

                                </div>
                            </a>
                        </div>

                    </div>


                </section>
            @else
            @endif
        @else
        @endif
    @endif
@else
@endif
