@extends('backend.layout')

@section('title')
    Log Detayı - {{ $filename }}
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
            max-width: 500px;
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
        .breadcrumb-item a {
            color: #007bff;
            text-decoration: none;
        }
        .breadcrumb-item a:hover {
            text-decoration: underline;
        }
    </style>
@endsection

@section('content')
<section class="content">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('logs') }}">Log Dosyaları</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $filename }}</li>
                </ol>
            </nav>

            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">{{ $filename }} - Log Kayıtları</h4>
                    <ul class="box-controls pull-right">
                        <li>
                            <span class="badge badge-info">Toplam {{ $paginatedLogs->total() }} kayıt</span>
                        </li>
                        <li>
                            <a href="{{ route('logs') }}" class="btn btn-sm btn-secondary">
                                <i class="fa fa-arrow-left"></i> Geri Dön
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="box-body">
                    @if($paginatedLogs->isEmpty())
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Bu dosyada henüz log kaydı bulunmamaktadır.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="150">Tarih/Saat</th>
                                        <th width="100">Seviye</th>
                                        <th>Mesaj</th>
                                        <th width="100">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paginatedLogs->items() as $log)
                                    <tr>
                                        <td class="log-timestamp">{{ $log['timestamp'] }}</td>
                                        <td>
                                            <span class="badge log-level-{{ $log['level'] }}">
                                                {{ $log['level'] }}
                                            </span>
                                        </td>
                                        <td class="log-message">{{ $log['message'] }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#logModal{{ $loop->index }}">
                                                <i class="fa fa-eye"></i> Detay
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Sayfalama -->
                        <div class="d-flex justify-content-center mt-3">
                            {!! $paginatedLogs->links() !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal'lar -->
@foreach($paginatedLogs->items() as $log)
<div class="modal fade" id="logModal{{ $loop->index }}" tabindex="-1" aria-labelledby="logModalLabel{{ $loop->index }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logModalLabel{{ $loop->index }}">
                    Log Detayı - {{ $log['timestamp'] }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>Seviye:</strong> 
                    <span class="badge log-level-{{ $log['level'] }}">{{ $log['level'] }}</span>
                </div>
                <div class="mb-3">
                    <strong>Tarih/Saat:</strong> {{ $log['timestamp'] }}
                </div>
                <div class="mb-3">
                    <strong>Dosya:</strong> {{ $filename }}
                </div>
                <div class="mb-3">
                    <strong>Tam İçerik:</strong>
                    <div class="log-full-content">{{ $log['full_content'] }}</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>
@endforeach

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