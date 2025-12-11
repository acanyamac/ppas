@extends('layouts.master')
@section('title', 'Yeni Ünvan Ekle')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Yeni Ünvan Ekle</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Sisteme yeni bir ünvan tanımlayın</p>
    </div>
@endsection

@section('breadcrumb-items')
    <li class="flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
        <a href="{{ route('unvan.index') }}" class="text-primary-600 hover:text-primary-700">Ünvan İşlemleri</a>
    </li>
    <li class="flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
        <span class="text-gray-600 dark:text-gray-400">Ünvan Ekle</span>
    </li>
@endsection

@section('content')
<div class="card">
    <div class="card-header border-b border-gray-200 dark:border-gray-700">
        <h5 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <i class="fas fa-plus-circle text-primary-500"></i>
            Ünvan Ekle
        </h5>
    </div>

    <div class="card-body">
        <form action="{{ route('unvan.store') }}" method="POST" class="max-w-xl">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="name">Ünvan Adı</label>
                <input id="name" name="name" type="text" 
                    class="form-input block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('unvan.index') }}" class="btn btn-secondary">Vazgeç</a>
                <button type="submit" class="btn btn-primary">Kaydet</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
@endsection
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