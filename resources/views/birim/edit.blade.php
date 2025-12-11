@extends('layouts.master')
@section('title', 'Birim Güncelle')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Birim Güncelle</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Birim bilgilerini düzenleyin</p>
    </div>
@endsection

@section('breadcrumb-items')
    <li class="flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
        <a href="{{ route('birim.index') }}" class="text-primary-600 hover:text-primary-700">Birim İşlemleri</a>
    </li>
    <li class="flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
        <span class="text-gray-600 dark:text-gray-400">Birim Güncelle</span>
    </li>
@endsection

@section('content')
<div class="card">
    <div class="card-header border-b border-gray-200 dark:border-gray-700">
        <h5 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <i class="fas fa-edit text-primary-500"></i>
            Birimi Güncelle
        </h5>
    </div>

    <div class="card-body">
        <form action="{{ route('birim.update', $unit->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Parent Unit -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="parent_id">Bağlı Olduğu Birim</label>
                    <select id="parent_id" name="parent_id" class="form-select block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        @foreach ($units as $item)
                            <option value="{{ $item->id }}" @selected($item->id === old('parent_id', $unit->parent_id))>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Unit Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="name">Birim Adı</label>
                    <input id="name" name="name" type="text" value="{{ $unit->name }}"
                        class="form-input block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex items-center justify-end gap-3">
                <a href="{{ route('birim.index') }}" class="btn btn-secondary">Vazgeç</a>
                <button type="submit" class="btn btn-primary">Güncelle</button>
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
<h3>Birimler</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Birim İşlemleri</li>
<li class="breadcrumb-item active">Birim Güncelle</li>
@endsection

@section('content')


<div class="container-fluid">
    <div class="row">
        <!-- Zero Configuration  Starts-->
        <div class="col-sm-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Birimi Güncelle</h3>
                </div>
                
                
                <div class="card-body">
                    
                    <form class="form-horizontal" action="{{route('birim.update',$unit->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <fieldset>
                        
                        <!-- Select Basic -->
                        <div class="mb-3 row">
                          <label class="col-lg-12 form-label text-lg-start" for="selectbasic">Bağlı Olduğu Birim</label>
                          <div class="col-lg-12">
                            
                            <select id="parent_id" name="parent_id" class="form-control btn-square">
                                @if ($units->count())

                               
                                    @foreach ($units as $key=>$item)

                                   
                                    
                                      <option {{$item->id===old('parent_id',$unit->parent_id) ? 'selected' : ''}} value="{{$item->id}}">{{$item->name}}</option>    

                                        
                                      

                                    @endforeach

                                @endif

                              
                            </select>
                          </div>
                        </div>
                        
                        <!-- Text input-->
                        <div class="mb-3 row">
                          <label class="col-lg-12 form-label text-lg-start" for="textinput">Birim Adı</label>  
                          <div class="col-lg-12">
                          <input id="name" name="name" type="text" class="form-control btn-square input-md" value="{{$unit->name}}">
                          
                          </div>
                        </div>
                        
                        <!-- Button -->
                        <div class="mb-3 row">
                          
                          <div class="col-lg-12">
                            <button id="btnKaydet" type="submit" name="btnKaydet" class="btn btn-primary">Güncelle</button>
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