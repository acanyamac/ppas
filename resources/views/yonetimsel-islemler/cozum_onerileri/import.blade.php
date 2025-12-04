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
    <li class="breadcrumb-item active">İçe Aktar</li>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Çözüm Önerilerini İçeri Aktar</h3>

                    </div>
                    <div class="card-body">


                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if (session('conflicts') && is_array(session('conflicts')))
                            @foreach (session('conflicts') as $conflict)
                                <div class="alert alert-info">
                                    <strong>Var Olan Kayıt:</strong><br>
                                    <strong>Tedbir:</strong> {{ $conflict['precaution_id'] }}<br>
                                    <strong>Eski İçerik:</strong> {{ $conflict['old_content'] }}<br>
                                    <strong>Yeni İçerik:</strong> {{ $conflict['new_content'] }}
                                </div>
                            @endforeach
                        @endif


                        <form method="POST" id="upload_form" action="{{ route('import.solutions') }}"
                            enctype="multipart/form-data">

                            @csrf

                            <!-- File input-->
                            <div class="mb-3 row">

                                <div class="col-lg-12">


                                    <input class="form-control" type="file" id="csv_file" name="csv_file" accept=".csv"
                                        required>

                                </div>
                            </div>

                            <div class="mb-3 row">

                                <div class="col-lg-12">
                                    <button id="btnUpload" type="submit" name="btnUpload"
                                        class="btn btn-primary">Yükle</button>

                                </div>
                            </div>

                            <input type="hidden" id="precaution" name="precaution" />


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
