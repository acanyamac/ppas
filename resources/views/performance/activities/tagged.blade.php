@extends('layouts.master')

@section('title', 'Taglenmiş Aktiviteler')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Taglenmiş Aktiviteler</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Performance Agent</li>
    <li class="breadcrumb-item"><a href="{{ route('activities.index') }}">Aktiviteler</a></li>
    <li class="breadcrumb-item active">Taglenmiş</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Taglenmiş Aktiviteler</h5>
                        <div>
                            <a href="{{ route('activities.index') }}" class="btn btn-secondary">
                                <i class="fa fa-list"></i> Tümü
                            </a>
                            <a href="{{ route('activities.untagged') }}" class="btn btn-warning">
                                <i class="fa fa-exclamation-circle"></i> Taglenmemiş
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="taggedActivitiesTable">
                            <thead>
                                <tr>
                                    <th>Process Name</th>
                                    <th>Başlık</th>
                                    <th>Kategoriler</th>
                                    <th>Güven Skoru</th>
                                    <th>Tagleme Tipi</th>
                                    <th>Süre</th>
                                    <th>Başlangıç Zamanı</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activities as $activity)
                                <tr>
                                    <td><code>{{ Str::limit($activity->process_name, 25) }}</code></td>
                                    <td>{{ Str::limit($activity->title, 40) }}</td>
                                    <td>
                                        @foreach($activity->categories as $category)
                                            <span class="badge bg-primary" title="{{ $category->pivot->matched_keyword ?? '' }}">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @php
                                            $avgScore = $activity->categories->avg('pivot.confidence_score') ?? 0;
                                        @endphp
                                        <span class="badge 
                                            @if($avgScore >= 80) bg-success
                                            @elseif($avgScore >= 60) bg-info
                                            @elseif($avgScore >= 40) bg-warning
                                            @else bg-secondary
                                            @endif">
                                            {{ number_format($avgScore, 0) }}%
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $isManual = $activity->categories->first()?->pivot->is_manual ?? false;
                                        @endphp
                                        @if($isManual)
                                            <span class="badge bg-info"><i class="fa fa-hand-pointer"></i> Manuel</span>
                                        @else
                                            <span class="badge bg-success"><i class="fa fa-magic"></i> Otomatik</span>
                                        @endif
                                    </td>
                                    <td>{{ $activity->duration_formatted }}</td>
                                    <td data-order="{{ $activity->start_time_utc->timestamp }}">
                                        {{ $activity->start_time_utc->format('d.m.Y H:i') }}
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
        $('#taggedActivitiesTable').DataTable({
            "pageLength": 50,
            "order": [[6, 'desc']], // Başlangıç zamanına göre sırala
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Turkish.json"
            },
            "columnDefs": [
                { "orderable": false, "targets": [2, 3, 4] }
            ]
        });
    });
</script>
@endsection
