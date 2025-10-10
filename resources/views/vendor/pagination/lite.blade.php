@if ($paginator->hasPages())
    <div class="flex items-center justify-center text-sm gap-2 mb-8">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button
                class="px-4 py-2 lite-bg-secondary border lite-border rounded-lg lite-text-secondary hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                disabled>
                <i class="ri-arrow-left-s-line"></i>
                Önceki
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-4 py-2 lite-bg-secondary border lite-border rounded-lg lite-text-primary hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300">
                <i class="ri-arrow-left-s-line"></i>
                Önceki
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-4 py-2 lite-text-secondary">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button
                            class="px-4 py-2 lite-bg-accent text-white rounded-lg font-semibold">
                            {{ $page }}
                        </button>
                    @else
                        <a href="{{ $url }}"
                           class="px-4 py-2 lite-bg-secondary border lite-border rounded-lg lite-text-primary hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-4 py-2 lite-bg-secondary border lite-border rounded-lg lite-text-primary hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300">
                Sonraki
                <i class="ri-arrow-right-s-line"></i>
            </a>
        @else
            <button
                class="px-4 py-2 lite-bg-secondary border lite-border rounded-lg lite-text-secondary hover:lite-bg-accent hover:text-white hover:lite-accent-border transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                disabled>
                Sonraki
                <i class="ri-arrow-right-s-line"></i>
            </button>
        @endif

    </div>
@endif
