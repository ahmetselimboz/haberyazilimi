@if(\Illuminate\Support\Facades\Storage::disk('public')->exists('main/dortlu_manset.json'))
@php $dortlu_mansetler = \Illuminate\Support\Facades\Storage::disk('public')->json('main/dortlu_manset.json'); @endphp
 

 <!-- Instagram Hikayeler Bölümü -->
 <section class="max-w-7xl mx-auto lg:px-5 px-2 lg:py-2 py-4">

    <!-- Stories Container -->
    <div class="lite-stories-container sm:px-0 relative">
        <!-- Navigation Buttons - Desktop Only -->
        <button class="lite-stories-prev absolute left-0 top-1/3 z-10 lite-slider-nav-btn hidden md:flex">
            <i class="ri-arrow-left-line"></i>
        </button>
        <button class="lite-stories-next absolute right-0 top-1/3 z-10 lite-slider-nav-btn hidden md:flex">
            <i class="ri-arrow-right-line"></i>
        </button>

        <!-- Stories Slider -->
        <div class="lite-stories-slider  lg:mx-12 mx-0">
            <div class="lite-stories-slick-slider" data-stories="{{ json_encode($dortlu_mansetler) }}" data-logo="{{ $settings['logo'] }}" data-title="{{ $settings['title'] }}" data-description="{{ $settings['description'] }}">
                <!-- Story items will be dynamically generated here -->
            </div>
        </div>
    </div>

    <!-- Story Modal -->
    <div id="liteStoryModal" class="fixed inset-0 bg-black bg-opacity-90 z-[1006] hidden items-center justify-center">
        <div class="relative w-full max-w-sm h-full max-h-screen bg-black">
            <!-- Close Button -->
            <button class="absolute top-2 right-4 z-[1003] text-white hover:text-gray-300 transition-colors">
                <i class="ri-close-line text-2xl"></i>
            </button>
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/100 via-black/50 to-transparent opacity-100 transition-opacity duration-300 z-[1000]">
            </div>
            <!-- Story Progress Bar -->
            <div class="absolute top-5 left-4 right-16 z-[1003]">
                <div class="flex gap-1">
                    <div class="lite-story-progress flex-1 h-1 lite-bg-primary rounded-full overflow-hidden">
                        <div class="lite-story-progress-bar h-full lite-bg-accent transition-all duration-300 w-0">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Story Content -->
            <div class="relative w-full h-full">
                <!-- Story Header -->
                <div class="absolute top-12 left-4 right-4 z-[1003] flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-white">
                        <img src="https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=400&h=250&fit=crop" id="liteStoryImageProfile"
                            alt="Story Author" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <p class="text-white font-medium text-sm" id="liteStoryTitle">Yapay Zeka
                            Teknolojilerinde Son Gelişmeler</p>
                        <p class="text-gray-300 text-xs" id="liteStoryTime">2 saat önce</p>
                    </div>
                </div>

                <!-- Story Image/Content -->
                <div class="w-full h-full lite-bg-primary flex items-center justify-center">
                    <img id="liteStoryImageBackground" src="assets/haber-gorsel.png" alt="Story Content"
                        class="w-full h-full object-cover blur-sm">
                </div>
                <div class="w-full h-full  flex items-center justify-center absolute inset-0">
                    <img id="liteStoryImage" src="assets/haber-gorsel.png" alt="Story Content"
                        class="w-full  object-contain">
                </div>

                <!-- Story Text Overlay -->
                <div class="absolute bottom-20 left-4 right-4 z-[1001]">
                    <h3 id="liteStoryHeadline" class="text-white font-bold text-lg mb-2 leading-tight">
                        Yapay Zeka Teknolojilerinde Son Gelişmeler
                    </h3>
                    <p id="liteStorySummary" class="text-gray-200 text-sm leading-relaxed">
                        AI teknolojilerinin günlük hayatımıza olan etkisi her geçen gün artıyor.
                    </p>
                </div>

                <!-- Story Actions -->
                <div class="absolute bottom-4 left-4 right-4 z-[1003] flex items-center justify-between">

                    <button class="flex items-center gap-2 text-white hover:text-gray-300 transition-colors"
                        id="liteStoryShare">
                        <i class="ri-share-line text-xl"></i>
                    </button>
                    <a class="bg-white bg-opacity-20 hover:bg-opacity-30 transition-all px-4 py-2 rounded-full"
                        href="/detail.html" id="liteStoryRead">
                        <span class="text-white text-sm font-medium">Haberi Oku</span>
                    </a>
                </div>

                <!-- Navigation Areas -->
                <div class="absolute inset-0 flex z-[1002]">
                    <div class="flex-1 cursor-pointer" id="liteStoryPrev"></div>
                    <div class="flex-1 cursor-pointer" id="liteStoryNext"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif