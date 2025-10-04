@extends('backend.layout')

@section('title')
    Sistem Logları
@endsection

@section('custom_css')
    <style>
        .log-level-ERROR {
            background-color: #dc3545 !important;
            color: white !important;
        }
        .log-level-WARNING {
            background-color: #ffc107 !important;
            color: black !important;
        }
        .log-level-INFO {
            background-color: #17a2b8 !important;
            color: white !important;
        }
        .log-level-DEBUG {
            background-color: #6c757d !important;
            color: white !important;
        }
        .log-entry {
            font-family: 'Courier New', monospace;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .log-timestamp {
            font-weight: bold;
        }
        .log-message {
            max-width: 600px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .log-full-content {
            white-space: pre-wrap;
            word-wrap: break-word;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
    </style>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Sistem Log Dosyaları</h4>
                    <ul class="box-controls pull-right">
                        <li>
                            <span class="badge badge-info">{{ count($logFileInfo) }} dosya</span>
                        </li>
                    </ul>
                </div>

                <div class="box-body">
                    @if(empty($logFileInfo))
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Henüz log dosyası bulunmamaktadır.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Dosya Adı</th>
                                        <th>Boyut</th>
                                        <th>Son Güncelleme</th>
                                        <th>Tahmini Log Sayısı</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logFileInfo as $file)
                                    <tr>
                                        <td>
                                            <strong>{{ $file['filename'] }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $file['filepath'] }}</small>
                                        </td>
                                        <td>
                                            <span class="badge {{ $file['size'] > 50*1024*1024 ? 'badge-danger' : ($file['size'] > 10*1024*1024 ? 'badge-warning' : 'badge-success') }}">
                                                {{ $file['size_human'] }}
                                            </span>
                                        </td>
                                        <td>{{ $file['last_modified_human'] }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ number_format($file['log_count']) }} kayıt</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('log.detail', $file['filename']) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-eye"></i> İncele
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>



@endsection

@section('custom_js')
<script>
    $(document).ready(function() {
        // Tooltip'leri aktif et
        $('[data-bs-toggle="tooltip"]').tooltip();
        
        // Modal'ları düzgün çalışır hale getir
        $('.modal').on('shown.bs.modal', function () {
            $(this).find('.modal-body').scrollTop(0);
        });
    });
</script>
@endsection 