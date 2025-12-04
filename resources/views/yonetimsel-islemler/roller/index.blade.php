@extends('layouts.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">

@endsection

@section('breadcrumb-title')
    <h3>Roller</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Rol İşlemleri</li>
    <li class="breadcrumb-item active">Rol Ekle</li>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body">

                        

                        <form class="form-horizontal" action="{{ route('roller.storeRole') }}" method="POST">
                            @csrf

                            <!-- Text input-->
                            <div class="row mb-3">
                                <label class="col-lg-12 form-label text-lg-start" for="name">Rol Adı</label>
                                <div class="col-lg-12">
                                    <input id="name" name="name" type="text" value=""
                                        class="form-control btn-square input-md @error('name') is-invalid @enderror">

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary">Rol Ekle</button>
                                
                            </div>

                        </form>

                        <div class="row mb3">
                            @if ($message = session('message'))
                        <div class="alert alert-success">{{$message}}</div>
                        @endif
                            <div class="table-responsive">
                                <table class="display" id="general-datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Rol</th>
                                            <th>İşlemler</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($roles->count())

                                            @foreach ($roles as $key => $role)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $role->name}}</td>
                                                    <td>
                                                        <ul class="action">
                                                            <li class="edit">
                                                                <a href="{{ route('roller.edit', $role->id) }}"
                                                                    class="btn btn-sm"><i class="icon-pencil-alt"></i></a>

                                                            </li>
                                                            <li class="delete">
                                                                <form id="form-delete"
                                                                    action="{{ route('roller.destroy', $role->id) }}"
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
                                            @endforeach



                                        @endif


                                    </tbody>
                                </table>
                            </div>
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
    <script src="{{ asset('assets/js/general-datatable.js') }}"></script>


@endsection
