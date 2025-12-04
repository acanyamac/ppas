@extends('layouts.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')


@endsection

@section('breadcrumb-title')
    <h3>Çözüm Önerileri</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Çözüm Önerileri</li>
    <li class="breadcrumb-item active">Ekle</li>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Çözüm Önerisi Ekle</h3>

                    </div>



                    <div class="card-body">

                        <form class="form-horizontal" action="{{ route('cozum-onerileri.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-2">
                                <label>Tedbir Ana Başlığı</label>
                                <select class="form-control @error('precaution_main_title_id') is-invalid @enderror"
                                    id="precaution_main_title_id">
                                    <option value="0" selected>Seçiniz</option>

                                    @foreach ($precautionMainTitles as $precautionMainTitle)
                                        <option value="{{ $precautionMainTitle->id }}">{{ $precautionMainTitle->title_no }}
                                            {{ $precautionMainTitle->name }}</option>
                                    @endforeach


                                </select>
                                @error('precaution_main_title_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div id="precaution_title" class="form-group mb-2">
                                <label>Tedbir Alt Başlığı</label>
                                <select class="form-control @error('parent_id') is-invalid @enderror" name="parent_id"
                                    id="parent_id">
                                    <option value="0" disabled selected>Seçiniz</option>


                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div id="precaution" class="form-group mb-2">
                                <label>Tedbirler</label>
                                <select class="form-control @error('precaution_id') is-invalid @enderror"
                                    name="precaution_id" id="precaution_id">
                                    <option value="0" disabled selected>Seçiniz</option>


                                </select>
                                @error('precaution_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Text input-->
                            <div id="solution_suggestion_ta" class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="textarea">Çözüm Önerisi</label>
                                <div class="col-lg-12">
                                    <textarea class="form-control btn-square input-md @error('name') is-invalid @enderror" id="solution_suggestion"
                                        name="solution_suggestion">
  
                                    </textarea>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror


                                </div>
                            </div>


                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary">Kaydet</button>
                                <a href="{{ route('cozum-onerileri.index') }}" class="btn btn-secondary">Vazgeç</a>
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
