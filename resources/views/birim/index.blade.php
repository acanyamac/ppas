@extends('layouts.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">

@endsection

@section('breadcrumb-title')
    <h3>Birimler</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Birim İşlemleri</li>
    <li class="breadcrumb-item active">Birimler</li>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Tüm Birimler</h3>
                        <a href="{{ route('birim.create') }}" class="btn btn-primary" data-bs-original-title=""
                            title=""><i class="icon-plus"></i> Birim Ekle</a>
                    </div>



                    <div class="card-body">
                        @if ($message = session('message'))
                            <div class="alert alert-success">{{ $message }}</div>
                        @elseif($message = session('error'))
                            <div class="alert alert-danger">{{ $message }}</div>
                        @endif


                        <div class="table-responsive">
                            <table class="display" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Bağlı olduğu birim</th>
                                        <th>Birim</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($units->count())

                                        @foreach ($units as $key => $unit)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $unit->parentUnit ? $unit->parentUnit->name : 'Merkez' }}</td>
                                                <td>{{ $unit->name }}</td>
                                                <td>
                                                    @if ($unit->id != 1)
                                                        <ul class="action">
                                                            <li class="edit">
                                                                <a href="{{ route('birim.edit', $unit->id) }}"
                                                                    class="btn btn-sm"><i class="icon-pencil-alt"></i></a>
                                                                {{-- <button class="btn btn-sm"><i class="icon-icon-pencil-alt"></i></button> --}}
                                                            </li>
                                                            <li class="delete">
                                                                <form id="form-delete"
                                                                    action="{{ route('birim.destroy', $unit->id) }}"
                                                                    method="POST" style="display: inline"
                                                                    onsubmit="return confirm('Emin misiniz?')">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button class="btn btn-sm"><i
                                                                            class="icon-trash"></i></button>
                                                                </form>
                                                            </li>

                                                        </ul>
                                                    @endif
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
            <!-- Zero Configuration  Ends-->

        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>

@endsection
