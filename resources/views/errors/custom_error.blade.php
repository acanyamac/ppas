@extends('layouts.errors.master')
@section('title', 'Hata')

@section('css')
@endsection

@section('style')
@endsection


@section('content')

<div class="page-wrapper compact-wrapper" id="pageWrapper">
<!-- error-400 start-->
   <div class="error-wrapper">
        <div class="container"><img class="img-100" src="{{ asset('assets/images/other-images/sad.png') }}" alt="">
               <div class="error-heading">
                  <h2 class="headline font-info">Hata</h2>
               </div>
               <div class="col-md-8 offset-md-2">
                  <p class="sub-content">{{$error}}</p>
                  <p class="sub-content">Lütfen program yöneteciniz ile irtibata geçin</p>
               </div>
               <div><a class="btn btn-info-gradien btn-lg" href="{{ route('/')}}">Ana Sayfaya Dön</a></div>
        </div>
   </div>
<!-- error-400 end-->
</div>
@endsection

@section('script')

@endsection