@extends('layouts.authentication.master')
@section('title', 'Giriş Ekranı')

@section('css')
@endsection

@section('style')
@endsection

@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-12 p-0">
         <div class="login-card">
            <div>
               <div class="text-center mb-4">
                  <a class="logo" href="{{ route('/') }}">
                     <img class="img-fluid" src="{{asset('assets/images/logo/logo.png')}}" alt="Perfas" style="max-height: 80px;">
                  </a>
               </div>
               <div class="login-main">
                  <form class="theme-form" action="{{route('login')}}" method="POST">
                     @csrf
                     <h4>Perfas'a Hoşgeldiniz</h4>
                     <p>Devam etmek için giriş yapınız</p>
                     <div class="form-group">
                        <label class="col-form-label">E-Mail</label>
                        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{old('email')}}" placeholder="ornek@email.com">
                              @error('email')
                              <div class="invalid-feedback">{{$message}}</div>
                              @enderror
                     </div>
                     <div class="form-group">
                        <label class="col-form-label">Şifre</label>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" value="{{old('password')}}">
                              @error('password')
                              <div class="invalid-feedback">{{$message}}</div>
                              @enderror
                        <div class="show-hide"><span class="show"></span></div>
                     </div>
                     <div class="form-group mb-0">
                        <div class="checkbox p-0">
                           <input id="checkbox1" type="checkbox" name="remember" value="true">
                           <label class="text-muted" for="checkbox1">Beni Hatırla</label>
                           <a class="ms-2" href="{{route("password.request")}}">Şifremi unuttum</a>

                        </div>
                        <button class="btn btn-primary btn-block" type="submit">Giriş Yap</button>
                     </div>
                    
                     {{-- <p class="mt-4 mb-0"><a class="ms-2" href="{{route("register")}}">Hesap Oluşturun</a></p> --}}
                     <script>
                        (function() {
                        'use strict';
                        window.addEventListener('load', function() {
                        // Fetch all the forms we want to apply custom Bootstrap validation styles to
                        var forms = document.getElementsByClassName('needs-validation');
                        // Loop over them and prevent submission
                        var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                        }, false);
                        });
                        }, false);
                        })();
                        
                     </script>
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