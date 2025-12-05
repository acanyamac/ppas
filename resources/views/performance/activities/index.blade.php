@extends('layouts.master')

@section('title', 'Aktiviteler')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Tüm Aktiviteler</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Performance Agent</li>
    <li class="breadcrumb-item active">Aktiviteler</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Aktivite Listesi</h5>
                        <div>
                            <a href="{{ route('activities.untagged') }}" class="btn btn-warning">
                                <i class="fa fa-exclamation-circle"></i> Taglenmemiş
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
                    <!-- Filtreler -->
                    <form method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <select name="category_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">Tüm Kategoriler</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover" id="basic-1">
                            <thead>
                                <tr>
                                    <th>Kullanıcı</th>
                                    <th>Process Name</th>
                                    <th>Başlık</th>
                                    <th>Kategoriler</th>
                                    <th>Başlangıç Zamanı</th>
                                    <th>Süre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activities as $activity)
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $activity->username }}</span>
                                    </td>
                                    <td><code>{{ Str::limit($activity->process_name, 30) }}</code></td>
                                    <td>{{ Str::limit($activity->title, 50) }}</td>
                                    <td>
                                        @forelse($activity->categories as $category)
                                            <span class="badge bg-primary">{{ $category->name }}</span>
                                        @empty
                                            <span class="badge bg-secondary">Taglenmemiş</span>
                                        @endforelse
                                    </td>
                                    <td><small>{{ $activity->start_time_utc->format('d.m.Y H:i:s') }}</small></td>
                                    <td>
                                        {{ $activity->duration_formatted }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Aktivite bulunamadı</td>
                                </tr>
                                @endforelse
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
            $('#basic-1').DataTable({
                "pageLength": 50,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json"
                }
            });
        });
    </script>
@endsection
