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

                    </div>
                    <div class="card-body">


                        @if (isset($message))
                            <div class="alert alert-success">{{ $message }}</div>
                        @elseif (session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        <form class="form-horizontal"
                            action="{{ route('cozum-onerileri.update', $precaution->id) }}" method="POST">
                            @csrf
                            @method('PUT')


                            <div class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="textarea">
                                    <b>{{ $precaution->precaution_no}} {{$precaution->name}}</b></label>
                                <div class="col-lg-12">
                                    <textarea class="form-control btn-square input-md @error('name') is-invalid @enderror" id="solution_suggestion"
                                        name="solution_suggestion">{{ $precaution->solution_suggestion }}</textarea>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror


                                </div>
                            </div>

                            <div class="form-group mb-3">

                                  
                                <button id="btnKaydet" type="submit" name="btnKaydet"
                                    class="btn btn-primary">Güncelle</button>
                           

                            
                                <a href="{{route('cozum-onerileri.index')}}"
                                    class="btn btn-secondary">Vazgeç</a>
                          
                        </div>

                        </form>

                    </div>


                </div>
            </div>
            <!-- Zero Configuration  Ends-->

        </div>
    </div>
@endsection

@section('script')


    <script src="{{ asset('assets/js/custom.js') }}"></script>

@endsection
