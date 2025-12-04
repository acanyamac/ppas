@extends('layouts.master')
@section('title', 'Sample Page')

@section('css')

@endsection

@section('style')


@endsection

@section('breadcrumb-title')
    <h3>Doküman Yükleme</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Doküman Yükleme İşlemleri</li>
    <li class="breadcrumb-item active">Doküman Yükleme</li>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Doküman Yükleme</h3>
                    </div>


                    <div class="card-body">



                        <form class="form-horizontal" action="{{ route('dokuman.insert') }}"  enctype="multipart/form-data"  method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label>Doküman Türü:</label>
                            @if(count($categories)>0)
                                <select class="form-control" name="file_category">
                                    <option value="0">Seçiniz</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->text}}</option>
                                        @endforeach
                                </select>
                                @endif
                                <div class="p-2 text-danger">
                                    @if(isset($errors->messages()["file_category"]) && count($errors->messages()["file_category"])>0)
                                        @foreach($errors->messages()["file_category"] as $m)
                                            <small>* {{$m}}</small>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label>Doküman Adı:</label>
                                <input type="text" class="form-control" name="file_name" id="file_name">
                                <div class="p-2 text-danger">
                                    @if(isset($errors->messages()["file_name"]) && count($errors->messages()["file_name"])>0)
                                        @foreach($errors->messages()["file_name"] as $m)
                                            <small>* {{$m}}</small>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label>Doküman Seçiniz</label>
                                <input type="file" class="form-control" name="file" id="file">
                                <div class="p-2 text-danger">
                                    @if(isset($errors->messages()["file"]) && count($errors->messages()["file"])>0)
                                        @foreach($errors->messages()["file"] as $m)
                                            <small>* {{$m}}</small>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" name="save" class="btn btn-primary">KAYDET</button>
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

            @if(isset($sonuc))
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    Swal.fire({
                        title: "Başarılı",
                        text: "{{$sonuc}}",
                        icon: "success"
                    });
                </script>

    @endif



@endsection
