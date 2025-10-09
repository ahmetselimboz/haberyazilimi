    @if ($magicbox['author_status'] == 0)

        @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('main/authors.json'))
            @php $authors = \Illuminate\Support\Facades\Storage::disk('public')->json('main/authors.json'); @endphp


            <!-- Yazarlar Alanı -->
            <section class="max-w-7xl mx-auto lg:px-5 px-2 py-4">
                <!-- Yazarlar Başlığı -->
                <div class="flex items-center justify-between gap-2">
                    <div class="">
                        <h2 class="text-2xl md:text-3xl font-bold lite-text-primary mb-2">Yazarlar</h2>
                        <div class="w-16 h-1 lite-bg-accent rounded-full"></div>
                    </div>
                    <div class="flex items-center lg:gap-4 gap-1">
                        <!-- Yazarlar Slider Navigation -->
                        <div class="flex items-center gap-2">
                            <button type="button" class="lite-authors-prev lite-slider-nav-btn" title="Önceki">
                                <i class="ri-arrow-left-line"></i>
                            </button>
                            <button type="button" class="lite-authors-next lite-slider-nav-btn" title="Sonraki">
                                <i class="ri-arrow-right-line"></i>
                            </button>
                        </div>
                        <a href="/authors.html" class="lite-btn underline lite-btn-ghost lite-btn-md">Tümünü Gör</a>
                    </div>
                </div>
                <div class="mt-8">
                    <!-- Yazarlar Slider Container -->
                    <div class="lite-authors-slider relative">
                        <!-- Slider Container -->
                        <div class="lite-authors-container">
                            
                            @foreach($authors as $author)
                            <!-- Yazar Item 1 -->
                            <div class="lite-author-item p-4">
                                <a href="{{ route('article', ['slug' => $author['latest_article']['slug'], 'id' => $author['latest_article']['id']]) }}" class="block">
                                    <div
                                        class="lite-bg-secondary border lite-border rounded-lg px-4 hover:shadow-lg transition-all duration-300 group cursor-pointer">
                                        <div class="flex items-center justify-between gap-4">
                                            <!-- Sol taraf - Yazı İçeriği -->
                                            <div class="flex-1">
                                                <h3
                                                    class="font-semibold lite-text-primary line-clamp-3 text-base mb-2 group-hover:lite-text-accent transition-colors duration-300">
                                                    {{ $author['latest_article']['title'] }}
                                                </h3>
                                                <p class="lite-text-secondary text-sm font-medium">
                                                    <i class="ri-user-line mr-1"></i>
                                                    {{ $author['name'] }}
                                                </p>
                                            </div>
                                            <!-- Sağ taraf - Yazar Fotoğrafı -->
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-16 h-16 rounded-lg overflow-hidden border-2 lite-border group-hover:lite-accent-border transition-all duration-300">
                                                    <img src="{{ asset($author['avatar']) }}"
                                                        alt="{{ $author['name'] }}"
                                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @else
            <div class="container d-none">
                <div class="row">
                    <div class="alert alert-warning"> @lang('frontend.authors_not_found') </div>
                </div>
            </div>
        @endif
    @else
        <div class="container d-none">
            <div class="row">
                <div class="alert alert-warning"> @lang('frontend.authors_module_closed') </div>
            </div>
        </div>

    @endif
