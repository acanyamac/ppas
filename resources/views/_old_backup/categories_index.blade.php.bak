@extends('layouts.master')

@section('title', 'Kategoriler')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Kategoriler</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Performance Agent</li>
    <li class="breadcrumb-item active">Kategoriler</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Kategori Listesi</h5>
                        <a href="{{ route('categories.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Yeni Kategori
                        </a>
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
                        <table class="table table-hover" id="categoriesTable">
                            <thead>
                                <tr>
                                    <th>Kategori Adı</th>
                                    <th>Tip</th>
                                    <th>Parent</th>
                                    <th>Level</th>
                                    <th>Keyword Sayısı</th>
                                    <th>Durum</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>
                                        @if($category->icon)
                                            <i class="fa {{ $category->icon }}"></i>
                                        @endif
                                        <strong>{{ $category->name }}</strong>
                                        @if($category->color)
                                            <span class="badge" style="background-color: {{ $category->color }}">{{ $category->color }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($category->type == 'work')
                                            <span class="badge bg-primary">İş</span>
                                        @else
                                            <span class="badge bg-secondary">Diğer</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->parent ? $category->parent->name : '-' }}</td>
                                    <td><span class="badge bg-info">Level {{ $category->level }}</span></td>
                                    <td>
                                        <span class="badge bg-success">{{ $category->keywords->count() }}</span>
                                    </td>
                                    <td>
                                        @if($category->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Pasif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('categories.show', $category->id) }}" 
                                               class="btn btn-sm btn-info" title="Detay">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('categories.edit', $category->id) }}" 
                                               class="btn btn-sm btn-warning" title="Düzenle">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('categories.destroy', $category->id) }}" 
                                                  method="POST" style="display:inline;"
                                                  onsubmit="return confirm('Bu kategoriyi silmek istediğinizden emin misiniz?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Sil">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @if(isset($category->children_tree) && $category->children_tree->count() > 0)
                                    @foreach($category->children_tree as $child)
                                    <tr>
                                        <td class="ps-4">
                                            <i class="fa fa-level-up fa-rotate-90"></i>
                                            @if($child->icon)
                                                <i class="fa {{ $child->icon }}"></i>
                                            @endif
                                            {{ $child->name }}
                                            @if($child->color)
                                                <span class="badge" style="background-color: {{ $child->color }}">{{ $child->color }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($child->type == 'work')
                                                <span class="badge bg-primary">İş</span>
                                            @else
                                                <span class="badge bg-secondary">Diğer</span>
                                            @endif
                                        </td>
                                        <td>{{ $child->parent->name }}</td>
                                        <td><span class="badge bg-info">Level {{ $child->level }}</span></td>
                                        <td>
                                            <span class="badge bg-success">{{ $child->keywords->count() }}</span>
                                        </td>
                                        <td>
                                            @if($child->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Pasif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('categories.show', $child->id) }}" 
                                                   class="btn btn-sm btn-info" title="Detay">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('categories.edit', $child->id) }}" 
                                                   class="btn btn-sm btn-warning" title="Düzenle">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('categories.destroy', $child->id) }}" 
                                                      method="POST" style="display:inline;"
                                                      onsubmit="return confirm('Bu kategoriyi silmek istediğinizden emin misiniz?');">
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
                                @endif
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
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#categoriesTable').DataTable({
            "pageLength": 25,
            "order": [[3, 'asc']], // Level'a göre sırala
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Turkish.json"
            }
        });
    });
</script>
@endsection
