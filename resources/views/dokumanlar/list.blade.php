@extends('layouts.master')
@section('title', 'Sample Page')

@section('css')

@endsection

@section('style')


@endsection

@section('breadcrumb-title')
    <h3>Doküman Listesi</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Doküman Listesi</li>
    <li class="breadcrumb-item active">Doküman Listesi</li>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Doküman Listesi</h3>
                    </div>


                    <div class="card-body">
                        <div class="table-responsive" id="dokuman_tablo">

                        </div>
                    </div>
                </div>
            </div>
            <!-- Zero Configuration  Ends-->

        </div>
    </div>
@include('dokumanlar.modals.revision_modal');
    @include('dokumanlar.modals.update_filename');

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('dokumanlar.js.js');
@endsection
