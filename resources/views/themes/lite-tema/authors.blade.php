@extends('themes.' . $theme . '.frontend_layout')

@section('meta')
    <title>Yazarlar</title>
    <meta name="description" content="{{ $settings['title'] }} yazar ekibi">
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-5">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Sol Sidebar - Paylaşım Butonları (Desktop) -->
            <!-- <aside class="hidden lg:block lg:col-span-1">
                <div class="share-sticky">
                    <div class="flex flex-col gap-3">
                        <button onclick="shareTwitter()"
                            class="w-12 h-12 rounded-full lite-btn lite-btn-secondary  lite-btn-md flex items-center justify-center transition-all"
                            title="Twitter'da Paylaş">
                            <i class="ri-twitter-x-line text-xl"></i>
                        </button>
                        <button onclick="shareFacebook()"
                            class="w-12 h-12 rounded-full lite-btn lite-btn-secondary  lite-btn-md flex items-center justify-center transition-all"
                            title="Facebook'ta Paylaş">
                            <i class="ri-facebook-fill text-xl"></i>
                        </button>
                        <button onclick="shareLinkedIn()"
                            class="w-12 h-12 rounded-full lite-btn lite-btn-secondary  lite-btn-md flex items-center justify-center transition-all"
                            title="LinkedIn'de Paylaş">
                            <i class="ri-linkedin-fill text-xl"></i>
                        </button>
                        <button onclick="shareWhatsApp()"
                            class="w-12 h-12 rounded-full lite-btn lite-btn-secondary  lite-btn-md flex items-center justify-center transition-all"
                            title="WhatsApp'ta Paylaş">
                            <i class="ri-whatsapp-line text-xl"></i>
                        </button>
                        <button onclick="copyLink()"
                            class="w-12 h-12 rounded-full lite-btn lite-btn-secondary  lite-btn-md flex items-center justify-center transition-all"
                            title="Linki Kopyala">
                            <i class="ri-link text-xl"></i>
                        </button>
                    </div>
                </div>
            </aside> -->

            <!-- Ana İçerik -->
            <section class="lg:col-span-8">
                <!-- Breadcrumb -->
                <nav class="mb-8" aria-label="Breadcrumb">
                    <ol class="flex items-center gap-2 text-sm lite-text-secondary">
                        <li>
                            <a href="{{ route('frontend.index') }}"
                                class="hover:lite-text-accent transition-colors duration-300">
                                Ana Sayfa
                            </a>
                        </li>
                   
                        <li><i class="ri-arrow-right-s-line"></i></li>
                        <li class="lite-text-primary line-clamp-1 w-2/3">@lang('frontend.authors')</li>
                    </ol>
                </nav>

                <div class="mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold lite-text-primary mb-2">@lang('frontend.authors')</h2>
                    <div class="w-16 h-1 lite-bg-accent rounded-full"></div>
                </div>
                @foreach ($authors as $author)
                <!-- Yazar Bilgisi -->
                <div class="lite-bg-secondary border lite-border rounded-xl p-5 mb-6 flex items-start gap-4">
                    <img src="{{ route('resizeImage', ['i_url' => $author->avatar, 'w' => 80, 'h' => 80]) }}" alt="{{ $author->name }}"
                        class="w-24 h-24 rounded-lg object-cover">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-semibold text-lg lite-text-primary">{{ $author->name }}</h3>

                        </div>
                        <p class="lite-text-secondary lg:w-5/6 text-sm mb-2">{{ $author->about ?? 'Yazar hakkında daha fazla bilgi bulunmamaktadır.' }}</p>
                        <div class="flex items-center gap-3  justify-between">

                            <div class="flex items-center  lg:gap-3 gap-1">
                                <a href="#" class="lite-text-secondary hover:lite-text-accent transition-colors">
                                    <i class="ri-twitter-x-line text-lg"></i>
                                </a>
                                <a href="#" class="lite-text-secondary hover:lite-text-accent transition-colors">
                                    <i class="ri-facebook-fill text-lg"></i>
                                </a>
                                <a href="#" class="lite-text-secondary hover:lite-text-accent transition-colors">
                                    <i class="ri-linkedin-fill text-lg"></i>
                                </a>
                                <a href="#" class="lite-text-secondary hover:lite-text-accent transition-colors">
                                    <i class="ri-instagram-fill text-lg"></i>
                                </a>
                            </div>
                            <a href="{{ route('author', ['id' => $author->id]) }}" class="lite-btn lite-btn-outline lite-btn-sm" title="{{ $author->article->title }}">
                                <i class="ri-article-line"></i>
                                <span>Tüm Yazıları</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
                {{ $authors->links('vendor.pagination.lite') }}

            </section>

            <section class="lg:col-span-4 relative">
                <!-- Right Sidebar - Related Articles -->

                <div class="sticky top-24">
                    <!-- Related Articles -->
                    <div class="lite-bg-secondary border lite-border rounded-lg p-6">
                        <h4 class="font-semibold lite-text-primary mb-6 flex items-center gap-2">
                            <i class="ri-newspaper-line lite-text-accent"></i>
                            İlgilinizi Çekebilecek Haberler
                        </h4>
                        @if (count($hit_popups) > 0)
                        <div class="space-y-5">
                            @foreach ($hit_popups as $key => $hit_popup)
                            <article class="group cursor-pointer lite-detail-interesting-news">
                                <a href="{{ route('post', ['categoryslug' => $hit_popup->category->title, 'slug' => $hit_popup->slug, 'id' => $hit_popup->id]) }}"
                                    class="flex gap-4 p-3 rounded-lg hover:lite-bg-accent  hover:bg-opacity-5 transition-all duration-300">
                                    <img src="{{ route('resizeImage', ['i_url' => $hit_popup->images, 'w' => 120, 'h' => 80]) }}" alt="{{ $hit_popup->title }}"
                                        class="w-20 h-14 object-cover rounded flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                                    <div class="flex-1 min-w-0">
                                        <h5
                                            class="lite-text-primary text-sm font-semibold leading-snug line-clamp-3 transition-colors duration-300 mb-2">
                                            {{ $hit_popup->title }}
                                        </h5>
                                        <p class="flex items-center gap-2 text-xs lite-text-secondary">
                                            <i class="ri-time-line"></i>
                                            <span>{{ $hit_popup->created_at->diffForHumans() }}</span>

                                        </p>
                                    </div>
                                </a>
                            </article>
                            @if ($key == 3)
                                @break
                            @endif
                   
                            @endforeach

                        </div>
                        @endif
                        <!-- More Articles Button -->
                        {{-- <div class="mt-8 pt-6 border-t lite-border">
                            <a href="{{ route('category', ['slug' => $hit_popup->category->slug]) }}"
                                class="flex items-center justify-center gap-2 p-4 border lite-border rounded-lg hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300 group">
                                <i class="ri-newspaper-line"></i>
                                <span class="font-medium">Tüm Haberler</span>
                                <i
                                    class="ri-arrow-right-line group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div> --}}


                    </div>
                </div>

            </section>

        </div>
    </div>
@endsection
