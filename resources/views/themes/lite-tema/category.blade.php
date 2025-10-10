@extends('themes.' . $theme . '.frontend_layout')

@section('meta')
    <title>{{ $category->tab_title ?? $category->title }}</title>
    <meta name="description" content="{{ $category->description }}">
    <meta name="keywords" content="{{ $category->keywords }}">

    <meta property="og:title" content="{{ $category->tab_title ?? $category->title }}" />
    <meta property="og:description" content="{{ $category->description }}" />
    <meta property="og:image" content="{{ imageCheck($category->images) }}" />
    <meta property="og:url" content="{{ route('category', ['slug' => $category->slug, 'id' => $category->id]) }}" />
    <meta property="og:type" content="category" />


    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@if (isset($magicbox['tw_name'])) {{ $magicbox['tw_name'] }} @endif" />
    <meta name="twitter:title" content="{{ $category->tab_title ?? $category->title }}" />
    <meta name="twitter:description" content="{{ $category->description }}" />
    <meta name="twitter:image" content="{{ imageCheck($category->images) }}" />

    <style>
        .ads-area {
            width: 100%;
            display: block !important;
            margin: 0;
        }

        @media (max-width: 768px) {
            .ads-area {
                margin: 0px 1% 20px 1% !important;

            }
        }

        .ads-field {}

        @media (max-width: 768px) {
            .ads-field {
                width: 100%;

            }
        }
    </style>
@endsection

@section('content')
    <!-- Kategoriler Alanı -->
    <section class="max-w-7xl mx-auto px-5 py-4">
        <!-- Haberler Başlığı -->
        <div class="flex items-center justify-between gap-2 my-8">
            <div class="">
                <h2 class="text-2xl md:text-3xl font-bold lite-text-primary mb-2">{{ $category->title }}</h2>
                <div class="w-16 h-1 lite-bg-accent rounded-full"></div>
            </div>
            <!-- <div class="flex items-center gap-2">
                            <a href="#" class="lite-btn underline lite-btn-ghost lite-btn-md">Tümünü Gör</a>
                        </div> -->
        </div>

        <!-- Haberler Listesi -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($posts_slider as $key => $post)
                <div
                    class="lite-news-item lite-bg-secondary border lite-border rounded-lg overflow-hidden group hover:shadow-lg transition-all duration-300">
                    <a href="{{ route('post', ['categoryslug' => $post->category->slug, 'slug' => $post->slug, 'id' => $post->id]) }}"
                        class="block">
                        <div class="relative overflow-hidden">
                            <img src="{{ $post->images }}" alt="{{ $post->title }}"
                                class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                        <div class="p-4">
                            <h4
                                class="lite-text-primary font-semibold text-lg mb-2 leading-tight group-hover:lite-text-accent transition-colors duration-300">
                                {{ $post->title }}
                            </h4>
                            <p class="lite-text-secondary text-xs mb-3 line-clamp-2">
                                {{ $post->description }}
                            </p>
                            <div class="flex items-center justify-between text-xs lite-text-secondary">
                                <div class="flex items-center gap-1">
                                    <i class="ri-user-line"></i>
                                    <span>{{ $post->category->title }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <i class="ri-time-line"></i>
                                    <span>{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @if ($key == 11)
                    @break
                @endif
            @endforeach
        </div>
        <div id="newsContainer">
            @include('themes.' . $theme . '.main._posts_list', ['posts_other' => $posts_other])
        </div>
        <!-- Başlangıçta gizli: class="hidden" ile -->
        <div id="loader" class="hidden text-center mt-8">
            <div class="w-8 h-8 border-4 border-gray-300 border-t-gray-500 rounded-full animate-spin inline-block"
                role="status" aria-label="Yükleniyor"></div>
            <span class="sr-only">Loading...</span>
        </div>

        <!-- Kullanım: document.getElementById('loader').classList.remove('hidden') ile göster -->

    </section>
@endsection

@section('custom_js')
    <script>
        let page = 2; // İlk sayfa yüklendi
        let loading = false;
        let nextPage = true;

        window.onscroll = function() {
            const scrollPosition = window.innerHeight + window.scrollY;
            const documentHeight = document.body.offsetHeight;

            const isMobile = window.innerWidth <= 768; // mobil için breakpoint
            const offsetThreshold = isMobile ? 1500 : 500; // mobil için 300px, desktop için 500px
            console.log(offsetThreshold)
            if (scrollPosition >= documentHeight - offsetThreshold && !loading && nextPage) {
                loadMoreData();
            }
        };

        function loadMoreData() {
            loading = true;
            document.getElementById("loader").style.display = "block";

            fetch(`{{ route('category.loadMore', ['slug' => $category->slug]) }}?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    if (data.html.trim() !== '') {
                        document.getElementById("newsContainer").insertAdjacentHTML('beforeend', data.html);
                        page++;
                        nextPage = data.nextPage !== null;
                    } else {
                        nextPage = false;
                    }
                    loading = false;
                    document.getElementById("loader").style.display = "none";
                })
                .catch(error => {
                    console.error("Hata:", error);
                    loading = false;
                    document.getElementById("loader").style.display = "none";
                });
        }
    </script>
@endsection
