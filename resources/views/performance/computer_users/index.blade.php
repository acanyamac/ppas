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
                                    <th>Birim</th>
                                    <th>Anakart ID</th>
                                    <th>Toplam Süre (Saat)</th>
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
                                    <td>
                                        @if($user->unit)
                                            <span class="badge bg-secondary">{{ $user->unit->name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td><small>{{ Str::limit($user->motherboard_uuid, 20) }}</small></td>
                                    <td>{{ number_format(($user->activities_sum_duration_ms ?? 0) / (1000 * 60 * 60), 2) }}</td>
                                    <td>{{ $user->updated_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('computer-users.show', $user->id) }}" class="btn btn-xs btn-info" title="İstatistikler">
                                            <i class="fa fa-bar-chart"></i>
                                        </a>
                                        <a href="{{ route('computer-users.edit', $user->id) }}" class="btn btn-xs btn-primary" title="Düzenle">
                                            <i class="fa fa-edit"></i>
                                        </a>
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
