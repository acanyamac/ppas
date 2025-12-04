@extends('layouts.master')
@section('title', 'Sample Page')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/buttons.dataTables.min.css') }}">
@endsection

@section('style')


@endsection

@section('breadcrumb-title')
    <h3>Çözüm Önerileri</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Çözüm Önerileri</li>
    <li class="breadcrumb-item active">Listele</li>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Çözüm Önerileri</h3>
                        <div class="ml-auto">
                            <a href="{{ route('cozum-onerileri.create') }}" class="btn btn-primary" data-bs-original-title="" title="">
                                <i class="icon-plus"></i> Ekle
                            </a>
                            <a href="{{ route('export.solutions') }}" class="btn btn-primary" data-bs-original-title="" title="">
                                <i class="icon-export"></i> Dışa Aktar
                            </a>
                          
                        </div>
                    </div>
                    <div class="card-body">


                        @if (isset($message))
                            <div class="alert alert-success">{{ $message }}</div>
                        @elseif (session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        <div class="table-responsive">




                            @if (isset($precautions))
                                <table class="display" id="solution-suggestions-dt">
                                    <thead>

                                        <tr>
                                            <th>#</th>

                                            <th>Tedbir</th>

                                            <th style="width: 30%">Çözüm Önerileri</th>

                                            <th>İşlemler</th>

                                        </tr>

                                    </thead>
                                    <tbody>


                                        @foreach ($precautions as $key => $value)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value->precaution_no }} {{ $value->name }}</td>
                                                <td>{{ $value->solution_suggestion }}</td>
                                                <td>

                                                    <ul class="action d-flex align-items-center">
                                                        <li class="edit">
                                                            <a href="{{ route('cozum-onerileri.edit', $value->id) }}"
                                                                title="Güncelle" class="btn btn-sm"><i
                                                                    class="icon-pencil-alt"></i></a>

                                                        </li>
                                                        {{-- <li class="delete">
                                                            <form id="form-delete"
                                                                action="{{ route('tedbirler.destroy', $value->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('delete')
                                                                <button class="btn btn-sm" type="submit" title="Sil"><i
                                                                        class="icon-trash"></i></button>
                                                            </form>
                                                        </li> --}}

                                                    </ul>


                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            @endif



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


<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/js/solution-suggestions-dt.js') }}"></script>

@endsection
