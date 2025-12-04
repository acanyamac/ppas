@extends('layouts.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">

@endsection

@section('breadcrumb-title')
<h3>Ünvanlar</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Ünvan İşlemleri</li>
<li class="breadcrumb-item active">Ünvanlar</li>
@endsection

@section('content')


<div class="container-fluid">
    <div class="row">
        <!-- Zero Configuration  Starts-->
        <div class="col-sm-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Tüm Ünvanlar</h3>
                    <a href="{{route('unvan.create')}}" class="btn btn-primary" data-bs-original-title="" title=""><i class="icon-plus"></i> Ünvan Ekle</a>
                </div>

                
                
                <div class="card-body">
                    @if ($message = session('message'))
                    <div class="alert alert-success">{{$message}}</div>
                    @endif
                    
                    
                    <div class="table-responsive">
                        <table class="display" id="general-datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ünvan</th>
                                    <th></th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @if ($titles->count())

                                    @foreach ($titles as $key=>$title)

                                   

                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$title->name}}</td>
                                            <td>
                                                <ul class="action">
                                                    <li class="edit"> 
                                                        <a href="{{route('unvan.edit',$title->id)}}" class="btn btn-sm"><i class="icon-pencil-alt"></i></a>
                                                        {{-- <button class="btn btn-sm"><i class="icon-icon-pencil-alt"></i></button> --}}
                                                    </li>
                                                    <li class="delete">
                                                        <form id="form-delete" action="{{route('unvan.destroy',$title->id)}}" method="POST" style="display: inline" onsubmit="return confirm('Emin misiniz?')">  
                                                            @csrf
                                                            @method('delete')
                                                            <button class="btn btn-sm"><i class="icon-trash"></i></button>
                                                        </form>
                                                    </li>
                                                    
                                                </ul>
                                            </td>
                                        </tr>
                                        
                                    @endforeach

                                    
                                    
                                @endif
                               
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Zero Configuration  Ends-->
     
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('assets/js/general-datatable.js') }}"></script>


@endsection