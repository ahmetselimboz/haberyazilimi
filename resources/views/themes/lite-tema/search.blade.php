@extends('themes.' . $theme . '.frontend_layout')

@section('meta')
    <title>Arama sayfası</title>
    <meta name="description" content="Arama sayfası">
@endsection


@section('content')
    <!-- Kategoriler Alanı -->
    <section class="max-w-7xl mx-auto px-5 py-4">
        <!-- Haberler Başlığı -->
        <div class="flex items-center justify-between gap-2 my-8">
            <div class="">
                <h2 class="text-2xl md:text-3xl font-bold lite-text-primary mb-2">@lang('frontend.news')</h2>
                <div class="w-16 h-1 lite-bg-accent rounded-full"></div>
            </div>
            <!-- <div class="flex items-center gap-2">
                    <a href="#" class="lite-btn underline lite-btn-ghost lite-btn-md">Tümünü Gör</a>
                </div> -->
        </div>

        <!-- Haberler Listesi -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($posts as $post)
                <!-- Haber Item 1 -->
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

            @empty
                <div class="text-center my-10 col-span-full">
                    <h5 class="text-gray-400 text-xl">@lang('frontend.not_found')</h5>
                </div>
            @endforelse
        </div>
    </section>

    {{ $posts->links('vendor.pagination.lite') }}
@endsection
