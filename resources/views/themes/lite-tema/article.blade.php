@extends('themes.' . $theme . '.frontend_layout')

@section('meta')
    <title>{{ $article->title }}</title>
    <meta name="title" content="{{ $article->title }}">
    <meta name="description"
        content="{{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($article->detail)), 160) }}">
    <link rel="canonical" href="{{ url()->current() }}" />
    <meta name="url" content="{{ url()->current() }}">
    <meta name="articleSection" content="columnist">
    <meta property="og:title" content="{{ $article->title }}" />
    <meta property="og:description"
        content="{{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($article->detail)), 160) }}" />
    <meta property="og:image"
        content=" {{ $article->author?->avatar ? config('app.url') . '/' . $article->author->avatar : '' }} " />
    <meta property="og:url"
        content="{{ route('frontend_article', ['author' => slug_format($article->author->name), 'slug' => $article->slug]) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:site_name" content="{{ $settings['title'] }}" />
    <meta property="article:published_time" content="{{ date('Y-m-d', strtotime($article->created_at)) }}" />
    <meta property="article:modified_time" content="{{ date('Y-m-d', strtotime($article->uploaded_at)) }}" />


    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@if (isset($magicbox[' tw_name'])) {{ $magicbox['tw_name'] }} @endif" />
    <meta name="twitter:title" content="{{ $article->title }}" />
    <meta name="twitter:description"
        content="{{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($article->detail)), 160) }}" />
    <meta name="twitter:image" content="{{ $article->author?->avatar ?? '' }}" />

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Article",
        "@id": "#Article",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "#webpage",
            "url": "{{ route('frontend_article', ['author'=>slug_format($article->author?->name),'slug' => $article['slug']]) }}"
        },
        "name": "{{ $article->title }}",
        "description": "{{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($article->detail)), 160) }}",
        "image": "@if($article->author!=null) {{ $article->author->avatar }} @endif",
        "datePublished": "{{ date('Y-m-d', strtotime($article->created_at)) }}",
        "dateModified": "{{ date('Y-m-d', strtotime($article->uploaded_at)) }}",
        "author": "@if($article->author!=null) {{ $article->author?->name }} @endif",
        "publisher": {
            "@type": "Organization",
            "name": "{{ $settings['title'] }}",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ asset('uploads/'.$settings['logo']) }}"
            }
        }
    }
</script>
@endsection

@section('custom_css')
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-5">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Sol Sidebar - Paylaşım Butonları (Desktop) -->
            <aside class="hidden lg:block lg:col-span-1">
                <div class="share-sticky">
                    <div class="flex flex-col gap-3">
                        <a href="https://twitter.com/intent/tweet?text={{ $article->title }}&url={{ route('frontend_article', ['author' => slug_format($article->author->name), 'slug' => $article->slug]) }}"
                            class="w-12 h-12 rounded-full lite-btn lite-btn-secondary  lite-btn-md flex items-center justify-center transition-all"
                            title="Twitter'da Paylaş">
                            <i class="ri-twitter-x-line text-xl"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('frontend_article', ['author' => slug_format($article->author->name), 'slug' => $article->slug]) }}"
                            class="w-12 h-12 rounded-full lite-btn lite-btn-secondary  lite-btn-md flex items-center justify-center transition-all"
                            title="Facebook'ta Paylaş">
                            <i class="ri-facebook-fill text-xl"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ route('frontend_article', ['author' => slug_format($article->author->name), 'slug' => $article->slug]) }}"
                            class="w-12 h-12 rounded-full lite-btn lite-btn-secondary  lite-btn-md flex items-center justify-center transition-all"
                            title="LinkedIn'de Paylaş">
                            <i class="ri-linkedin-fill text-xl"></i>
                        </a>
                        <a href="whatsapp://send?text={{ $article->title }}" data-action="share/whatsapp/share"
                            class="w-12 h-12 rounded-full lite-btn lite-btn-secondary  lite-btn-md flex items-center justify-center transition-all"
                            title="WhatsApp'ta Paylaş">
                            <i class="ri-whatsapp-line text-xl"></i>
                        </a>
                        <button id="liteCopyLinkBtn"
                            class="w-12 h-12 rounded-full lite-btn lite-btn-secondary  lite-btn-md flex items-center justify-center transition-all"
                            title="Linki Kopyala">
                            <i class="ri-link text-xl"></i>
                        </button>
                    </div>
                </div>
            </aside>

            <!-- Ana İçerik -->
            <section class="lg:col-span-7">
                <!-- Breadcrumb -->
                <!-- Breadcrumb -->
                <nav class="mb-8" aria-label="Breadcrumb">
                    <ol class="flex items-center gap-2 text-sm lite-text-secondary">
                        <li>
                            <a href="{{ route('frontend.index') }}"
                                class="hover:lite-text-accent transition-colors duration-300">
                                Ana Sayfa
                            </a>
                        </li>
                        @if ($article->author)
                            <li><i class="ri-arrow-right-s-line"></i></li>
                            <li>
                                <a href="{{ route('author', ['id' => $article->author->id]) }}"
                                    class="hover:lite-text-accent transition-colors duration-300">
                                    {{ $article->author->name }}
                                </a>
                            </li>
                        @endif
                        <li><i class="ri-arrow-right-s-line"></i></li>
                        <li class="lite-text-primary line-clamp-1 w-2/3">{{ html_entity_decode($article->title) }}</li>
                    </ol>
                </nav>



                <!-- Makale Başlığı -->
                <header class="mb-6">
                    <h1 class="text-3xl md:text-5xl font-bold lite-text-primary leading-tight mb-4">
                        {{ html_entity_decode($article->title) }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-4 text-sm lite-text-secondary">
                        <div class="flex items-center gap-2">
                            <i class="ri-calendar-line lite-text-accent"></i>
                            <time datetime="2025-09-13">{{ date('d.m.Y', strtotime($article->created_at)) }}</time>
                        </div>

                        {{-- <div class="flex items-center gap-2">
                        <i class="ri-eye-line lite-text-accent"></i>
                        <span>{{ $article->hit }} okunma</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="ri-chat-3-line lite-text-accent"></i>
                        <span>{{ $article->comments->count() }} yorum</span>
                    </div> --}}
                    </div>
                </header>

                <!-- Yazar Bilgisi -->
                <div class="lite-bg-secondary border lite-border rounded-xl p-5 mb-6 flex items-start gap-4">
                    <img src="{{ route('resizeImage', ['i_url' => $article->author?->avatar ?? 'anonim', 'w' => 100, 'h' => 100]) }}"
                        alt="{{ $article->author?->name ?? '' }}" class="w-16 h-16 rounded-full object-cover">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-semibold text-lg lite-text-primary">{{ $article->author?->name ?? '' }}</h3>

                        </div>
                        <p class="lite-text-secondary text-sm mb-2">
                            {{ $article->author?->about ?? 'Yazar hakkında daha fazla bilgi bulunmamaktadır.' }}</p>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('author', ['id' => $article->author->id]) }}"
                                class="text-sm lite-text-secondary hover:lite-text-accent hover:underline flex items-center gap-1">
                                <i class="ri-article-line"></i>
                                <span>Tüm Yazıları</span>
                            </a>
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
                    </div>
                </div>


                @if (!blank($article->images))
                    <!-- Kapak Görseli -->
                    <figure class="rounded-xl overflow-hidden border lite-border lite-bg-secondary mb-6">
                        <img src="{{ asset('uploads/' . $article->images) }}" alt="Yapay zeka kapak görseli"
                            class="w-full h-[320px] md:h-[480px] object-cover">
                        <figcaption class="px-4 py-3 text-xs lite-text-secondary">
                            Görsel: {{ $article->author?->name ?? '' }}
                        </figcaption>
                    </figure>
                @endif


                <!-- Makale İçeriği -->
                <article class="lite-ckeditor-content max-w-none" id="detailContent">
                    {!! $article->detail !!}
                </article>

                <!-- Etiketler -->
                {{-- <div class="mt-8 pt-8 border-t lite-border">
                <h3 class="text-sm font-semibold lite-text-secondary mb-3">ETİKETLER</h3>
                <div class="flex flex-wrap gap-2">
                    <a href="#" class="lite-btn lite-btn-primary lite-btn-sm">#yapayzeka</a>
                    <a href="#" class="lite-btn lite-btn-primary lite-btn-sm">#teknoloji</a>
                    <a href="#" class="lite-btn lite-btn-primary lite-btn-sm">#2025</a>
                    <a href="#" class="lite-btn lite-btn-primary lite-btn-sm">#AI</a>
                    <a href="#" class="lite-btn lite-btn-primary lite-btn-sm">#dijitaldönüşüm</a>
                </div>
            </div> --}}

                <!-- Comments Section -->
                {{-- <section class="my-12">
                <h3 class="text-xl font-bold lite-text-primary mb-6 flex items-center gap-2">
                    <i class="ri-chat-3-line lite-text-accent"></i>
                    Yorumlar ({{ $comments->count() }})
                </h3>

                <!-- Comment Form -->
                <div class="lite-bg-secondary border lite-border rounded-lg p-6 mb-6">
                    <h4 class="font-semibold lite-text-primary mb-4">Yorum Yap</h4>
                    <form action="{{ route('commentsubmit', ['type' => 0, 'post_id' => $post->id]) }}" method="post"
                        class="space-y-4">
                        @csrf
                        @if (session('captcha_error'))
                            <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                                role="alert">
                                <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="sr-only">Info</span>
                                <div>
                                    {{ session('captcha_error') }}
                                </div>
                            </div>
                        @endif
                        @if (session('success_comment'))
                            <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
                                role="alert">
                                <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                </svg>
                                <span class="sr-only">Info</span>
                                <div>
                                    {{ session('success_comment') }}
                                </div>
                            </div>
                        @endif
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="name" placeholder="Adınız"
                                class="w-full px-4 py-3 border lite-border rounded-lg focus:outline-none focus:ring-2 focus:ring-lite-accent-primary focus:border-transparent lite-bg-primary">
                            <input type="email" name="email" placeholder="E-posta adresiniz"
                                class="w-full px-4 py-3 border lite-border rounded-lg focus:outline-none focus:ring-2 focus:ring-lite-accent-primary focus:border-transparent lite-bg-primary">
                        </div>
                        <textarea name="detail" placeholder="Yorumunuzu yazın..." rows="4"
                            class="w-full px-4 py-3 border lite-border rounded-lg focus:outline-none focus:ring-2 focus:ring-lite-accent-primary focus:border-transparent lite-bg-primary resize-none"></textarea>
                        @if ($magicbox['google_recaptcha_site_key'] != null)
                            <div class="mb-3">
                                <div class="g-recaptcha" data-sitekey="{{ $magicbox['google_recaptcha_site_key'] }}">
                                </div>
                            </div>
                            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                        @endif
                        <button type="submit" class="lite-btn lite-btn-primary lite-btn-md">
                            <i class="ri-send-plane-line"></i>
                            Yorum Gönder
                        </button>
                    </form>
                </div>
                @if (count($comments) > 0)
                    <!-- Comments List -->
                    <div class="space-y-6">

                        @foreach ($comments as $comment)
                            <div class="lite-bg-secondary border lite-border rounded-lg p-6">
                                <div class="flex gap-4">
                                    <img src="{{ asset('backend/assets/icons/avatar.png') }}"
                                        alt="{{ $comment->title }}"
                                        class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h5 class="font-semibold lite-text-primary">{{ $comment->title }}</h5>
                                            <span class="text-xs lite-text-secondary">{{ $comment->email }}</span>
                                            <span
                                                class="text-xs lite-text-secondary">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="lite-text-primary leading-relaxed lg:text-base text-sm mb-3">
                                            {{ $comment->detail }}
                                        </p>

                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if (count($comments) > 3)
                            <!-- Load More Comments -->
                            <div class="text-center">
                                <button class="lite-btn lite-btn-primary lite-btn-md" id="liteCommentLoadMore">
                                    Daha Fazla Yorum Yükle
                                </button>
                            </div>
                        @endif
                    </div>
                @endif
            </section> --}}
            </section>

            <section class="lg:col-span-4 relative">
                <!-- Right Sidebar - Related Articles -->

                <div class="sticky top-24">
                    <!-- Related Articles -->
                    <div class="lite-bg-secondary border lite-border rounded-lg p-6">
                        <h4 class="font-semibold lite-text-primary mb-6 flex items-center gap-2">
                            <i class="ri-newspaper-line lite-text-accent"></i>
                            Diğer Yazıları
                        </h4>
                        <div class="space-y-5">
                            @foreach ($other_articles->sortByDesc('created_at') as $key => $article)
                                <article class="group cursor-pointer lite-detail-interesting-news">
                                    <a href="{{ route('frontend_article', ['author' => slug_format($article->author->name), 'slug' => $article->slug]) }}"
                                        class="flex gap-4 p-3 rounded-lg hover:lite-bg-accent  hover:bg-opacity-5 transition-all duration-300">
                                        {{-- <img src="{{ asset('uploads/' . $article->images) }}" alt="{{ $article->title }}"
                                    class="w-20 h-14 object-cover rounded flex-shrink-0 group-hover:scale-105 transition-transform duration-300"> --}}
                                        <div class="flex-1 min-w-0">
                                            <h5
                                                class="lite-text-primary text-sm font-semibold leading-snug line-clamp-3 transition-colors duration-300 mb-2">
                                                {{ $article->title }}
                                            </h5>
                                            <div class="flex items-center gap-2 text-xs lite-text-secondary">
                                                <p class="flex items-center gap-2 text-xs lite-text-secondary">
                                                    <i class="ri-user-line"></i>
                                                    <span>{{ $article->author?->name ?? '' }}</span>

                                                </p>
                                                <p class="flex items-center gap-2 text-xs lite-text-secondary">
                                                    <i class="ri-time-line"></i>
                                                    <span>{{ $article->created_at->diffForHumans() }}</span>

                                                </p>

                                            </div>

                                        </div>
                                    </a>
                                </article>

                                @if ($key == 3)
                                    @break
                                @endif
                            @endforeach



                        </div>

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


                    </div>
                </div>

            </section>

        </div>
    </div>
    <!-- ToolBox Button -->
    <button id="liteToolBox"
        class="fixed bottom-16 right-4 w-12 h-12 lg:hidden block lite-bg-accent text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 z-50">
        <i class="ri-tools-line"></i>
    </button>

    <div class="fixed bottom-[12%] right-4 z-[1002] w-64 hidden transition-all duration-300" id="liteToolBoxContainer">
        <!-- Article Tools -->
        <div class="lite-bg-secondary border lite-border rounded-lg p-6 mb-6 shadow-2xl transition-all duration-300">
            <h4 class="font-semibold lite-text-primary mb-4 flex items-center gap-2">
                <i class="ri-tools-line lite-text-accent"></i>
                Makale Araçları
            </h4>
            <div class="space-y-4">
                <!-- Share Tool -->
                <div class="flex items-center justify-between p-3 border lite-border rounded-lg hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300 cursor-pointer group"
                    id="liteSidebarShare">
                    <div class="flex items-center gap-3">
                        <i class="ri-share-line text-lg"></i>
                        <span class="font-medium">Paylaş</span>
                    </div>
                    <i class="ri-arrow-right-s-line group-hover:translate-x-1 transition-transform duration-300"></i>
                </div>

                <!-- Save Tool -->
                <div class="flex items-center justify-between p-3 border lite-border rounded-lg hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300 cursor-pointer group"
                    id="liteSidebarSave">
                    <div class="flex items-center gap-3">
                        <i class="ri-volume-up-line text-lg"></i>
                        <span class="font-medium">Sesli Oku</span>
                    </div>
                    <i class="ri-arrow-right-s-line group-hover:translate-x-1 transition-transform duration-300"></i>
                </div>
                <!-- Save Tool
                                                                              <div class="flex items-center justify-between p-3 border lite-border rounded-lg hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300 cursor-pointer group"
                                                                                  id="liteSidebarSave">
                                                                                  <div class="flex items-center gap-3">
                                                                                      <i class="ri-bookmark-line text-lg" id="liteSidebarSaveIcon"></i>
                                                                                      <span class="font-medium">Kaydet</span>
                                                                                  </div>
                                                                                  <i
                                                                                      class="ri-arrow-right-s-line group-hover:translate-x-1 transition-transform duration-300"></i>
                                                                              </div> -->

                <!-- Font Size Tool -->
                <div class="p-3 border lite-border rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <i class="ri-font-size lite-text-accent text-lg"></i>
                            <span class="font-medium lite-text-primary">Yazı Boyutu</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-3">
                        <button id="liteSidebarFontDecrease"
                            class="w-8 h-8 lite-bg-accent text-white rounded-full hover:bg-red-600 transition-colors duration-300 flex items-center justify-center"
                            title="Küçült">
                            <i class="ri-subtract-line text-sm"></i>
                        </button>
                        <span class="lite-text-secondary text-sm font-medium px-3">A</span>
                        <button id="liteSidebarFontIncrease"
                            class="w-8 h-8 lite-bg-accent text-white rounded-full hover:bg-red-600 transition-colors duration-300 flex items-center justify-center"
                            title="Büyüt">
                            <i class="ri-add-line text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Share Modal -->
    {{-- <div id="liteShareModal" class="fixed inset-0 bg-black bg-opacity-50 z-[1005] hidden items-center justify-center p-4">
  <div class="lite-bg-secondary rounded-lg max-w-md w-full p-6">
      <div class="flex items-center justify-between mb-6">
          <h3 class="text-lg font-semibold lite-text-primary">Makaleyi Paylaş</h3>
          <button id="liteShareModalClose" class="lite-hover-accent p-2 rounded-lg">
              <i class="ri-close-line"></i>
          </button>
      </div>
      <div class="space-y-3">

          <a href="https://www.facebook.com/sharer/sharer.php?u=@if ($post->category != null) {{ route('post', ['categoryslug' => $post->category->slug, 'slug' => $post->slug, 'id' => $post->id]) }} @endif"
              target="_blank" title="{{ html_entity_decode($post->title) }}"
              class="w-full flex items-center gap-3 p-3 rounded-lg border lite-border hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300">
              <i class="ri-facebook-fill text-blue-600"></i>
              Facebook'ta Paylaş
          </a>
          <a href="https://twitter.com/intent/tweet?text={{ html_entity_decode($post->title) }}&url=@if ($post->category != null) {{ route('post', ['categoryslug' => $post->category->slug, 'slug' => $post->slug, 'id' => $post->id]) }} @endif"
              target="_blank" title="{{ html_entity_decode($post->title) }}"
              class="w-full flex items-center gap-3 p-3 rounded-lg border lite-border hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300">
              <i class="ri-twitter-x-fill"></i>
              X'te Paylaş
          </a>
          <a href="https://www.linkedin.com/shareArticle?mini=true&url=@if ($post->category != null) {{ route('post', ['categoryslug' => $post->category->slug, 'slug' => $post->slug, 'id' => $post->id]) }} @endif"
              target="_blank" title="{{ html_entity_decode($post->title) }}"
              class="w-full flex items-center gap-3 p-3 rounded-lg border lite-border hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300">
              <i class="ri-linkedin-fill text-blue-700"></i>
              LinkedIn'de Paylaş
          </a>
          <a href="https://wa.me/?text={{ html_entity_decode($post->title) }}@if ($post->category != null) {{ route('post', ['categoryslug' => $post->category->slug, 'slug' => $post->slug, 'id' => $post->id]) }} @endif"
              target="_blank" title="{{ html_entity_decode($post->title) }}"
              class="w-full flex items-center gap-3 p-3 rounded-lg border lite-border hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300">
              <i class="ri-whatsapp-fill text-green-600"></i>
              WhatsApp'ta Paylaş
          </a>
          <button id="liteModalCopyLink"
              class="w-full flex items-center gap-3 p-3 rounded-lg border lite-border hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300">
              <i class="ri-link"></i>
              Linki Kopyala
          </button>
      </div>
  </div>
</div> --}}

    {{-- @if (count($comments) > 0)
  <!-- Comment Modal -->
  <div id="liteCommentModal"
      class="fixed inset-0 bg-black bg-opacity-50 z-[1005] hidden items-center justify-center p-4">
      <div class="lite-bg-secondary rounded-lg  lg:w-1/2 w-full p-6">
          <div class="flex items-center justify-between mb-6">

              <div class="flex flex-col gap-2">
                  <h3 class="text-xl font-bold lite-text-primary  flex items-center gap-2">

                      <i class="ri-chat-3-line lite-text-accent"></i>
                      Tüm Yorumlar ({{ $comments->count() }})

                  </h3>
                  <div class="w-16 h-1 lite-bg-accent rounded-full"></div>
              </div>


              <button id="liteCommentModalClose" class="lite-hover-accent p-2 rounded-lg">
                  <i class="ri-close-line"></i>
              </button>
          </div>
          <div class="space-y-3 overflow-y-auto max-h-[60vh]">
              @foreach ($comments as $comment)
                  <div class="lite-bg-secondary border lite-border rounded-lg p-6">
                      <div class="flex gap-4">
                          <img src="{{ asset('backend/assets/icons/avatar.png') }}" alt="{{ $comment->title }}"
                              class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                          <div class="flex-1">
                              <div class="flex items-center gap-3 mb-2">
                                  <h5 class="font-semibold lite-text-primary">{{ $comment->title }}</h5>
                                  <span class="text-xs lite-text-secondary">{{ $comment->email }}</span>
                                  <span
                                      class="text-xs lite-text-secondary">{{ $comment->created_at->diffForHumans() }}</span>
                              </div>
                              <p class="lite-text-primary leading-relaxed mb-3">
                                  {{ $comment->detail }}
                              </p>

                          </div>
                      </div>
                  </div>
              @endforeach

          </div>
      </div>
  </div>
@endif --}}
@endsection
