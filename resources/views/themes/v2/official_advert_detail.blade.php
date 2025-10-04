@extends('themes.' . $theme . '.frontend_layout')
@php
$clsfad = $officialAdvert->clsfadmagicbox;
$images = isset($clsfad['images']) ? $clsfad['images']: null;
$tags = isset($clsfad['news_tags']) ?$clsfad['news_tags']:null;
$link = isset($clsfad['link']) && filter_var($clsfad['link'], FILTER_VALIDATE_URL) ? $clsfad['link']: null;
$description = preg_replace('/\s+/', ' ', trim(html_entity_decode(strip_tags($officialAdvert->detail))));
@endphp

@section('meta')
<title>{{ $officialAdvert->title }}</title>
<meta name="title" content="{{ $officialAdvert->title }}">
<meta name="description" content="{!! \Illuminate\Support\Str::limit($description, 160) !!}">
<link rel="canonical" href="{{ url()->current() }}">
<meta name="X-UA-Compatible" content="IE=edge">
<meta name="robots" content="max-image-preview:large">
<meta name="datePublished" content="{{ $officialAdvert->created_at->format('Y-m-d\TH:i:sP') }}">
<meta name="dateModified" content="{{ $officialAdvert->updated_at->format('Y-m-d\TH:i:sP') }}">
<meta name="articleSection" content="resmiilan">
<meta name="articleAuthor" content="www.bik.gov.tr">
<meta property="og:title" content="{{ $officialAdvert->title }}" />
<meta property="og:description" content="{!! \Illuminate\Support\Str::limit($description, 160) !!}" />
<meta property="og:image" content="{{  $officialAdvert->images ? imageCheck($officialAdvert->images) : $images}}" />
<meta property="og:url" content="{{ route('home.offficial_advert_detail', ['id' => $officialAdvert->id]) }}" />
<meta property="og:type" content="news" />

<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="@if (isset($magicbox['tw_name'])) {{ $magicbox['tw_name'] }} @endif" />
<meta name="twitter:title" content="{{ $officialAdvert->title }}" />
<meta name="twitter:description" content="{!! \Illuminate\Support\Str::limit($description, 160) !!}" />
<meta name="twitter:image" content="{{ $officialAdvert->images ? imageCheck($officialAdvert->images) : $images}}" />

 <script>!function(){var
t=document.createElement("script");t.setAttribute("src",'https://cdn.p.analitik.bik.gov.tr/
tracker'+(typeof Intl!=="undefined"?(typeof
(Intl||"").PluralRules!=="undefined"?'1':typeof Promise!=="undefined"?'2':typeof
MutationObserver!=='undefined'?'3':'4'):'4')+'.js'),t.setAttribute("data-websiteid","af123456-f10c-1234-8c75-e123451cf8da"),t.setAttribute("data-hosturl",'//af963426-f10c-4067-8c75-
e166631cf8da.collector.p.analitik.bik.gov.tr'),document.head.appendChild(t)}();</script>

<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "NewsArticle",
    "mainEntityOfPage": {
      "@type": "WebPage",
      "@id": "{{ route('home.offficial_advert_detail', ['id'=>$officialAdvert->id]) }}"
    },
    "headline": "{{ $officialAdvert->title }}",
    "description": "{!! \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($officialAdvert->detail))) !!}",
    "image": "{{ $officialAdvert->images ? imageCheck($officialAdvert->images) : $images  }}",
    "author": {
      "@type": "Organization",
      "name": "Yazar",
    },
    "publisher": {
      "@type": "Organization",
      "name": "{{ $settings['title'] }}",
      "logo": {
        "@type": "ImageObject",
        "url": "{{ imageCheck($settings['logo']) }}"
      }
    },
    "datePublished": "{{ date('Y-m-d', strtotime($officialAdvert->created_at)) }}",
    "dateModified": "{{ date('Y-m-d', strtotime($officialAdvert->updated_at)) }}"
  }
</script>

<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [{
      "@type": "ListItem",
      "position": 1,
      "name": "Resmi İlanlar",
      "item": ""
    }, {
      "@type": "ListItem",
      "position": 2,
      "name": "{{ $officialAdvert->title }}",
      "item": "{{ route('home.offficial_advert_detail', ['id'=>$officialAdvert->id]) }}"
    }]
  }
</script>
<style>
  .official-detail img {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 10px auto;
    max-height: 590px;

  }

  .official-detail table {
    width: 100%;
    max-width: 100%;
    border-collapse: collapse;
    overflow-x: auto;
    display: block;
  }

  .official-detail table th,
  .official-detail table td {
    padding: 8px;
    border: 1px solid #ddd;
    text-align: left;
  }

  .official-detail iframe {
    max-width: 100%;
    height: auto;
    aspect-ratio: 16/9;
    /* Video ve gömülü içerikleri oranlı yapar */
  }

  .detayresim {
        max-height: 590px;
    }

   @media (max-width: 768px) {
    .official-detail table {

    overflow-x: scroll;

  }
}
  
}
</style>
@endsection

@section('content')


<div class="container burak 123">
  <div class="row">
    <div class="col-12">
      <div class="category-headline-block justify-content-between flex-wrap mb-4"> <!--Block Başlık-->
        <p class="text-black " style=" font-weight: 800;
        font-size: 24px;">{{ $officialAdvert->title }}</p>

        <div class="">
          <b>{{ $officialAdvert->create_date }}</b>
        </div>
      </div>

    </div>
    <!--<div class="col-12">-->
    <!--  <img src="{{ asset($officialAdvert->images) }}" onerror="this.onerror=null;this.src='/uploads/defaultimage.jpg'"  alt="{{ $officialAdvert->title }}"-->
    <!--    class="detayresim {{ $officialAdvert->images ? 'd-block' : 'd-none' }}" width="">-->
    <!--</div>-->

    <div class="col-12 col-md-12">
      <div class="col-12 bg-gray rounded-1 mb-4">
        <div class="container ">
          <div class="row py-1">
            <div class="col-12  py-2 pe-md-2 official-detail">
              {!! $officialAdvert->detail !!}
            </div>

            <div class="py-2 pe-md-2 official-detail  d-flex justify-content-between bg-light  ">
              <a href="https://www.ilan.gov.tr" target="_blank" title="BİK" class="fw-bold" rel="nofollow">#ilangovtr</a>
              <span class="fw-bold">Basın No: {{$officialAdvert->ilan_id}}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection