@extends('themes.' . $theme . '.frontend_layout')

@section('meta')
    <title>{{ $post->title }}</title>
    <meta name="title" content="{{ $post->title }}">
    <meta name="description" content="{{ $post->description }}">
    <meta name="keywords" content="{{ $post->keywords }}">

    <link rel="canonical"
        href="{{ route('post', ['categoryslug' => $post->category->slug, 'slug' => $post->slug, 'id' => $post->id]) }}" />

    <meta property="og:title" content="{{ $post->title }}" />
    <meta property="og:description" content="{{ $post->description }}" />
    <meta property="og:image" content="{{ $post->images }}" />
    <meta property="og:url"
        content="@if ($post->category != null) {{ route('post', ['categoryslug' => $post->category->slug, 'slug' => $post->slug, 'id' => $post->id]) }} @endif" />
    <meta property="og:type" content="news" />
    <meta property="og:image:width" content="777">
    <meta property="og:image:height"  content="510">
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@if (isset($magicbox['tw_name'])) {{ $magicbox['tw_name'] }} @endif" />
    <meta name="twitter:title" content="{{ $post->title }}" />
    <meta name="twitter:description" content="{{ $post->description }}" />
    <meta name="twitter:image" content="{{ $post->images }}" />

    <meta name="datePublished" content="{{ $post->created_at->format('Y-m-d\TH:i:sP') }}">
    <meta name="dateModified" content="{{ $post->updated_at->format('Y-m-d\TH:i:sP') }}">
    <meta name="url" content="{{ url()->current() }}">

    <meta name="articleSection" content="news">
    <meta name="articleAuthor" content="{{ $post->author?->name ?? 'Admin' }}">


    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "NewsArticle",
          "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "@if($post->category != null) {{ route('post', ['categoryslug' => $post->category->slug, 'slug' => $post->slug, 'id' => $post->id]) }} @endif"
          },
          "headline": "{{ $post->meta_title }}",
          "description": "{{ $post->meta_description }}",
          "image": "{{ $post->images }}",
          "author": {
            "@type": "Organization",
            "name": "@if(isset($extra->author)) {{ $extra->author }} @else Yazar @endif"
          },
          "publisher": {
            "@type": "Organization",
            "name": "{{ $settings['title'] }}",
            "logo": {
              "@type": "ImageObject",
              "url": "{{ imageCheck($settings['logo']) }}"
            }
          },
          "datePublished": "{{ date('Y-m-d', strtotime($post->created_at)) }}",
          "dateModified": "{{ date('Y-m-d', strtotime($post->created_at)) }}"
        }
        </script>

    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "BreadcrumbList",
          "itemListElement": [{
            "@type": "ListItem",
            "position": 1,
            "name": "{{ $post->category->title }}",
            "item": "{{ route('category', ['slug' => $post->category->slug, 'id' => $post->category->id]) }}"
          },{
            "@type": "ListItem",
            "position": 2,
            "name": "{{ html_entity_decode($post->title) }}",
            "item": "@if($post->category != null) {{ route('post', ['categoryslug' => $post->category->slug, 'slug' => $post->slug, 'id' => $post->id]) }} @endif"
          }]
        }
        </script>
@endsection

@section('content')
    <div class="flex gap-8 relative px-5">
        <!-- Left Sidebar -->
        <aside class="w-64 hidden xl:block">
            <!-- Fixed Navigation Tools -->
            <div class="sticky top-24">
                <!-- Article Tools -->
                <div class="lite-bg-secondary border lite-border rounded-lg p-6 mb-6">
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
                            <i
                                class="ri-arrow-right-s-line group-hover:translate-x-1 transition-transform duration-300"></i>
                        </div>

                        <!-- Save Tool -->
                        <div class="flex items-center justify-between p-3 border lite-border rounded-lg hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300 cursor-pointer group"
                            id="liteSidebarSave">
                            <div class="flex items-center gap-3">
                                <i class="ri-volume-up-line text-lg"></i>
                                <span class="font-medium">Sesli Oku</span>
                            </div>
                            <i
                                class="ri-arrow-right-s-line group-hover:translate-x-1 transition-transform duration-300"></i>
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
                                    class="lite-btn lite-btn-outline lite-btn-sm w-9 rounded-full hover:lite-accent-primary transition-colors duration-300 flex items-center justify-center"
                                    title="Küçült">
                                    <i class="ri-subtract-line text-sm"></i>
                                </button>
                                <span class="lite-text-secondary text-sm font-medium px-3">A</span>
                                <button id="liteSidebarFontIncrease"
                                    class="lite-btn lite-btn-outline lite-btn-sm w-9 rounded-full hover:lite-accent-primary transition-colors duration-300 flex items-center justify-center"
                                    title="Büyüt">
                                    <i class="ri-add-line text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('fastcommentsubmit', ['type' => 'post', 'post_id' => $post->id]) }}" method="post"
                    class="lite-bg-secondary border lite-border rounded-lg p-6 mb-6">
                    @csrf

                    <div class="">
                        <div class="mb-4">
                            <input type="text" name="email" placeholder="Email"
                                class="w-full px-2 py-2 text-xs rounded-lg border-2 lite-border lite-bg-primary lite-text-primary outline-none transition-all duration-300 focus:lite-accent-border" />

                        </div>
                        <div class="mb-3">
                            <textarea rows="3" name="detail" placeholder="Yorumunuzu yazınız..."
                                class="w-full px-3 py-2 text-xs rounded-lg border-2 lite-border lite-bg-primary lite-text-primary outline-none transition-all duration-300 focus:lite-accent-border focus:ring-1 focus:ring-lite-accent placeholder-lite-text-secondary resize-none">{{ old('detail') }}</textarea>



                        </div>
                        @if (session('fast_success_comment'))
                            <div class="text-center mt-0">
                                <button
                                    class="lite-btn lite-btn-primary lite-btn-sm bg-green-500 border-none text-white w-full"><i
                                        class="ri-check-line"></i> {{ session('success_comment') }}</button>
                            </div>
                        @elseif(session('fast_error_comment'))
                            <div class="text-center mt-0">
                                <button
                                    class="lite-btn lite-btn-primary lite-btn-sm bg-red-500 border-none text-white w-full"><i
                                        class="ri-close-line"></i> {{ session('error_comment') }}</button>
                            </div>
                        @else
                            <div class="text-center mt-0">
                                <button class="lite-btn lite-btn-primary lite-btn-sm w-full">Yorum Yap</button>
                            </div>
                        @endif

                    </div>
                </form>

            </div>
        </aside>

        <!-- Main Article Content -->
        <div class="flex-1 min-w-0 xl:max-w-4xl" id="infiniteBox">

            <div class="infiniteContent">
                <!-- Breadcrumb -->
                <nav class="mb-8" aria-label="Breadcrumb">
                    <ol class="flex items-center gap-2 text-sm lite-text-secondary">
                        <li>
                            <a href="{{ route('frontend.index') }}"
                                class="hover:lite-text-accent transition-colors duration-300">
                                Ana Sayfa
                            </a>
                        </li>
                        @if ($post->category)
                            <li><i class="ri-arrow-right-s-line"></i></li>
                            <li>
                                <a href="{{ route('category', ['slug' => $post->category->slug]) }}"
                                    class="hover:lite-text-accent transition-colors duration-300">
                                    {{ $post->category->title }}
                                </a>
                            </li>
                        @endif
                        <li><i class="ri-arrow-right-s-line"></i></li>
                        <li class="lite-text-primary line-clamp-1 w-2/3">{{ html_entity_decode($post->title) }}</li>
                    </ol>
                </nav>

                <!-- Article Header -->
                <header class="mb-8">
                    <!-- Category Badge -->
                    <div class="mb-4 flex items-center justify-between">
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1 lite-bg-accent text-white rounded-full text-sm font-medium">
                            <i class="ri-cpu-line"></i>
                            {{ $post->category->title }}
                        </span>
                        <!-- Article Meta -->
                        <div class="flex flex-wrap items-center gap-4 text-sm lite-text-secondary lg:flex hidden">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset($post->author?->avatar ?? '') }}"
                                    alt="{{ $post->author?->name ?? 'Admin' }}"
                                    onerror="this.onerror=null;this.src='/backend/assets/icons/avatar.png'"
                                    class="w-8 h-8 rounded-full object-cover">
                                <span class="font-medium">{{ $post->author?->name ?? 'Admin' }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <i class="ri-calendar-line"></i>
                                <span>{{ date('d M Y', strtotime($post->created_at)) }}</span>
                            </div>
                            <!-- <div class="flex items-center gap-1">
                                                                                                <i class="ri-time-line"></i>
                                                                                                <span id="liteReadingTime">8 dk okuma</span>
                                                                                            </div> -->
                            <div class="flex items-center gap-1">
                                <i class="ri-eye-line"></i>
                                <span>{{ $post->hit }} görüntülenme</span>
                            </div>
                        </div>
                        <div class="flex items-center lg:gap-2 gap-1">
                            @if ($magicbox['googlenews'] != null)
                                <a href="{{ $magicbox['googlenews'] }}" target="_blank"
                                    class="lite-btn lite-btn-outline  lite-btn-sm">
                                    <img width="16"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAGEUlEQVR4nO2ZWVBTdxjF4/Sh7XSmfem005dCkEVkX5SCC0oIhFUQIkVAlCWAaBUUdbBO63Sm9kFFu1vEBVAqSm2jog5Uq1hb7DBVMCwhWCVC2LF2tJJ7//d0bmLIwgUSxDYz5cyctzz8zpdvubnh8WY0oxn9P+RbtzPMu26n0ufaTnhf/RBeVz6A1+Ud8Lz0Pjxqt8O9phBuF7fB9cJWuFZvgcu5Asw9swnO0nzM+T4Pc05vhFPVBjieWg+HynWwP5GL2RVrMft4NuzKs8Avk2hsWypR2pRKRNMewGJ46SbMqdoAh7IcOJTnwOnke5PC80dDZHZOewCz4c9uhnPVRjiW5yDwWAb2XkhGa0MCBhrjsa0mbVJ4/lNPe4BJ4dmqf7cRvhU5KKxeg/r6JKibV4BqFoOSxUEti8VfjTHwrsyeFJ7/PAKMB+9SvQVup/Ow+kwWqupS8VC2ElTLu6BM4NW3Y6C+HY3CCymTwvOfSwATeLZd4s6vx5Gr6ehtSgHdmgSqJXFCeHVTFBQ10RDtSobdoXTwSzP/vQA6eGFtAXbX5UDRmAa6bRXo1mSz4UeaIjByKxyd8ZG4Gx6LypQ45OWvwPzdybA5kArbkjTYHsnQeFrh0SF5bfsv+bj+ezYo+RrQbaunBt8YjpFGEfo+FuGBYBkeLI3G8JIoDAdGojEsEsWpMUgrEMOpKOnZAwDiF6iOzGAil5TS8vRHRJ4OehrgR26F4FGtEA+C9PBDi8MxtCgMQwtEGAwIRffCUAz6CWv65wVt7fdb6gMeb5b54O1rXUh7zid0u6SXtEtA2jMwnfAjt4R4clOAP1dHcMIP+odg8B0hBuYLMDAvCP2+S9HvHdjT7xVY2e+xUNLns+itsdDy9a+iI3c7UaxtYxQ5IIosNDTsR7Z0AOIqovUpgnjWJ7WOqySIO0GwnPW3BMsrCGJZH9c65hhBTDnBMtZlWkeXEkQf1TrqyFMfJog8pHVECUHEQa3Di7VOLurBpejN6PNchD6PhehxC6B7Xfyv97r4B4wGIB25PzIdudDBs5XPkg7+5/Dh3xCEHSBI3qPSwPe6L0CvawB6XfzR4+x3zzDAQ0N4uj3TauDDWH9NjOHn+qHHeX6fPoAiW6qDZ3uelmdYFbyIDWAMD5WTb+VoALpdIjYcWEqeZlXwoq+ICfw89Dj6ZOiH+I/Ul2h5xrBu21Bta6wKPvRLYgSvcvRFl53P20abiMjTinWrkmpLtSr4UDaAAbzK3qd5zCpVt6Ut1u15qjVlQvgdtQQ/32Mw/DdAGGDoMXDtLoPCi9zw5kqmAid86BdED+/gg+7ZXkUcl5c3i2pbdYc9UlRrMid8/AmCGgUzIUR1K4NlpcaVt0QiDvgQNoAO3t4b3XaeYZxXmGpN+oi9sOqWlZyVnwyeVcVNZkzbmKumbnDCh3xO9PB8zyeqN91f4X6MkCU6qJsTGXVLImfbGOpXJYP8cwQrKgjyzhHcUDKc8FPt+VAD+JDPiK7y6LJ1r+GEH/0WmhPq1c0JYwb2eqe++vVK5rkObKgJvJANwMLzPXDf1q1gwgDqZvE69qeg6bZhB1YntvLmwkcetGwGWN3uhhG88FOige+ydYeS7+o+YQC0Jr4+IotTm65K2qD9Eyr08MuOcgPSBJqqTyUAK0P44P1EA3/f1l1l1qP1iGz5D6Z7nl2VOuWd1Vc+epw1OfBIGyCi2PIATV0wgtcF6LJxO8ozR49lsWLTI8XueZ3YgeVqm9+U+s9cVjDP1PNCA/jgfaMBVpoVoLNT/LLphWWPlKHYEPlnCcRlBHlSghsGQ85qs3T64AX7CNs+RGXn/oZZAXjALK7Hg/Ntk98BVlIZYwRvyfAKOeAFRZoADebBPw3A9WwTW0Y0l3Yy+KgS48pbomAOeG0At12WBZhgz2+rJrhyh9EMKkW0A/uTghm3bcxVYxc44VkrbTyWWBzg3zpSwnHaxtBye/sXLQpgTfCCImLheyI2gBXBC6YawFrgBVMJYE3wgikHsBJ4gcUBeDxe1GFaaS3wQXtp/UsscxVZQoVFlNCd1gAv2ENN/59+M5rRjHhWoX8AqnSHZxuGwwsAAAAASUVORK5CYII="
                                        alt="google-news">
                                    Google News
                                </a>
                            @endif
                            <a href="https://www.facebook.com/sharer/sharer.php?u=@if ($post->category != null) {{ route('post', ['categoryslug' => $post->category->slug, 'slug' => $post->slug, 'id' => $post->id]) }} @endif"
                                target="_blank" class="lite-btn lite-btn-outline  lite-btn-sm"
                                title="{{ html_entity_decode($post->title) }}">
                                <i class="ri-facebook-fill"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ html_entity_decode($post->title) }}&url=@if ($post->category != null) {{ route('post', ['categoryslug' => $post->category->slug, 'slug' => $post->slug, 'id' => $post->id]) }} @endif"
                                target="_blank" class="lite-btn lite-btn-outline  lite-btn-sm"
                                title="{{ html_entity_decode($post->title) }}">
                                <i class="ri-twitter-x-fill"></i>
                            </a>
                            <a href="https://wa.me?text={{ html_entity_decode($post->title) }}@if ($post->category != null) {{ route('post', ['categoryslug' => $post->category->slug, 'slug' => $post->slug, 'id' => $post->id]) }} @endif"
                                target="_blank" class="lite-btn lite-btn-outline  lite-btn-sm"
                                title="{{ html_entity_decode($post->title) }}">
                                <i class="ri-whatsapp-fill"></i>
                            </a>

                        </div>
                    </div>

                    <!-- Article Title -->
                    <h1 id="liteArticleTitle" class="text-3xl lg:text-4xl font-bold lite-text-primary mb-4 leading-tight">
                        {{ html_entity_decode($post->title) }}
                    </h1>



                    <!-- Article Meta -->
                    <div class="flex-wrap items-center gap-4 text-sm lite-text-secondary mb-6 flex lg:hidden">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset($post->author?->avatar ?? '') }}"
                                alt="{{ $post->author?->name ?? 'Admin' }}"
                                onerror="this.onerror=null;this.src='/backend/assets/icons/avatar.png'"
                                class="w-8 h-8 rounded-full object-cover">
                            <span class="font-medium">{{ $post->author?->name ?? 'Admin' }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <i class="ri-calendar-line"></i>
                            <span>{{ date('d M Y', strtotime($post->created_at)) }}</span>
                        </div>
                        <!-- <div class="flex items-center gap-1">
                                                                                                <i class="ri-time-line"></i>
                                                                                                <span id="liteReadingTime">8 dk okuma</span>
                                                                                            </div> -->
                        <div class="flex items-center gap-1">
                            <i class="ri-eye-line"></i>
                            <span>{{ $post->hit }} görüntülenme</span>
                        </div>
                    </div>

                    <!-- Social Proof -->
                    <!-- <div class="flex items-center gap-4 mb-6">
                                                                                            <div class="flex items-center gap-2 text-sm lite-text-secondary">
                                                                                                <div class="flex -space-x-2">
                                                                                                    <img src="assets/haber-gorsel.png" alt="Reader"
                                                                                                        class="w-6 h-6 rounded-full border-2 border-white object-cover">
                                                                                                    <img src="assets/haber-gorsel.png" alt="Reader"
                                                                                                        class="w-6 h-6 rounded-full border-2 border-white object-cover">
                                                                                                    <img src="assets/haber-gorsel.png" alt="Reader"
                                                                                                        class="w-6 h-6 rounded-full border-2 border-white object-cover">
                                                                                                    <div
                                                                                                        class="w-6 h-6 rounded-full border-2 border-white lite-bg-accent flex items-center justify-center text-xs text-white font-medium">
                                                                                                        +
                                                                                                    </div>
                                                                                                </div>
                                                                                                <span>156 kişi okudu</span>
                                                                                            </div>
                                                                                        </div> -->
                </header>


                <!-- Article Image -->
                <figure class="mb-8 group">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl image-container">
                        <!-- Image Actions Overlay -->
                        <div class="absolute top-4 right-4 z-20 flex space-x-2 image-actions">
                            <button
                                class="expand-btn glass-effect hover:bg-white/20 p-3 rounded-xl transition-all duration-300 group/btn"
                                data-image="{{ asset($post->images) }}"
                                data-title="{{ html_entity_decode($post->title) }}"
                                data-description="{{ $post->description }}"
                                data-author="{{ $post->author?->name ?? 'Admin' }}"
                                data-date="{{ date('d M Y', strtotime($post->created_at)) }}">
                                <i class="ri-search-line text-white group-hover/btn:scale-110 transition-transform"></i>
                            </button>
                            <button
                                class="share-btn glass-effect hover:bg-white/20 p-3 rounded-xl transition-all duration-300 group/btn">
                                <i class="ri-share-line text-white group-hover/btn:scale-110 transition-transform"></i>
                            </button>
                            <!-- <button
                                                                                                    class="bookmark-btn glass-effect hover:bg-white/20 p-3 rounded-xl transition-all duration-300 group/btn">
                                                                                                    <i
                                                                                                        class="ri-bookmark-line text-white group-hover/btn:scale-110 transition-transform bookmark-icon"></i>
                                                                                                </button> -->
                        </div>

                        <!-- Image with Loading Effect -->
                        <div class="relative aspect-video md:aspect-[16/10] overflow-hidden">
                            <div class="image-skeleton absolute inset-0"></div>
                            <img src="{{ asset($post->images) }}" alt="{{ html_entity_decode($post->title) }}"
                                class="article-image w-full h-full object-cover transition-all duration-700 hover:scale-110 cursor-pointer opacity-0"
                                loading="lazy">
                            <div class="absolute inset-0 image-overlay-gradient"></div>
                        </div>

                        <!-- Image Info Badge -->
                        {{-- <div class="absolute bottom-4 left-4 z-20 image-actions">
                        <div class="glass-effect text-white px-4 py-2 rounded-xl">
                            <div class="flex items-center space-x-2 text-sm">
                                <i class="ri-camera-line mt-0.5"></i>
                                <span>High Resolution</span>
                                <span class="text-gray-300">•</span>
                                <span>1200×800</span>
                            </div>
                        </div>
                    </div> --}}


                    </div>

                    <!-- Enhanced Caption -->
                    <figcaption class="mt-6 space-y-3">
                        <p class="text-sm lite-text-secondary italic text-center leading-relaxed">
                            {{ html_entity_decode($post->description) }}
                        </p>


                    </figcaption>
                </figure>




                <!-- Article Content -->
                <article id="liteArticleContent" property="articleBody" class="lite-ckeditor-content max-w-none">
                    {!! $post->detail !!}
                </article>

                @if (!blank($post->keywords))
                    <!-- Article Tags -->
                    <div class="mb-8">
                        <h4 class="font-semibold lite-text-primary mb-4">Etiketler</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach (explode(',', $post->keywords) as $k_item)
                                <a href="{{ route('search.get', ['search' => trim($k_item)]) }}"
                                    class="lite-btn lite-btn-primary lite-btn-sm">
                                    #{{ trim($k_item) }}
                                </a>
                            @endforeach

                        </div>
                    </div>
                @endif

                <!-- Author Bio -->
                <div class="lite-bg-secondary border lite-border rounded-lg p-6 mb-8">
                    <h4 class="font-semibold lite-text-primary mb-4 flex items-center gap-2">
                        <i class="ri-user-line lite-text-accent"></i>
                        Yazar Hakkında
                    </h4>
                    <div class="flex gap-4">
                        <img src="{{ asset($post->author?->avatar ?? '') }}" alt="{{ $post->author?->name ?? 'Admin' }}"
                            onerror="this.onerror=null;this.src='/backend/assets/icons/avatar.png'"
                            class="w-16 h-16 rounded-full object-cover flex-shrink-0">
                        <div>
                            <h5 class="font-semibold lite-text-primary mb-2">{{ $post->author?->name ?? 'Admin' }}</h5>
                            <p class="text-sm lite-text-secondary mb-3">@lang('auth.editor')</p>
                            <p class="lite-text-primary text-sm leading-relaxed mb-4">
                                {{ $post->author?->description ?? 'Yazar hakkında daha fazla bilgi bulunmamaktadır.' }}
                            </p>
                            <div class="flex gap-1">
                                <a href="#" class="lite-social-icon px-1">
                                    <i class="ri-twitter-line"></i>
                                </a>
                                <a href="#" class="lite-social-icon px-1">
                                    <i class="ri-linkedin-line"></i>
                                </a>
                                <a href="mailto:{{ $post->author?->email ?? '' }}" class="lite-social-icon px-1">
                                    <i class="ri-mail-line"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Share -->
                <div class="lite-bg-secondary border lite-border rounded-lg p-6 mb-8">
                    <h4 class="font-semibold lite-text-primary mb-4 flex items-center gap-2">
                        <i class="ri-share-line lite-text-accent"></i>
                        Bu Makaleyi Paylaş
                    </h4>
                    <div class="flex flex-wrap gap-3">
                        <a target="_blank"
                            href="https://www.facebook.com/sharer/sharer.php?u=@if ($post->category != null) {{ route('post', ['categoryslug' => $post->category->slug, 'slug' => $post->slug, 'id' => $post->id]) }} @endif"
                            title="{{ html_entity_decode($post->title) }}"
                            class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                            <i class="ri-facebook-fill"></i>
                            Facebook
                        </a>
                        <a target="_blank"
                            href="https://twitter.com/intent/tweet?text={{ html_entity_decode($post->title) }}&url=@if ($post->category != null) {{ route('post', ['categoryslug' => $post->category->slug, 'slug' => $post->slug, 'id' => $post->id]) }} @endif"
                            title="{{ html_entity_decode($post->title) }}"
                            class="flex items-center gap-2 px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors duration-300">

                            <i class="ri-twitter-x-fill"></i>
                            X (Twitter)
                        </a>
                        <a target="_blank"
                            href="https://www.linkedin.com/shareArticle?mini=true&url=@if ($post->category != null) {{ route('post', ['categoryslug' => $post->category->slug, 'slug' => $post->slug, 'id' => $post->id]) }} @endif"
                            title="{{ html_entity_decode($post->title) }}"
                            class="flex items-center gap-2 px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition-colors duration-300">
                            <i class="ri-linkedin-fill"></i>
                            LinkedIn
                        </a>
                        <a target="_blank"
                            href="https://wa.me/?text={{ html_entity_decode($post->title) }}@if ($post->category != null) {{ route('post', ['categoryslug' => $post->category->slug, 'slug' => $post->slug, 'id' => $post->id]) }} @endif"
                            title="{{ html_entity_decode($post->title) }}"
                            class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-300">
                            <i class="ri-whatsapp-fill"></i>
                            WhatsApp
                        </a>
                        <button id="liteCopyLinkBtn"
                            class="flex items-center gap-2 px-4 py-2 border lite-border rounded-lg hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300">
                            <i class="ri-link"></i>
                            Linki Kopyala
                        </button>
                    </div>
                </div>

                <!-- Comments Section -->
                <section class="mb-12">
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
                </section>
            </div>


            <!-- Related Articles -->
            {{-- <section class="mb-12">
                <h3 class="text-xl font-bold lite-text-primary mb-6 flex items-center gap-2">
                    <i class="ri-article-line lite-text-accent"></i>
                    İlgili Makaleler
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($hit_news->take(6) as $news)
                        <article
                            class="lite-bg-secondary border lite-border rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300 group">
                            <a href="{{ route('post', ['categoryslug' => $news->category->slug, 'slug' => $news->slug, 'id' => $news->id]) }}"
                                class="block">
                                <img src="{{ asset($news->images) }}" alt="{{ $news->title }}"
                                    class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="p-4">
                                    <h4
                                        class="font-semibold lite-text-primary mb-2 group-hover:lite-text-accent transition-colors duration-300 line-clamp-2">
                                        {{ $news->title }}
                                    </h4>
                                    <p class="lite-text-secondary text-sm mb-3 line-clamp-2">
                                        {{ $news->description }}
                                    </p>
                                    <div class="flex items-center gap-2 text-xs lite-text-secondary">
                                        <span>{{ \Carbon\Carbon::parse($news->created_at)->translatedFormat('d F Y') }}</span>

                                    </div>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </section> --}}

            @if ($infiniteurl != null)
                <a href="{{ route('post', ['categoryslug' => $infiniteurl->category->slug, 'slug' => $infiniteurl->slug, 'id' => $infiniteurl->id]) }}"
                    id="gopostinfinite"></a>
            @endif
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
                    <div class="space-y-5">
                        @foreach ($hit_news->slice(6)->take(3) as $news)
                            <article class="group cursor-pointer lite-detail-interesting-news">
                                <a href="{{ route('post', ['categoryslug' => $news->category->slug, 'slug' => $news->slug, 'id' => $news->id]) }}"
                                    class="flex gap-4 p-3 rounded-lg hover:lite-bg-accent  hover:bg-opacity-5 transition-all duration-300">
                                    <img src="{{ asset($news->images) }}" alt="{{ $news->title }}"
                                        class="w-20 h-14 object-cover rounded flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                                    <div class="flex-1 min-w-0">
                                        <h5
                                            class="lite-text-primary text-sm font-semibold leading-snug line-clamp-3 transition-colors duration-300 mb-2">
                                            {{ $news->title }}

                                        </h5>
                                        <p class="flex items-center gap-2 text-xs lite-text-secondary">
                                            <i class="ri-time-line"></i>
                                            <span>{{ $news->created_at->diffForHumans() }}</span>

                                        </p>
                                    </div>
                                </a>
                            </article>
                        @endforeach



                    </div>

                    <!-- More Articles Button -->
                    <div class="mt-8 pt-6 border-t lite-border">
                        <a href="{{ route('category', ['slug' => $post->category->slug]) }}"
                            class="flex items-center justify-center gap-2 p-4 border lite-border rounded-lg hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300 group">
                            <i class="ri-newspaper-line"></i>
                            <span class="font-medium">Tüm {{ $post->category->title }} Haberleri</span>
                            <i class="ri-arrow-right-line group-hover:translate-x-1 transition-transform duration-300"></i>
                        </a>
                    </div>

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
    <div id="liteShareModal" class="fixed inset-0 bg-black bg-opacity-50 z-[1005] hidden items-center justify-center p-4">
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
    </div>

    @if (count($comments) > 0)
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
    @endif


    <!-- Toast Notification -->
    <div id="toast" class="fixed top-4 right-4 z-60 hidden">
        <div class="bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg bounce-in flex items-center space-x-2">
            <i class="ri-check-line"></i>
            <span id="toastMessage">İşlem başarılı!</span>
        </div>
    </div>

    <div id="imageModal" class="fixed inset-0 z-[1005] hidden">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/80 modal-backdrop fade-in"></div>

        <!-- Modal Content -->
        <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
            <div class="lite-bg-secondary rounded-3xl shadow-2xl max-w-6xl w-full  overflow-hidden slide-up">
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-4 py-2 border-b lite-border">
                    <!-- <div class="flex items-center space-x-4">
                                                                                              <div
                                                                                                  class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                                                                                  <i class="fas fa-image text-white text-lg"></i>
                                                                                              </div>
                                                                                              <div>
                                                                                                  <h3 id="modalTitle" class="text-xl font-bold text-gray-900">Yapay Zeka Teknolojileri</h3>
                                                                                                  <p id="modalDescription" class="text-gray-600 text-sm">Resim açıklaması</p>
                                                                                              </div>
                                                                                          </div> -->

                    <!-- Action Buttons -->
                    <div class="flex items-center space-x-2 ">
                        <button id="downloadBtn" class="lite-btn lite-btn-outline lg:lite-btn-md lite-btn-sm">
                            <i class="ri-download-line"></i>
                        </button>
                        <button id="shareModalBtn" class="lite-btn lite-btn-outline lg:lite-btn-md lite-btn-sm">
                            <i class="ri-share-line"></i>
                        </button>
                        <!-- <button id="favoriteBtn"
                                                                                                  class="p-3 text-gray-700 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200">
                                                                                                  <i id="favoriteIcon" class="ri-heart-line"></i>
                                                                                              </button> -->

                    </div>
                    <div class="flex items-center space-x-2">
                        <button id="closeModalBtn" class="lite-btn lite-btn-outline lg:lite-btn-md lite-btn-sm">
                            <i class="ri-close-line"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="lg:p-6 p-2">
                    <div class="relative rounded-2xl overflow-hidden lite-bg-primary">
                        <!-- Loading Skeleton -->
                        <div id="imageSkeleton" class="aspect-video image-skeleton"></div>

                        <!-- Main Image -->
                        <img id="modalImage" class="w-full h-auto max-h-[80vh] object-contain hidden rounded-2xl"
                            alt="Modal Image">

                        <!-- Image Controls -->
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black/50 backdrop-blur-sm rounded-full px-6 py-3 flex items-center space-x-4 opacity-0 hover:opacity-100 transition-opacity duration-300"
                            id="imageControls">
                            <button id="zoomOutBtn" class="text-white hover:text-blue-400 transition-colors p-1">
                                <i class="fas fa-search-minus"></i>
                            </button>
                            <span class="text-white text-sm font-medium" id="zoomLevel">100%</span>
                            <button id="zoomInBtn" class="text-white hover:text-blue-400 transition-colors p-1">
                                <i class="fas fa-search-plus"></i>
                            </button>
                            <div class="w-px h-4 bg-white/30"></div>
                            <button id="resetZoomBtn" class="text-white hover:text-blue-400 transition-colors text-sm">
                                Reset
                            </button>
                        </div>
                    </div>


                </div>


            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script>
        $(document).ready(function() {
            const relatedBox = `
            <section class="mb-12">
                <div class="">
                    <a href="{{ route('post', ['categoryslug' => $infiniteurl->category->slug, 'slug' => $infiniteurl->slug, 'id' => $infiniteurl->id]) }}"
                        class="lite-interesting-news-card flex lg:flex-row flex-col items-center gap-4 px-4">
                        <div class="overflow-hidden rounded-lg lite-interesting-news-card-img-box p-6">
                            <img src="{{ asset($infiniteurl->images) }}" alt="{{ $infiniteurl->title }}" class="w-full">
                        </div>
                        <div class="content">
                            <span class="category">{{ $infiniteurl->category->title }}</span>
                        
                            <h3 class='font-semibold lite-text-third'>{{ $infiniteurl->title }}</h3>
                            <div class="meta">
                                <span>{{ $infiniteurl->created_at->diffForHumans() }}</span>
                                <span class="lite-text-third font-semibold">Bu Haber İlginizi Çekebilir <i class="ri-arrow-right-line m-l-1"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
            </section>
        `;
            @if ($infiniteurl != null)
                // Örnek 1: 2. paragraftan sonra ekle
                insertBoxAfterParagraph('#liteArticleContent', relatedBox, 6);
            @endif

        });
    </script>

@endsection
