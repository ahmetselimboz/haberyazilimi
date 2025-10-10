@extends('themes.' . $theme . '.frontend_layout')

@section('meta')
    <title>{{ $author->name }} - {{ $settings['title'] }}</title>
    <meta name="description" content="{{ $settings['title'] }} yazar ekibi">
@endsection

@section('content')
    <div class="flex gap-8 relative px-5">
        <!-- Left Sidebar -->
        <aside class="w-64 hidden xl:block">
            <!-- Fixed Navigation Tools -->
            <div class="sticky top-24">
                <!-- Article Tools -->
                <!-- <div class="flex flex-col mb-6 ">
                    <h3 class="text-lg font-semibold lite-text-primary">
                        <i class="ri-user-star-line lite-text-accent mr-2"></i>
                        Takip Et
                    </h3>
                    <div class="w-16 h-1 lite-bg-accent rounded-full"></div>
                </div> -->


                <div class="lite-bg-secondary border lite-border rounded-lg p-6">
                    <h4 class="font-semibold lite-text-primary mb-6 flex items-center gap-2">
                        <i class="ri-mail-line lite-text-accent"></i>
                        İletişime Geç
                    </h4>
                    <div class="space-y-3">

                        <button
                            class="w-full flex items-center gap-3 p-3 rounded-lg border lite-border hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300">
                            <i class="ri-facebook-fill text-blue-600"></i>
                            Facebook
                        </button>
                        <button
                            class="w-full flex items-center gap-3 p-3 rounded-lg border lite-border hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300">
                            <i class="ri-twitter-x-fill"></i>
                            Twitter
                        </button>
                        <button
                            class="w-full flex items-center gap-3 p-3 rounded-lg border lite-border hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300">
                            <i class="ri-linkedin-fill text-blue-700"></i>
                            LinkedIn
                        </button>
                        <button
                            class="w-full flex items-center gap-3 p-3 rounded-lg border lite-border hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300">
                            <i class="ri-whatsapp-fill text-green-600"></i>
                            WhatsApp
                        </button>

                    </div>
                </div>

            </div>
        </aside>

        <!-- Main Article Content -->
        <div class="flex-1 min-w-0 xl:max-w-4xl">
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
                    <li>
                        <a href="{{ route('authors') }}" class="hover:lite-text-accent transition-colors duration-300">
                            Yazarlar
                        </a>
                    </li>

                    <li><i class="ri-arrow-right-s-line"></i></li>
                    <li class="lite-text-primary line-clamp-1 w-2/3">{{ $author->name }}</li>
                </ol>
            </nav>

            <section class="mb-12">
                <div
                    class="lite-bg-secondary border lite-border flex flex-col items-center rounded-lg relative p-6 lg:mt-24 mt-28">
                    <div class="border-2 lite-accent-border rounded-lg overflow-hidden absolute -top-20">
                        <img src="{{ route('resizeImage', ['i_url' => $author->avatar, 'w' => 100, 'h' => 100]) }}"
                            alt="{{ $author->name }}" class="w-36 h-36 object-cover">
                    </div>

                    <h3 class="text-xl font-bold lite-text-primary mb-6 flex items-center gap-2 mt-15">

                        {{ $author->name }}
                    </h3>
                    <div class="flex items-center gap-2 mb-6 lg:hidden">
                        <a href="#" target="_blank" class="lite-btn lite-btn-outline  lite-btn-sm"><i
                                class="ri-facebook-fill"></i></a>
                        <a href="#" target="_blank" class="lite-btn lite-btn-outline  lite-btn-sm"><i
                                class="ri-twitter-x-fill"></i></a>
                        <a href="#" target="_blank" class="lite-btn lite-btn-outline  lite-btn-sm"><i
                                class="ri-linkedin-fill"></i></a>
                        <a href="#" target="_blank" class="lite-btn lite-btn-outline  lite-btn-sm"><i
                                class="ri-whatsapp-fill"></i></a>
                    </div>
                    <p class="lite-text-secondary leading-relaxed text-sm mb-3 lgpx-6">
                        {{ $author->about ?? 'Yazar hakkında daha fazla bilgi bulunmamaktadır.' }}
                    </p>
                    <!-- Yazar İstatistikleri -->
                    <div class=" p-6 mb-8">


                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                            <!-- İstatistik Kart -->
                            <div class="flex flex-col items-center justify-center border lite-border  rounded-lg py-4">
                                <i class="ri-article-line text-2xl lite-text-accent mb-2"></i>
                                <p class="text-lg font-bold lite-text-primary">{{ $author->articles->count() }}</p>
                                <span class="text-sm lite-text-secondary">Toplam Yazı</span>
                            </div>

                            <div class="flex flex-col items-center justify-center border lite-border  rounded-lg py-4">
                                <i class="ri-eye-line text-2xl lite-text-accent mb-2"></i>
                                <p class="text-lg font-bold lite-text-primary">00</p>
                                <span class="text-sm lite-text-secondary">Toplam Görüntülenme</span>
                            </div>

                            <div class="flex flex-col items-center justify-center border lite-border  rounded-lg py-4">
                                <i class="ri-message-3-line text-2xl lite-text-accent mb-2"></i>
                                <p class="text-lg font-bold lite-text-primary">00</p>
                                <span class="text-sm lite-text-secondary">Yorum Sayısı</span>
                            </div>

                            <div class="flex flex-col items-center justify-center border lite-border  rounded-lg py-4">
                                <i class="ri-share-forward-line text-2xl lite-text-accent mb-2"></i>
                                <p class="text-lg font-bold lite-text-primary">00</p>
                                <span class="text-sm lite-text-secondary">Paylaşım</span>
                            </div>


                        </div>
                    </div>

                </div>
            </section>


            <!-- Related Articles -->
            <section class="mb-12">
                <h3 class="text-xl font-bold lite-text-primary mb-6 flex items-center gap-2">
                    <i class="ri-article-line lite-text-accent"></i>
                    Yazarın Diğer Makalelerine Göz Atın
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                    @foreach ($author->articles as $article)
                        <article
                            class="lite-bg-secondary border lite-border rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300 group">
                            <a href="{{ route('frontend_article', ['author' => slug_format($author->name), 'slug' => $article->slug]) }}"
                                class="block">

                                <div class="p-4">
                                    <h4
                                        class="font-semibold lite-text-primary mb-2 group-hover:lite-text-accent transition-colors duration-300 line-clamp-2">
                                        {{ $article->title }}
                                    </h4>
                                    {{-- <p class="lite-text-secondary text-sm mb-3 line-clamp-2">
                                {{ $article->detail }}
                            </p> --}}
                                    <div class="flex items-center gap-2 text-xs lite-text-secondary">
                                        <span>{{ $article->created_at->format('d.m.Y') }}</span>

                                    </div>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Right Sidebar - Related Articles -->
        <aside class="w-80 hidden xl:block">
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
                                        <img src="{{ route('resizeImage', ['i_url' => $hit_popup->images, 'w' => 120, 'h' => 80]) }}"
                                            alt="{{ $hit_popup->title }}"
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
                    <a href="category.html"
                        class="flex items-center justify-center gap-2 p-4 border lite-border rounded-lg hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300 group">
                        <i class="ri-newspaper-line"></i>
                        <span class="font-medium">Tüm Makaleler</span>
                        <i
                            class="ri-arrow-right-line group-hover:translate-x-1 transition-transform duration-300"></i>
                    </a>
                </div> --}}

                    <!-- Popular Tags -->
                    <!-- <div class="mt-4">
                        <h5 class="font-semibold lite-text-primary mb-4 flex items-center gap-2">
                            <i class="ri-price-tag-3-line lite-text-accent"></i>
                            Popüler Etiketler
                        </h5>
                        <div class="flex flex-wrap gap-2">
                            <a href="#" class="lite-btn lite-btn-outline  lite-btn-sm">#YapayZeka</a>
                            <a href="#" class="lite-btn lite-btn-outline  lite-btn-sm">#Blockchain</a>
                            <a href="#" class="lite-btn lite-btn-outline  lite-btn-sm">#Tesla</a>
                            <a href="#" class="lite-btn lite-btn-outline  lite-btn-sm">#Metaverse</a>
                            <a href="#" class="lite-btn lite-btn-outline  lite-btn-sm">#Kripto</a>
                            <a href="#" class="lite-btn lite-btn-outline  lite-btn-sm">#5G</a>
                        </div>
                    </div> -->
                </div>
            </div>
        </aside>
    </div>
@endsection
