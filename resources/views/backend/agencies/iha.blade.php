@extends('backend.layout')

@section('custom_css')
    <style>
        .thumbnail-container {
            display: flex;
            overflow-x: auto;
            gap: 10px;
            padding: 10px;
        }

        .thumbnail-container img {
            cursor: pointer;
            transition: transform 0.3s ease;
            border: 2px solid transparent;
        }

        .thumbnail-container img:hover {
            transform: scale(1.1);
        }

        .active-thumbnail {
            border: 2px solid #19ae9d;
        }

        .main-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection

@section('content')
    @include('backend.post.gemini')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="box">
                    <div class="box-header with-border d-flex flex-column flex-sm-row align-items-center">
                        <h4 class="box-title me-4">IHA Haberleri</h4>
                        @if (!isset($news['error']))
                            <div
                                class="col-2 d-flex flex-column flex-sm-row align-items-center justify-content-start mt-4 mt-lg-0 me-4">
                                <p class="my-0 me-2">Kategori:</p>
                                <select class="form-select" id="category-filter" style="width: 100%">
                                    <option value="" selected>Tümü</option>
                                    @foreach ($news['categories'] as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div
                                class="col-2 d-flex flex-column flex-sm-row align-items-center justify-content-start mt-4 mt-lg-0 me-4">
                                <p class="my-0 me-2">Şehir:</p>
                                <select class="form-select" id="city-filter" style="width: 100%">
                                    <option value="" selected>Tümü</option>
                                    @foreach ($news['cities'] as $city)
                                        <option value="{{ $city }}">{{ $city }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div
                                class="col-2 d-flex flex-column flex-sm-row align-items-center justify-content-start mt-4 mt-lg-0 me-4">
                                <p class="my-0 me-2">Tarih:</p>
                                <input class="form-control" type="date" id="date-filter">
                            </div>

                            <div class="col-1 me-4">
                                <button class="btn btn-success btn-sm" style="width: 100%"
                                    onclick="applyFilters()">Ara</button>
                            </div>
                            <div class="box-controls pull-right">
                                @if ($news['last_page'] > 1)
                                    <div aria-label="Page navigation">
                                        <div class="pagination justify-content-center">
                                            <div class="page-item me-1 ">

                                                <a class="btn btn-sm btn-secondary d-flex align-items-center {{ $news['current_page'] == 0 ? 'disabled' : '' }}"
                                                    href="?page={{ $news['current_page'] - 1 }}" aria-label="Önceki">
                                                    <span aria-hidden="true" class="d-flex align-items-center">
                                                        <i data-feather="arrow-left" style="height: 16px"></i>
                                                        Önceki Sayfa
                                                    </span>
                                                </a>
                                            </div>


                                            <div class="page-item">
                                                <a class="btn btn-sm btn-secondary d-flex align-items-center  {{ $news['current_page'] == $news['last_page'] ? 'disabled' : '' }}"
                                                    href="?page={{ $news['current_page'] + 1 }}" aria-label="Sonraki">
                                                    <span aria-hidden="true" class="d-flex align-items-center">
                                                        Sonraki Sayfa
                                                        <i data-feather="arrow-right" style="height: 16px"></i>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                    </div>

                    <div class="box-body no-padding">
                        <div class="row">
                            @if (!isset($news['error']))
                                @if (count($news['data']) > 0)
                                    @foreach ($news['data'] as $new)
                                        <div class="col-md-6 col-lg-6">
                                            <div class="card">
                                                <div class="card-header bg-primary text-white">
                                                    <strong>{{ $new['title'] }}</strong>
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="d-flex align-items-center me-3">
                                                            <h6 class="card-subtitle my-2 text-muted">{{ $new['pubDate'] }}
                                                            </h6>
                                                        </div>
                                                        <div class="d-flex align-items-center me-3">
                                                            <h6 class="card-subtitle my-2 text-muted me-1">Kategori: </h6>
                                                            <h6 class="card-subtitle my-2 text-muted">
                                                                {{ $new['kategori'] }}</h6>
                                                        </div>
                                                        <div class="d-flex align-items-center me-3">
                                                            <h6 class="card-subtitle my-2 text-muted me-1">Şehir: </h6>
                                                            <h6 class="card-subtitle my-2 text-muted">{{ $new['sehir'] }}
                                                            </h6>
                                                        </div>

                                                    </div>
                                                    <p class="card-text">{{ Str::limit($new['small_description'], 100) }}
                                                    </p>
                                                    <div
                                                        class="d-flex flex-row align-items-center justify-content-center mt-2">
                                                        <button
                                                            class="btn btn-sm btn-info detay-btn d-flex align-items-center me-1"
                                                            data-title="{{ $new['title'] }}"
                                                            data-date="{{ $new['pubDate'] }}"
                                                            data-description="{{ $new['description'] }}"
                                                            data-small-description="{{ $new['small_description'] }}"
                                                            data-images='@json($new['images'])'
                                                            data-small-images='@json($new['small_images'])'>
                                                            <i data-feather="eye" class="me-1"></i> Detayları Gör
                                                        </button>
                                                        <button type="submit"
                                                            class="btn btn-sm py-1 btn-success d-flex align-items-center card-btn"
                                                            data-title="{{ $new['title'] }}"
                                                            data-date="{{ $new['pubDate'] }}"
                                                            data-description="{{ $new['description'] }}"
                                                            data-small-description="{{ $new['small_description'] }}"
                                                            data-images='@json($new['images'])'
                                                            data-small-images='@json($new['small_images'])'>
                                                            <i data-feather="plus"></i>
                                                            Habere Ekle
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if ($news['last_page'] > 1)
                                        <div aria-label="Page navigation">
                                            <div class="pagination justify-content-center">
                                                <div class="page-item me-1 ">

                                                    <a class="btn btn-sm btn-secondary d-flex align-items-center {{ $news['current_page'] == 0 ? 'disabled' : '' }}"
                                                        href="?page={{ $news['current_page'] - 1 }}" aria-label="Önceki">
                                                        <span aria-hidden="true" class="d-flex align-items-center">
                                                            <i data-feather="arrow-left" style="height: 16px"></i>
                                                            Önceki Sayfa
                                                        </span>
                                                    </a>
                                                </div>


                                                <div class="page-item">
                                                    <a class="btn btn-sm btn-secondary d-flex align-items-center  {{ $news['current_page'] == $news['last_page'] ? 'disabled' : '' }}"
                                                        href="?page={{ $news['current_page'] + 1 }}" aria-label="Sonraki">
                                                        <span aria-hidden="true" class="d-flex align-items-center">
                                                            Sonraki Sayfa
                                                            <i data-feather="arrow-right" style="height: 16px"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="col-12 text-center">
                                        <p class="my-4">
                                            Haber Bulunamadı!
                                        </p>


                                    </div>
                                @endif
                            @else
                                <div class="col-12 text-center">
                                    <p class="mt-4">
                                        <strong>Ayarlar > Ajanslar</strong> sayfasındaki <strong>IHA Abonelik
                                            bilgilerini doğru ve eksiksiz</strong> bir şekilde doldurunuz!
                                    </p>
                                    <a href="{{ route('settings') }}" class="btn btn-primary btn-sm mb-4">Ayarlara
                                        Git</a>

                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="rssModal" tabindex="-1" aria-labelledby="rssModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rssModalLabel">Haber Detayları</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">

                    <p><strong>Başlık:</strong> <span id="modal-news-title"></span></p>
                    <p><strong>Tarih:</strong> <span id="modal-date"></span></p>
                    <hr>
                    <div class="text-center d-flex align-items-center justify-content-center" style="height: 400px;">
                        <div id="imageSpinner" class="spinner-border text-primary d-none" role="status">
                            <span class="visually-hidden">Yükleniyor...</span>
                        </div>
                        <!-- Büyük Resim -->
                        <img id="mainImage" src="" class="rounded" style="max-height: 400px;">
                    </div>

                    <!-- Küçük Resimler -->
                    <div class="thumbnail-container my-3 d-flex justify-content-center align-items-center">
                        <!-- Küçük resimler burada jQuery ile yüklenecek -->

                    </div>

                    <div class="text-center mb-4">
                        <small class="text-danger ">Resimler arasında geçiş yapabilirsiniz. Son görüntülediğiniz resim ana
                            resim olarak seçilir.</small>
                    </div>
                    <p id="modal-description"></p>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary py-1 my-0" data-bs-dismiss="modal">Kapat</button>
                    <form id="newsForm" action="{{ route('agencies.post') }}" method="post" target="_blank">
                        @csrf
                        <input type="hidden" name="title" id="title">
                        <input type="hidden" name="detail" id="detail">
                        <input type="hidden" name="description" id="description">
                        <input type="hidden" name="image" id="imageInput">
                        <button type="submit" class="btn btn-sm py-1 btn-success d-flex align-items-center">
                            <i data-feather="plus"></i>
                            Habere Ekle
                        </button>
                    </form>
                    <button type="button" data-type="agencies"
                        class="btn btn-sm py-1 btn-info d-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#geminiChatModal">
                        <i data-feather="send" class="me-1" style="width: 20px"></i>
                        Gemini ile Özelleştir
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script>
        $(document).ready(function() {
            let title;
            let date;
            let description;
            let images
            let smallImages
            let small_description
            $('.detay-btn').on('click', function() {
                title = $(this).data('title');
                date = $(this).data('date');
                description = $(this).data('description');
                small_description = $(this).data('small-description');

                images = $(this).data('images'); // JSON formatında gelir
                smallImages = $(this).data('small-images');

                images = Object.values(images).filter(item => typeof item === "string");
                smallImages = Object.values(smallImages).filter(item => typeof item === "string");

                // Global değişkenleri window objesine ekle
                window.images = images;
                window.title = title;
                window.small_description = small_description;

                if (!images) {
                    console.error("Hata: Görseller bulunamadı!");
                    return;
                }

                // Önce küçük resimlerin container'ını temizle
                $(".thumbnail-container").empty();

                // İlk resmi ana resim olarak belirle
                $("#mainImage").attr("src", images[0]);

                // Küçük resimleri ekrana bas
                smallImages.forEach((src, index) => {
                    $(".thumbnail-container").append(`
                                                        <img src="${src}" data-index="${index}" class="thumbnail ${index === 0 ? 'active-thumbnail' : ''}">
                                                    `);
                });

                // Küçük resme tıklanınca büyük resmi değiştir
                $(".thumbnail-container").on("click", ".thumbnail", function() {
                    let index = $(this).data("index");

                    // Spinner'ı göster
                    $("#imageSpinner").removeClass("d-none");
                    $("#mainImage").addClass("d-none");

                    // Büyük resmi değiştirirken yükleme olayını yakala
                    $("#mainImage").attr("src", images[index]).on("load", function() {
                        // Resim yüklendiğinde spinner'ı gizle
                        $("#imageSpinner").addClass("d-none");
                        $("#mainImage").removeClass("d-none");

                    });

                    // Aktif thumbnail class'ını ayarla
                    $(".thumbnail").removeClass("active-thumbnail");
                    $(this).addClass("active-thumbnail");
                });

                $('#mainImage').on('error', function() {

                    $(this).attr('alt', ' Resim URL si bozuk');
                });

                // Modal bilgilerini güncelle ve aç
                $('#modal-title').text(title);
                $('#modal-news-title').text(title);
                $('#modal-date').text(date);
                $('#modal-description').html(description);
                $('#rssModal').modal('show');
            });


            document.getElementById("newsForm").addEventListener("submit", function(event) {
                event.preventDefault();

                images = Object.values(images).filter(item => typeof item === "string");
                // Resimleri HTML formatına çevirip description'ı ekliyoruz
                let imagesHtml = images.map(img => `<img src="${img}" style="width:50%;">`).join('') +
                   
                    description.replace(/&lt;br\/&gt;/g, '<br/>'); // HTML entity düzeltme
                var src = $("#mainImage").attr("src");
                document.getElementById("detail").value = imagesHtml;
                document.getElementById("title").value = title;
                document.getElementById("description").value = small_description;
                document.getElementById("imageInput").value = src;

                this.submit(); // Formu gönder
            });



            $('.card-btn').on('click', function() {
                title = $(this).data('title');
                date = $(this).data('date');
                description = $(this).data('description');
                small_description = $(this).data('small-description');

                images = $(this).data('images'); // JSON formatında gelir
                smallImages = $(this).data('small-images');

                images = Object.values(images).filter(item => typeof item === "string");
                smallImages = Object.values(smallImages).filter(item => typeof item === "string");

                // Global değişkenleri window objesine ekle
                window.images = images;
                window.title = title;
                window.small_description = small_description;

                if (!images) {
                    console.error("Hata: Görseller bulunamadı!");
                    return;
                }

                // Önce küçük resimlerin container'ını temizle
                $(".thumbnail-container").empty();

                // İlk resmi ana resim olarak belirle
                $("#mainImage").attr("src", images[0]);

                // Küçük resimleri ekrana bas
                smallImages.forEach((src, index) => {
                    $(".thumbnail-container").append(`
                                                        <img src="${src}" data-index="${index}" class="thumbnail ${index === 0 ? 'active-thumbnail' : ''}">
                                                    `);
                });

                // Küçük resme tıklanınca büyük resmi değiştir
                $(".thumbnail-container").on("click", ".thumbnail", function() {
                    let index = $(this).data("index");

                    // Spinner'ı göster
                    $("#imageSpinner").removeClass("d-none");
                    $("#mainImage").addClass("d-none");

                    // Büyük resmi değiştirirken yükleme olayını yakala
                    $("#mainImage").attr("src", images[index]).on("load", function() {
                        // Resim yüklendiğinde spinner'ı gizle
                        $("#imageSpinner").addClass("d-none");
                        $("#mainImage").removeClass("d-none");

                    });

                    // Aktif thumbnail class'ını ayarla
                    $(".thumbnail").removeClass("active-thumbnail");
                    $(this).addClass("active-thumbnail");
                });

                $('#mainImage').on('error', function() {

                    $(this).attr('alt', ' Resim URL si bozuk');
                });

                images = Object.values(images).filter(item => typeof item === "string");
                // Resimleri HTML formatına çevirip description'ı ekliyoruz
                let imagesHtml = images.map(img => `<img src="${img}" style="width:50%;">`).join('') +
                 
                    description.replace(/&lt;br\/&gt;/g, '<br/>'); // HTML entity düzeltme
                var src = $("#mainImage").attr("src");
                document.getElementById("detail").value = imagesHtml;
                document.getElementById("title").value = title;
                document.getElementById("description").value = small_description;
                document.getElementById("imageInput").value = src;



                document.getElementById("newsForm").submit();
            });



            // Gemini Modal için
            $('#geminiChatModal').on('shown.bs.modal', function() {
                if ($('#rssModal').hasClass('show')) {
                    $('#rssModal').modal('hide');
                }

                // Resimleri HTML formatına çevirip description'ı ekliyoruz
                let imagesHtml = images.map(img =>
                        `<img src="${img}" style="width:50%;margin-bottom:40px;">`).join('') +

                    description.replace(/&lt;br\/&gt;/g, '<br/>'); // HTML entity düzeltme

                // Gemini modalındaki message alanına içeriği aktar
                $("#message").val(imagesHtml);
                $("#message").css('height', '150px');
            });

            $('#geminiChatModal').on('hidden.bs.modal', function() {
                $('#message').val('').css('height', 'auto');
                $('#chat-box').html(
                    '<p class="text-muted text-center">Sohbeti başlatmak için bir mesaj yazın.</p>');
            });

            // Hata durumunda
            $('#geminiChatModal').on('show.bs.modal', function(e) {
                if (typeof bootstrap === 'undefined') {
                    console.error('Bootstrap yüklenmemiş!');
                }
                if (typeof $ === 'undefined') {
                    console.error('jQuery yüklenmemiş!');
                }
            });
        });

        function applyFilters() {
            let category = document.getElementById('category-filter').value;
            let city = document.getElementById('city-filter').value;
            let date = document.getElementById('date-filter').value;

            let queryString = '?';
            if (category) queryString += `kategori=${encodeURIComponent(category)}&`;
            if (city) queryString += `sehir=${encodeURIComponent(city)}&`;
            if (date) queryString += `pubDate=${encodeURIComponent(date)}&`;

            // Boş parametreleri temizle
            queryString = queryString.replace(/&$/, '');

            // Sayfayı güncellenmiş URL ile yeniden yükle
            window.location.href = window.location.pathname + queryString;
        }

        // Sayfa yüklendiğinde mevcut filtreleri set et
        window.onload = function() {
            const params = new URLSearchParams(window.location.search);

            if (params.has('kategori')) {
                document.getElementById('category-filter').value = params.get('kategori');
            }
            if (params.has('sehir')) {
                document.getElementById('city-filter').value = params.get('sehir');
            }
            if (params.has('pubDate')) {
                document.getElementById('date-filter').value = params.get('pubDate');
            }
        };
    </script>
@endsection
