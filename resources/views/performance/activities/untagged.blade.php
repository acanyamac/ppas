@extends('layouts.master')

@section('title', 'Taglenmemiş Aktiviteler')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Taglenmemiş Aktiviteler</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Performance Agent</li>
    <li class="breadcrumb-item"><a href="{{ route('activities.index') }}">Aktiviteler</a></li>
    <li class="breadcrumb-item active">Taglenmemiş</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Taglenmemiş Aktiviteler</h5>
                        <div>
                            <a href="{{ route('activities.index') }}" class="btn btn-secondary">
                                <i class="fa fa-list"></i> Tümü
                            </a>
                            <a href="{{ route('activities.tagged') }}" class="btn btn-success">
                                <i class="fa fa-check-circle"></i> Taglenmiş
                            </a>
                            <a href="{{ route('activities.auto-tag') }}" class="btn btn-primary">
                                <i class="fa fa-magic"></i> Otomatik Tagleme
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($activities->total() > 0)
                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle"></i> 
                            <strong>{{ number_format($activities->total()) }}</strong> aktivite henüz taglenmemiş. 
                            <a href="{{ route('activities.auto-tag') }}" class="alert-link">Otomatik tagleme başlatın</a>
                        </div>
                    @else
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle"></i> Tüm aktiviteler taglenmiş durumda!
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover" id="untaggedActivitiesTable">
                            <thead>
                                <tr>
                                    <th>Process Name</th>
                                    <th>Başlık</th>
                                    <th>URL</th>
                                    <th>Süre</th>
                                    <th>Başlangıç Zamanı</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activities as $activity)
                                <tr>
                                    <td><code>{{ Str::limit($activity->process_name, 30) }}</code></td>
                                    <td>{{ Str::limit($activity->title, 50) }}</td>
                                    <td>
                                        @if($activity->url)
                                            <small class="text-muted">{{ Str::limit($activity->url, 40) }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $activity->duration_formatted }}</td>
                                    <td data-order="{{ $activity->start_time_utc->timestamp }}">
                                        {{ $activity->start_time_utc->format('d.m.Y H:i:s') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#untaggedActivitiesTable').DataTable({
            "pageLength": 50,
            "order": [[4, 'desc']], // Başlangıç zamanına göre sırala
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Turkish.json"
            }
        });
    });
</script>
@endsection
