@extends('backend.layout')

@section('custom_css')
    <style>
        .card-custom {
            min-width: 120px;
            min-height: 150px;
            text-align: center;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 5px 1px #00b8d487;
            background: #fff !important;
            border: 2px solid #00b8d4;
            text-decoration: none;
            color: black;
            transition: .2s ease-in-out;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }


        .icon {
            font-size: 24px;
            margin-bottom: 10px;
            width: 60px;
            height: 60px;
            background-color: #00b8d4;
            color: #fff;
            transition: 0.3s;
        }

        .card-custom:hover {
            background-color: white;
            color: #00b8d4;
            box-shadow: 0 0 5px 1px #00b8d4;
        }

        .card-container {
            gap: 10px;
        }


        .card-text {
            color: #00b8d4 !important;
        }

        .index-custom-arrow {

            background: none;
            border: none;
            padding: 0;
        }

        .slider-row {
            border-top: 1px solid #2d2d2d26;
            border-bottom: 1px solid #2d2d2d26;
            box-shadow: 0 0 10px 1px #00b8d4;
            background: #00b8d4;
            padding: 0 1rem;
        }

        .slider-text {
            font-size: 16px;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
        }

        .slider-text i {

            color: #fff;
        }

        .slider-btn {
            background-color: #fff;
            color: #00b8d4;
            border: 1px solid #fff;

        }

        .slider-btn:hover {
            background-color: #c9c9c9;
            color: #2b2b2b;
            border: 1px solid #00b8d4;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
@endsection

@section('content')

    <div class="modal fade" id="notifyModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content rounded-3">
                <div class="modal-header bg-success">
                    <h4 class="text-center m-2 modal-title"></h4>
                    <button type="button" id="close-model" class="btn-close text-white" data-bs-dismiss="modal"
                        aria-label="Kapat"></button>
                </div>
                <hr class="mt-0">
                <div>

                    <div class="modal-message p-4">
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary py-1 my-0 " data-bs-dismiss="modal">Kapat</button>


                </div>

            </div>
        </div>
    </div>
    @include('backend.post.stats_popup')
    <section class="content">

        <div class="row">
            <div class="col-12">
                <div class="row g-0 py-2 mb-4">

                    <div class="d-flex flex-wrap justify-content-center card-container">
                        <div class="col">
                            <a href="{{ route('googleAnalytic') }}" class="card-custom py-4">
                                <div class="icon  rounded-circle d-flex align-items-center justify-content-center">
                                    <i data-feather="bar-chart-2"></i>
                                </div>
                                <h4 class="card-text">Google Analitik</h4>

                            </a>
                        </div>
                        <div class="col">
                            <a href="{{ route('seocheck', ['type' => '1']) }}" class="card-custom py-4">
                                <div class="icon  rounded-circle d-flex align-items-center justify-content-center">
                                    <i data-feather="edit-3"></i>
                                </div>
                                <h4 class="card-text">Başlık Sorunları</h4>

                            </a>
                        </div>

                        <div class="col">
                            <a href="{{ route('seocheck', ['type' => '2']) }}" class="card-custom py-4">
                                <div class="icon  rounded-circle d-flex align-items-center justify-content-center">
                                    <i data-feather="book-open"></i>
                                </div>
                                <h4 class="card-text">Açıklama Sorunları</h4>

                            </a>
                        </div>

                        <div class="col">
                            <a href="{{ route('seocheck', ['type' => '3']) }}" class="card-custom py-4">
                                <div class="icon  rounded-circle d-flex align-items-center justify-content-center">
                                    <i data-feather="tag"></i>
                                </div>
                                <h4 class="card-text">Etiket Sorunları</h4>

                            </a>
                        </div>


                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>

        @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('notifications.json'))
            @php
                $notifications = \Illuminate\Support\Facades\Storage::disk('public')->json('notifications.json');

            @endphp
        @else
            $notifications = [];
        @endif

        <div class="row mb-4 slider-row">

            <div class="slider d-flex my-3">

                @forelse($notifications as $notify)
                    <div class="d-flex flex-row justify-content-center">
                        <p class="slider-text mb-0">
                            <i class="fa fa-exclamation "></i>
                            {{ $notify['title'] }}
                        </p>
                        <button class="btn btn-outline-info btn-sm slider-btn py-1 ms-2" data-bs-toggle="modal"
                            data-bs-target="#notifyModal" data-title="{{ $notify['title'] }}"
                            data-message="{{ $notify['message'] }}">Detaylar İçin Tıkla</button>
                    </div>


                @empty

                    <div class="text-center">
                        <p class="slider-text mb-0">
                            <i class="fa fa-exclamation"></i>
                            Bildirim yok
                        </p>
                    </div>
                @endforelse
                @if (count($notifications) === 1)
                    <div class="d-flex flex-row align-items-center invisible">
                        <p class="slider-text mb-0">
                            <i class="fa fa-exclamation "></i>
                            Test
                        </p>
                        <button class="btn btn-outline-info btn-sm slider-btn py-1 ms-2" data-bs-toggle="modal"
                            data-bs-target="#notifyModal">Detaylar İçin Tıkla</button>
                    </div>
                @endif
            </div>

        </div>
        <div class="row">

            @if (Auth::check() and Auth::user()->status == 1)
                {{-- <div class="col-xl-5 col-12">
                    <div class="box">
                        <div class="box-header no-border pb-0">
                            <h4 class="box-title">DENETLEME BEKLEYENLER </h4>
                        </div>
                        <div class="box-body mb-1">
                            <div class="bs-3 my-3 ps-3 py-2 border-primary"> ÜYELER
                                <div class="box-controls pull-right"><span
                                        class="badge badge-primary">{{ $count_user }}</span></div>
                            </div>
                            <div class="bs-3 my-3 ps-3 py-2 border-success"> HABERLER
                                <div class="box-controls pull-right"><span
                                        class="badge badge-success">{{ $count_post }}</span></div>
                            </div>
                            <div class="bs-3 my-3 ps-3 py-2 border-warning"> FOTO GALERİLER
                                <div class="box-controls pull-right"><span
                                        class="badge badge-warning">{{ $count_photo_gallery }}</span></div>
                            </div>
                            <div class="bs-3 my-3 ps-3 py-2 border-danger"> VİDEO GALERİLER
                                <div class="box-controls pull-right"><span
                                        class="badge badge-danger">{{ $count_video_gallery }}</span></div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="col-xl-5 col-12 pb-3">
                    <div style="height: 100%" class="box m-0  d-flex flex-column">
                        <div class="box-body box-light py-0">
                            <div class="box-body">
                                <div class="d-flex flex-row align-items-center justify-content-center mb-2">
                                    <i class="fa fa-bullhorn fa-2x"></i>
                                    <h4 class="ms-2 my-0">BİLGİLENDİRME</h4>
                                </div>

                                @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('information.json'))
                                    @php
                                        $information = \Illuminate\Support\Facades\Storage::disk('public')->json(
                                            'information.json',
                                        );

                                    @endphp
                                @else
                                  @php
                                    $information = [];
                                    @endphp
                                @endif
                                @if (!empty($information) && isset($information[0]))
                                    {!! $information[0]['message'] !!}
                                @else
                                    <p class="text-center">

                                        Bilgilendirme yok
                                    </p>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12 pb-3">
                    <div style="height: 100%" class="box m-0  d-flex flex-column">
                        <div class="box-header no-border pb-0">
                            <h4 class="box-title">KATEGORİ/HABER ORANI</h4>
                        </div>
                        <div class="">

                            <div id="analytics_chartC"></div>
                            <div class="news-count-today">
                                <h4 class="text-center mt-3">Bugün Girilen Haber</h4>
                                <h2 class="text-center text-primary font-weight-bold">{{ $todayNewsCount ?? 15 }}</h2>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-12  pb-3">
                    <div style="height: 100%" class="box m-0  d-flex flex-column">

                        <style>
                            .ggg td {
                                font-size: 12px !important;
                            }
                        </style>
                        <div class="box-body no-padding" id="ggg">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>TESPİT</th>
                                            <th>DURUM</th>
                                        </tr>
                                        @php
                                            $false =
                                                '<td style="padding: 7px;"><span class="badge badge-pill badge-danger">KONTROL</span></td>';
                                            $true =
                                                '<td style="padding: 7px;"><span class="badge badge-pill badge-success">HARİKA</span></td>';
                                        @endphp
                                        <tr>
                                            <td style="padding: 7px;">SİTE BAŞLIĞI</td>
                                            @if (isset($jsondata->title) and $jsondata->title != null)
                                                {!! $true !!}
                                            @else
                                                {!! $false !!}
                                            @endif
                                        </tr>
                                        <tr>
                                            <td style="padding: 7px;">SİTE AÇIKLAMASI</td>
                                            @if (isset($jsondata->description) and $jsondata->description != null)
                                                {!! $true !!}
                                            @else
                                                {!! $false !!}
                                            @endif
                                        </tr>
                                        <tr>
                                            <td style="padding: 7px;">SİTE LOGO</td>
                                            @if (isset($settings['logo']) and $settings['logo'] != null)
                                                {!! $true !!}
                                            @else
                                                {!! $false !!}
                                            @endif
                                        </tr>
                                        <tr>
                                            <td style="padding: 7px;">İLETİŞİM BİLGİSİ</td>
                                            @if (isset($jsondata->phone) and $jsondata->phone != null)
                                                {!! $true !!}
                                            @else
                                                {!! $false !!}
                                            @endif
                                        </tr>
                                        <tr>
                                            <td style="padding: 7px;">API SERVİSLERİ</td>
                                            @if (isset($jsondata->apiservicestatus) and $jsondata->apiservicestatus == 0)
                                                {!! $true !!}
                                            @else
                                                {!! $false !!}
                                            @endif
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                @include('backend.index_stats')
            </div>

            <div class="col-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title">Son Eklenenler</h4>
                        <ul class="box-controls pull-right">
                            <li class="dropdown">
                                <a href="{{ route('post.index') }}" class="btn btn-danger-light px-10 base-font">Tümünü
                                    Gör</a>
                            </li>
                        </ul>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <th>ID</th>
                                    <th>Başlık</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">İstatistikler</th>
                                    <th class="text-center">Seo</th>
                                    <th class="text-center">Oluşturma Tarihi</th>
                                    <th>Durumu</th>
                                    <th>İşlemler</th>
                                </tr>
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="max-width: 380px;"><a class="ceditable" data-name="title"
                                                data-type="text" data-pk="{{ $post->id }}"
                                                data-title="Değiştir">{{ $post->title }}</a>
                                        </td>
                                        <td class="text-center"><span class="badge badge-primary">
                                                @if ($post->category != null)
                                                    {{ $post->category->title }}
                                                @else
                                                    KATEGORİSİZ
                                                @endif
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-info btn-sm p-1 openModal"
                                                data-id="{{ $post->id }}"
                                                data-url="/{{ $post->category->slug }}/{{ $post->slug }}/{{ $post->id }}"
                                                data-title="{{ $post->title }}">
                                                <i data-feather="bar-chart"></i>
                                            </button>

                                        </td>
                                        <td class="text-center">
                                            @if (strlen($post->meta_title) < 58 or strlen($post->meta_description) < 150)
                                                <span class="badge badge-dot badge-danger" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Seo Uyumsuz"></span>
                                            @else
                                                <span class="badge badge-dot badge-success" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Seo Uyumlu"></span>
                                            @endif
                                        </td>
                                        {{-- <td class="text-center">{{ $post->hit }}</td> --}}
                                        <td class="text-center"><span class="text-muted"><i class="fa fa-clock-o"></i>
                                                {{ date('d.m.Y', strtotime($post->created_at)) }} </span>
                                        </td>
                                        <td>
                                            @if ($post->publish == 0)
                                                <span class="badge badge-success"> AKTİF </span>
                                            @else
                                                <span class="badge badge-secondary"> PASİF </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="clearfix">
                                                <a href="{{ route('post.edit', $post->id) }}" type="button"
                                                    class="waves-effect waves-light btn btn-secondary btn-sm pull-left"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Düzenle"><i
                                                        class="fa fa-pencil"></i></a>
                                                <a href="{{ route('post.destroy', $post->id) }}" type="button"
                                                    class="waves-effect waves-light btn btn-danger btn-sm pull-left ms-1"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Çöpe At"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        {{ $posts->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>


            {{--         @if (Auth::check() and Auth::user()->status == 1)
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Sistem Kayıtları</h4>
                            <ul class="box-controls pull-right">
                                <li class="dropdown">
                                    <a href="{{ route('activitylogs') }}"
                                        class="btn btn-danger-light px-10 base-font">Tümünü
                                        Gör</a>
                                </li>
                            </ul>
                        </div>

                        <div class="box-body no-padding">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th>İŞLEM</th>
                                        <th>MODÜL</th>
                                        <th>İŞLEM YAPAN</th>
                                        <th>İŞLEM DETAYI</th>
                                        <th>İŞLEM ZAMANI</th>
                                    </tr>

                                    @foreach ($activitylogs as $akey => $activitylog)
                                        <tr>
                                            <th scope="row">{{ $activitylog->id }}</th>
                                            <td>
                                                @if ($activitylog->event == 'deleted')
                                                    <span class="badge badge-danger">SİLME</span>
                                                @elseif($activitylog->event == 'created')
                                                    <span class="badge badge-success">OLUŞTURMA</span>
                                                @elseif($activitylog->event == 'updated')
                                                    <span class="badge badge-warning">GÜNCELLEME</span>
                                                @endif
                                            </td>
                                            <td>{{ $activitylog->subject_type }}</td>
                                            <td>{{ $activitylog->causer?->name ?? '--' }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary-light btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal{{ $activitylog->id }}">GÖRÜNTÜLE
                                                </button>
                                                <div class="modal fade" id="modal{{ $activitylog->id }}">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">{{ $activitylog->id }} Numaralı
                                                                    Sistem Kaydı</h4>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ $activitylog->properties }}</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal">KAPAT
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="text-muted"><i class="fa fa-clock-o"></i>
                                                    {{ date('d.m.Y H:i', strtotime($activitylog->created_at)) }}</span>
                                            </td>
                                        </tr>
                                        @if ($akey == 19)
                                            @break
                                        @endif
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif --}}
        </div>
    </section>
@endsection


@section('custom_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js">
    </script>

    <script src="{{ asset('backend/assets/vendor_plugins/iCheck/icheck.js') }}"></script>
    <script src="{{ asset('backend/js/pages/app-contact.js') }}"></script>
    <script src="{{ asset('backend/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>
    <!-- Slick Slider JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.fn.editable.defaults.mode = 'inline';
        $('.ceditable').editable({
            url: "{{ route('post.ajaxUpdate') }}",
            type: 'select',
            name: 'title',
            title: 'Değiştir',
            validate: function(value) {
                if ($.trim(value) == '') {
                    return 'Boş bırakılamaz.';
                }
            }
        });

        $(".allprocess").click(function() {
            var datatype = $(this).data("type");
            var array = [];
            $("input:checked").each(function() {
                array.push($(this).val());
                array = jQuery.grep(array, function(value) {
                    return value != "on";
                });
            });
            $.ajax({
                url: "{{ route('post.ajaxAllProcess') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    newsid: array,
                    processtype: datatype
                },
                success: function(response) {
                    if (response === "ok") {
                        location.reload();
                    }
                },
                error: function(response) {},
            });
        });


        var options = {

            @if (empty($series) || $series == 'no')
                series: [0],
                labels: ["Bulunamadı"],
                colors: ['#7367F0'],
            @else
                series: [{!! str_replace("'", '', $series) !!}],
                labels: [{!! $labels !!}],
                colors: ['#7367F0', '#EA5455', '#3799fb', '#5ec870'],
            @endif


            chart: {
                width: 250,
                type: 'donut',
            },
            dataLabels: {
                enabled: false
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        show: false
                    }
                }
            }],
            legend: {
                show: false
            }
        };

        var chart = new ApexCharts(document.querySelector("#analytics_chartC"), options);
        chart.render();
    </script>
    <script>
        $(document).ready(function() {
            $('.slider').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                arrows: true,
                dots: false,
                prevArrow: '<button type="button" class="index-slick-prev index-custom-arrow text-white"><i class="fa fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="index-slick-next index-custom-arrow text-white"><i class="fa fa-chevron-right"></i></button>',
                responsive: [{
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 1
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".slider-btn").on('click', function() {
                let title = $(this).data('title');
                let message = $(this).data('message');



                $(".modal-title").text(title)
                $(".modal-message").html(message)

            })
        })
    </script>
@endsection
