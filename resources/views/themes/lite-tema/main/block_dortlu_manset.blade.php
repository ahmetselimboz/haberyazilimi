@if(\Illuminate\Support\Facades\Storage::disk('public')->exists('main/dortlu_manset.json'))
@php $dortlu_mansetler = \Illuminate\Support\Facades\Storage::disk('public')->json('main/dortlu_manset.json'); @endphp
 

<section class="max-w-7xl mx-auto lg:px-5 px-2 text-center pb-3 md:py-4 ">
    <div class="lite-cards-slider">

        <div class="lite-cards-container lite-slider">

            @foreach($dortlu_mansetler as $dortlu)
            <div class=" lite-news-item px-4 py-2">
                <a href="{{ route('post', ['categoryslug'=>$dortlu['categoryslug'],'slug'=>$dortlu['slug'],'id'=>$dortlu['id']]) }}" class="block">

                    <div
                        class=" lite-bg-secondary border lite-border rounded-lg  overflow-hidden  group hover:shadow-lg transition-all duration-300 cursor-pointer">

                        <div class="relative overflow-hidden">
                            <img src="{{ asset($dortlu['images']) }}"
                                alt="Teknoloji Haberi"
                                class="lg:w-full w-24 lg:h-40 h-24 rounded-lg object-cover transition-transform duration-500 group-hover:scale-105">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                        <div class="lg:p-4 py-4 px-0">
                            <h4
                                class="lite-text-primary font-semibold line-clamp-3 text-lg mb-2 leading-tight group-hover:lite-text-accent transition-colors duration-300">
                                {{ $dortlu['title'] }}</h4>
                            <p class="lite-text-secondary text-xs mb-3 line-clamp-2">{{ $dortlu['description'] }}</p>
                            <div class="flex items-center justify-between text-xs lite-text-secondary">
                                <div class="flex items-center gap-1"><i class="ri-menu-search-line"></i><span>{{ $dortlu['categorytitle'] }}</span>
                                </div>
                                <div class="flex items-center gap-1"><i class="ri-time-line"></i><span>
                                    {{ \Carbon\Carbon::parse($dortlu['created_at'])->diffForHumans() }}</span></div>
                            </div>
                        </div>

                    </div>
                </a>

            </div>
            @endforeach


        </div>
    </div>
</section>

@endif
