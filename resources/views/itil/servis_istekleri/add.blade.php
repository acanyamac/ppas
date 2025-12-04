@extends('layouts.master')
@section('title', 'Sample Page')

@section('css')

@endsection

@section('style')


@endsection

@section('breadcrumb-title')
    <h3>Servis İstekleri</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Servis İstekleri</li>
    <li class="breadcrumb-item active">Yeni Servis Talep</li>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Servis Talebi Oluştur</h3>
                    </div>


                    <div class="card-body">

                        <form class="form-horizontal" action="{{ route('service_requests.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf



                            <div class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="service_id">Servisler</label>
                                <div class="col-lg-12">
                                    <select class="form-control" name="service_id" id="service_id">

                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach

                                    </select>
                                </div>

                            </div>

                            <div class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="service_type">İstek
                                    Tipleri</label>
                                <div class="col-lg-12">
                                    <select class="form-control" name="service_type" id="service_type">


                                        <option value="1">Talep</option>
                                        <option value="2">Olay</option>
                                        <option value="3">Siber Güvenlik</option>
                                        <option value="4">Geri Bildirim</option>


                                    </select>
                                </div>

                            </div>


                            <!-- Text input-->
                            <div class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="title">Başlık</label>
                                <div class="col-lg-12">
                                    <input id="title" name="title" type="text"
                                        class="form-control btn-square input-md @error('title') is-invalid @enderror">
                                    @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label>Açıklama</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3"></textarea>
                                @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>

                            <div class="form-group mb-3">

                                <label>Seviye</label><br>
                                <input type="radio" name="level" value="1" @checked(true)>Level 1 &nbsp;
                                <input type="radio" name="level" value="2">Level 2 &nbsp;
                                <input type="radio" name="level" value="3">Level 3


                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">

                                        <!-- File input-->
                                        <div class="mb-3 row">

                                            <div class="col-lg-12">


                                                <input class="form-control" type="file" id="serviceRequestFiles"
                                                    name="serviceRequestFiles[]"
                                                    accept=".xlsx,.xls,.doc,.docx,.pdf, .jpeg, .jpg, .gif" multiple
                                                    required>

                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>


                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary">Kaydet</button>
                                <a href="#" class="btn btn-secondary">Vazgeç</a>
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


@endsection
