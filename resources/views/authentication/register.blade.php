@extends('layouts.authentication.master')
@section('title', 'Sign-up-one')

@section('css')
@endsection

@section('style')
@endsection

@section('content')
<div class="container-fluid p-0">
   <div class="row m-0">
      <div class="col-xl-5"><img class="bg-img-cover bg-center" src="{{asset('assets/images/login/3.jpg')}}" alt="looginpage"></div>
      <div class="col-xl-7 p-0">
         <div class="login-card">
            <div>
               <div><a class="logo" href="{{ route('/') }}"><img class="img-fluid for-light" src="{{asset('assets/images/logo/login.png')}}" alt="looginpage"><img class="img-fluid for-dark" src="{{asset('assets/images/logo/logo_dark.png')}}" alt="looginpage"></a></div>
               <div class="login-main">
                  <form action="{{route('register')}}" method="POST" class="theme-form">
                     @csrf
                     <h4>Hesabınızı oluşturun</h4>
                     <p>Kayıt oluşturmak için lütfen bilgileri doldurun</p>
                     <div class="form-group">
                        <div class="row g-2">
                           <div class="col-6">
                              <label class="col-form-label pt-0">Adınız</label>
                              <input class="form-control @error('firstName') is-invalid @enderror" type="text" name="firstName" value="{{old('firstName')}}">
                              @error('firstName')
                              <div class="invalid-feedback">{{$message}}</div>
                              @enderror
                           </div>
                           <div class="col-6">
                              <label class="col-form-label pt-0">Soyadınız</label>
                              <input class="form-control @error('lastName') is-invalid @enderror" type="text" name="lastName" value="{{old('lastName')}}">
                              @error('lastName')
                              <div class="invalid-feedback">{{$message}}</div>
                              @enderror
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-form-label">E-Mail</label>
                        <input class="form-control @error('email') is-invalid @enderror" type="email"   name="email" value="{{old('email')}}" placeholder="Test@gmail.com">
                              @error('email')
                              <div class="invalid-feedback">{{$message}}</div>
                              @enderror
                     </div>
                     <div class="form-group">
                        <label class="col-form-label">Şifre</label>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" value="{{old('password')}}" placeholder="*********">
                              @error('password')
                              <div class="invalid-feedback">{{$message}}</div>
                              @enderror
                        <div class="show-hide"><span class="show"></span></div>
                     </div>
                     <div class="form-group">
                        <label class="col-form-label">Şifre tekrar </label>
                        <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" value="{{old('password_confirmation')}}" placeholder="*********">
                              @error('password_confirmation')
                              <div class="invalid-feedback">{{$message}}</div>
                              @enderror
                        <div class="show-hide"><span class="show"></span></div>
                     </div>
                     <div class="form-group mb-0">
                        <div class="checkbox p-0">
                           <input id="checkbox1" type="checkbox">
                           <label class="text-muted" for="checkbox1">Agree with<a class="ms-2" href="#">Privacy Policy</a></label>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">Create Account</button>
                     </div>
                     <h6 class="text-muted mt-4 or">Or signup with</h6>
                     <div class="social mt-4">
                        <div class="btn-showcase"><a class="btn btn-light" href="https://www.linkedin.com/login" target="_blank"><i class="txt-linkedin" data-feather="linkedin"></i> LinkedIn </a><a class="btn btn-light" href="https://twitter.com/login?lang=en" target="_blank"><i class="txt-twitter" data-feather="twitter"></i>twitter</a><a class="btn btn-light" href="https://www.facebook.com/" target="_blank"><i class="txt-fb" data-feather="facebook"></i>facebook</a></div>
                     </div>
                     <p class="mt-4 mb-0">Zaten bir hesabım var?<a class="ms-2" href="{{ route('login') }}">Sign in</a></p>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
@endsection