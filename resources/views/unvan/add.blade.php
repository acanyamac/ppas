@extends('layouts.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')


@endsection

@section('breadcrumb-title')
<h3>ünvanlar</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Ünvan İşlemleri</li>
<li class="breadcrumb-item active">Ünvan Ekle</li>
@endsection

@section('content')


<div class="container-fluid">
    <div class="row">
        <!-- Zero Configuration  Starts-->
        <div class="col-sm-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Yeni Ünvan Ekle</h3>
                </div>
                
                
                <div class="card-body">
                    
                    <form class="form-horizontal" action="{{route('unvan.store')}}" method="POST">
                        @csrf
                        <fieldset>
                        
                        <!-- Text input-->
                        <div class="mb-3 row">
                          <label class="col-lg-12 form-label text-lg-start" for="textinput">Ünvan</label>  
                          <div class="col-lg-12">
                          <input id="name" name="name" type="text" class="form-control btn-square input-md @error('name') is-invalid @enderror">
                          @error('name')
                          <div class="invalid-feedback">
                           {{$message}}
                          </div>
                          @enderror
                          
                          </div>
                        </div>
                        
                        <!-- Button -->
                        <div class="mb-3 row">
                          
                          <div class="col-lg-12">
                            <button id="btnKaydet" type="submit" name="btnKaydet" class="btn btn-primary">Kaydet</button>
                          </div>
                        </div>
                        
                        </fieldset>
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