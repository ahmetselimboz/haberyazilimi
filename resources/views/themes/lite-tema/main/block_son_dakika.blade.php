@if(\Illuminate\Support\Facades\Storage::disk('public')->exists('main/sondakika_manset.json'))
@php $son_dakikalar = \Illuminate\Support\Facades\Storage::disk('public')->json('main/sondakika_manset.json'); @endphp
    
    <!-- Hero/Banner Bölümü -->
    <section class="lite-bg-primary max-w-7xl relative  mx-auto lg:px-5 px-2 text-center py-2 md:py-4">

        <div class="lite-news-slider  mx-auto relative ">
            <div
                class="block md:hidden lite-bg-primary lite-text-accent pl-3 pr-1 py-1  font-semibold  w-fit text-sm mb-1 relative z-[1000] top-10">
                <p>Son Dakika</p>
            </div>
            <div class="lite-slider-container shadow-lg  !mb-0 relative rounded-lg">
              
                @foreach($son_dakikalar as $son_dakika)
              
                <!-- Slider İtemi 1 -->
                <div class="lite-slider-item">
                    <a href="{{ route('post', ['categoryslug' => $son_dakika['categoryslug'], 'slug' => $son_dakika['slug'], 'id' => $son_dakika['id']]) }}" class="block">
                        <div class="flex flex-row items-center justify-center gap-3 py-3 px-6">
                            <span class="lite-text-accent lg:text-sm text-xs font-semibold">{{ date('H:i', strtotime($son_dakika['created_at'])) }}</span>
                            <span
                                class="lite-text-primary lg:text-base text-sm font-semibold hover:lite-text-accent transition-colors duration-300">
                                {{ $son_dakika['title'] }}
                            </span>
                        </div>
                    </a>
                </div>

                @endforeach

            </div>
            <div
                class="lite-bg-accent px-4 py-3 h-full rounded-s-lg flex items-center justify-center w-36 absolute top-0 left-0 hidden md:block">
                <h3 class="lite-text-third font-semibold text-lg  leading-tight">Son Dakika</h3>
            </div>

        </div>


    </section>
@endif