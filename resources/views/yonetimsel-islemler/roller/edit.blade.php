@extends('layouts.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')


@endsection

@section('breadcrumb-title')
    <h3>Roller</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Rol İşlemleri</li>
    <li class="breadcrumb-item active">Rol Güncelle</li>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Rol Güncelle</h3>
                    </div>

                    <div class="card-body">

                        <form class="form-horizontal" action="{{route('roller.update', $roller->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Text input-->
                            <div class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="name">Rol Adı</label>
                                <div class="col-lg-12">
                                    <input id="name" name="name" type="text" value=" {{ $roller->name }} "
                                        class="form-control btn-square input-md @error('name') is-invalid @enderror">

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>



                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary">Güncelle</button>
                                <a href="{{ route('roller.index') }}" class="btn btn-secondary">Vazgeç</a>
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
