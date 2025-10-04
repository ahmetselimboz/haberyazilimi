@extends('backend.layout')

@section('title', 'Eklenti Mağazası')

@section('custom_css')
  
@endsection 

@section('content')
 @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('plugins_market.json'))
    @php 
        $plugins = \Illuminate\Support\Facades\Storage::disk('public')->json('plugins_market.json'); 

    @endphp
    
@else
    $plugins = [];
@endif

<div class="modal fade" id="pluginModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content rounded-3">
            <div class="modal-header bg-info">
                <h4  class="text-center m-2 modal-title" ></h4>
                <button type="button" id="close-model" class="btn-close text-white" data-bs-dismiss="modal"
                    aria-label="Kapat"></button>
            </div>
            <hr class="mt-0">
            <div>
                <div class="modal-body">
                    </div>
                <div class="mb-2 px-4">
                        <small class="text-muted">
                            <strong>Versiyon:</strong> <span class="modal-version"></span><br>
                             <strong>Yazar:</strong> <span  class="modal-author"></span><br>
                             <strong>Oluşturulma Tarihi:</strong> <span  class="modal-date"></span>
                        </small>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary py-1 my-0 " data-bs-dismiss="modal">Kapat</button>
                  
                    <a href="http://musteri.medyayazilimlari.com" class="btn btn-sm py-1 btn-info d-flex align-items-center" target="_blank">
                        <i data-feather="shopping-cart" class="me-2" style="width: 20px"></i>
                        Satın Al
                    </a>
                </div>

        </div>
    </div>
</div>
<section class="content">
        <div class="row">
            <div class="col-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title">Eklenti Mağazası</h4>
                        <div class="box-controls pull-right">
                            <div class="btn-group">
                                <a href="{{ route('plugins.index') }}" type="button" class="btn btn-success btn-sm"><i class="fa fa-puzzle-piece me-1"></i>Mevcut Eklentiler</a>
                               
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="table-responsive mx-2">
                            <table class="table table-hover">
                                <tr>
                                       <th>Adı</th>
                                    <!--<th>Başlık</th>-->
                                    <th>Açıklama</th>
                                 
                                    <th>Eklenti Yazarı</th>
                                    <th>Version</th>
                                    <th>Oluşturulma Tarihi</th>
                                    <th>Detayları Gör</th>
                                </tr>
                                @foreach($plugins as $plugin)
                                    <tr>
                                        <!--<td><span class="text-muted">{{ $plugin['name'] }}</span></td>-->
                                        <td>{{ $plugin['name'] }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($plugin['description'])), 40) }}</td>

                                 
                                        <td><span class="text-muted">{{ $plugin['author'] }}</span></td>
                                        <td><span class="text-muted">{{ $plugin['version'] }}</span></td>
                                        <td><span class="text-muted">{{ $plugin['created_at_formatted'] }}</span></td>
                                    
                                        <td>
                                                <button class="btn btn-primary btn-sm  box-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#pluginModal"
                                                    data-title="{{ $plugin['name'] }}"
                                                    data-body="{{ $plugin['description'] }}"
                                                    data-version="{{ $plugin['version'] }}"
                                                    data-author="{{ $plugin['author'] }}"
                                                    data-date="{{ $plugin['created_at_formatted'] }}"
                                                >
                                                    <i class="fa fa-eye"></i> Detayları Gör
                                                </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                     
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>

@endsection

@section('custom_js')
<script>
      $(document).ready(function () {
          $(".box-btn").on('click', function () {
               let title = $(this).data('title');
               let  body = $(this).data('body');
                let version = $(this).data('version');
                let author = $(this).data('author');
                let date = $(this).data('date');
                
                $(".modal-title").text(title)
                $(".modal-body").html(body)
                 $(".modal-version").text(version)
                 $(".modal-author").text(author)
                 $(".modal-date").text(date)
          })
      })
</script>
@endsection 