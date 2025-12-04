@extends('layouts.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">

@endsection

@section('breadcrumb-title')
    <h3>Kullanıcılar</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Kullanıcı İşlemleri</li>
    <li class="breadcrumb-item active">Kullanıcılar</li>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Kullanıcılar</h3>
                        <a href="{{route('kullanicilar.create')}}" class="btn btn-primary" data-bs-original-title="" title=""><i class="icon-plus"></i> Kullanıcı Ekle</a>
                    </div>

                    <div class="card-body">

                        
                        @if ($message = session('message'))
                            <div class="alert alert-success">{{ $message }}</div>
                        @endif


                        <div class="table-responsive">
                            <table class="display" id="informationReceivedPersonnels-dt">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Rolü</th>
                                        <th>Adı Soyadı</th>
                                        <th>E-Posta</th>
                                        <th>Birimi</th>
                                        <th>Ünvanı</th>
                                        <th>İletişim</th>
                                        <th>İşlemler</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($users->count())

                                        @foreach ($users as $key => $user)
                                            {{-- {{ dd($user->roles) }} --}}

                                           
                                                @if ($user->roles[0]->name != 'Super Admin')
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ isset($user->roles[0]) ? $user->roles[0]->name : '' }}</td>
                                                        <td>{{ $user->name }} {{ $user->last_name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ isset($user->details) ? $user->details->unit->name : '' }}</td>


                                                        <td>{{ isset($user->details) ? $user->details->title->name : '' }}</td>
                                                        <td>{{ isset($user->details) ? $user->details->phone : '' }}</td>

                                                        <td>
                                                            <ul class="action">
                                                                <li class="edit">
                                                                    <a href="{{ route('kullanicilar.edit', $user->id) }}"
                                                                        class="btn btn-sm"><i
                                                                            class="icon-pencil-alt"></i></a>

                                                                </li>
                                                                <li class="delete">
                                                                    <form id="form-delete"
                                                                        action="{{ route('kullanicilar.destroy', $user->id) }}"
                                                                        method="POST" style="display: inline"
                                                                        onsubmit="return confirm('Emin misiniz?')">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="btn btn-sm"><i
                                                                                class="icon-trash"></i></button>
                                                                    </form>
                                                                </li>

                                                            </ul>
                                                        </td>
                                                    </tr>
                                                @endif
                                         
                                        @endforeach



                                    @endif


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Zero Configuration  Ends-->

        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/js/informationReceivedPersonnels-dt.js') }}"></script>


@endsection
