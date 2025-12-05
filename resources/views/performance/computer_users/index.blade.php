@extends('layouts.master')

@section('title', 'Bilgisayar Kullanıcıları')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <h3>Bilgisayar Kullanıcıları</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Performance Agent</li>
    <li class="breadcrumb-item active">Kullanıcılar</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Kullanıcı Listesi</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="usersTable">
                            <thead>
                                <tr>
                                    <th>Kullanıcı Adı (Sistem)</th>
                                    <th>Görünen İsim</th>
                                    <th>Anakart ID</th>
                                    <th>Aktivite Sayısı</th>
                                    <th>Son Güncelleme</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td><code>{{ $user->username }}</code></td>
                                    <td>
                                        @if($user->name)
                                            <span class="badge bg-primary">{{ $user->name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td><small>{{ Str::limit($user->motherboard_uuid, 20) }}</small></td>
                                    <td>{{ number_format($user->activities_count) }}</td>
                                    <td>{{ $user->updated_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('computer-users.show', $user->id) }}" class="btn btn-xs btn-info" title="İstatistikler">
                                            <i class="fa fa-bar-chart"></i>
                                        </a>
                                        <button type="button" class="btn btn-xs btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}" title="Düzenle">
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Kullanıcı Düzenle</h5>
                                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('computer-users.update', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Sistem Kullanıcı Adı</label>
                                                                <input class="form-control" type="text" value="{{ $user->username }}" disabled>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Anakart ID</label>
                                                                <input class="form-control" type="text" value="{{ $user->motherboard_uuid }}" disabled>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Görünen İsim (Alias)</label>
                                                                <input class="form-control" type="text" name="name" value="{{ $user->name }}" placeholder="Örn: Ahmet Yılmaz">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">İptal</button>
                                                            <button class="btn btn-primary" type="submit">Kaydet</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
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
        $('#usersTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json"
            }
        });
    });
</script>
@endsection
