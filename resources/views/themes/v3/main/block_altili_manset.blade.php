
<!-- Mini Manşetler -->


@if (!blank(config('official_advert')))

<div class="container mobyok ">
   <div class="spotlar">
      @php $official_adverts = config('official_advert'); @endphp
      @foreach($official_adverts as $official)
            <div class="spot-2  bik-ilan" id="bik-ilan-{{$official['ilan_id']}}">

              <a href="{{'resmi-ilanlar/'.$official['id']}}"
               title="{{html_entity_decode($official['title']) }}">
                    <div class="w-100 overflow-hidden" style="height: 276px">
                    <span class="badge-custom-main">RESMİ İLANDIR</span>

                          <img src="{{ route('resizeImage', ['i_url' => $official['images'] ,'w' => 217, 'h' => 250]) }}" alt="{{html_entity_decode($official['title']) }}"
                          onerror="this.onerror=null;this.src='/uploads/defaultimage.jpg'" width="217" height="250">
                    </div>
                    <p><span>{{html_entity_decode($official['title']) }}</span></p>
                    </a>
            </div>

      @endforeach
   </div>
</div>

<div class="container mobvar ">
      @php $official_adverts = config('official_advert'); @endphp
      <div class="spotlar"  style="margin: 0px 0px 5px 0px;"> @php	$counter = 1;	@endphp
      @foreach($official_adverts as $officialKey => $official)

            <div class="spot spotduz3 spotduz3-{{ $counter }}  bik-ilan" id="bik-ila-{{$official['ilan_id']}}">
                    <a href="{{'resmi-ilanlar/'.$official['id']}}"
                    title="{{html_entity_decode($official['title']) }}">
                    <span class="badge-custom-main">RESMİ İLANDIR</span>
                    <img src="{{ route('resizeImage', ['i_url' => $official['images'] ,  'w' => 380, 'h' => 253]) }}" alt="{{html_entity_decode($official['title']) }}"
                        onerror="this.onerror=null;this.src='/uploads/defaultimage.jpg'" width="380" height="253">
                        <p><span>{{html_entity_decode($official['title']) }}</span></p>
                    </a> </div>

        @endforeach
    </div>
</div>
@endif
@if (\Illuminate\Support\Facades\Storage::disk('public')->exists('main/mini_manset.json'))

@php
$mini_mansetler = \Illuminate\Support\Facades\Storage::disk('public')->json('main/mini_manset.json');
@endphp

<div class="container">
<div class="spotlar">

	@php $counter = 1; @endphp

	@foreach ($mini_mansetler as $minimanset_key => $mini_manset)

		@if ($minimanset_key >= 3)
			<div class="spot spotduz spotduz-{{ $counter }}">
			<a href="{{ route('post', ['categoryslug' => categoryCheck($mini_manset['category_id'])->slug, 'slug' => $mini_manset['slug'], 'id' => $mini_manset['id']]) }}" title="{{ $mini_manset['title'] }}">
			<b>{{ categoryCheck($mini_manset['category_id'])->title }}</b>
			<div class="spot-resim"><img src="{{ route('resizeImage', ["i_url" => $mini_manset["images"], "w" => 550, "h" => 307]) }}" alt="{{html_entity_decode($mini_manset["title"]) }}" alt="{{ html_entity_decode($mini_manset["title"]) }}" /></div>
			<p><span>{{html_entity_decode($mini_manset["title"]) }}</span></p>
			</a>
			</div>

		@php $counter++; @endphp

		@endif

		@if ($counter == 7) @break @endif

	@endforeach

</div>
</div>

@else

	<div class="container">
	<div class="row my-3">
	<div class="alert alert-warning">Altılı Manşet Bulunamadı</div>
	</div>
	</div>

@endif
