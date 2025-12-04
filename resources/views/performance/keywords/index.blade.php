@extends('layouts.master')

@section('title', 'Keyword Yönetimi')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Keyword Yönetimi</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Performance Agent</li>
    <li class="breadcrumb-item active">Keyword'ler</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Keyword Listesi</h5>
                        <div>
                            <a href="{{ route('keywords.test') }}" class="btn btn-info me-2">
                                <i class="fa fa-flask"></i> Keyword Test
                            </a>
                            <a href="{{ route('keywords.import') }}" class="btn btn-success me-2">
                                <i class="fa fa-upload"></i> Toplu İçe Aktar
                            </a>
                            <a href="{{ route('keywords.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Yeni Keyword
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover" id="keywordsTable">
                            <thead>
                                <tr>
                                    <th>Keyword</th>
                                    <th>Kategori</th>
                                    <th>Eşleşme Tipi</th>
                                    <th>Öncelik</th>
                                    <th>Case Sensitive</th>
                                    <th>Durum</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($keywords as $keyword)
                                <tr>
                                    <td><code>{{ $keyword->keyword }}</code></td>
                                    <td>
                                        <span class="badge bg-primary">{{ $keyword->category->name }}</span>
                                    </td>
                                    <td>
                                        @switch($keyword->match_type)
                                            @case('exact')
                                                <span class="badge bg-success">Tam Eşleşme</span>
                                                @break
                                            @case('contains')
                                                <span class="badge bg-info">İçeriyor</span>
                                                @break
                                            @case('starts_with')
                                                <span class="badge bg-warning">Başlıyor</span>
                                                @break
                                            @case('ends_with')
                                                <span class="badge bg-warning">Bitiyor</span>
                                                @break
                                            @case('regex')
                                                <span class="badge bg-danger">Regex</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" role="progressbar" 
                                                 style="width: {{ $keyword->priority * 10 }}%"
                                                 aria-valuenow="{{ $keyword->priority }}" 
                                                 aria-valuemin="0" aria-valuemax="10">
                                                {{ $keyword->priority }}/10
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($keyword->is_case_sensitive)
                                            <span class="badge bg-info">Evet</span>
                                        @else
                                            <span class="badge bg-secondary">Hayır</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($keyword->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Pasif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('keywords.edit', $keyword->id) }}" 
                                               class="btn btn-sm btn-warning" title="Düzenle">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('keywords.destroy', $keyword->id) }}" 
                                                  method="POST" style="display:inline;"
                                                  onsubmit="return confirm('Bu keyword\'ü silmek istediğinizden emin misiniz?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Sil">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
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
        $('#keywordsTable').DataTable({
            "pageLength": 25,
            "order": [[3, 'desc']], // Priority'ye göre sırala
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Turkish.json"
            }
        });
    });
</script>
@endsection
