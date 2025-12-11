@extends('layouts.authentication.master')
@section('title', 'Giriş Ekranı')

@section('css')
@endsection

@section('style')
@endsection

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-md w-full">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="{{ route('/') }}" class="inline-block">
                <img class="h-16 w-auto mx-auto" src="{{asset('assets/images/logo/logo.png')}}" alt="Perfas">
            </a>
            <h2 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">Perfas'a Hoşgeldiniz</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Devam etmek için lütfen giriş yapınız</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">
            <form class="space-y-6 needs-validation" action="{{route('login')}}" method="POST" novalidate>
                @csrf
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">E-Posta Adresi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition-colors @error('email') border-red-500 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                            placeholder="ornek@email.com" 
                            value="{{old('email')}}">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{$message}}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Şifre</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" name="password" type="password" required 
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition-colors @error('password') border-red-500 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{$message}}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" value="true" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded cursor-pointer">
                        <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300 cursor-pointer">Beni Hatırla</label>
                    </div>

                    <div class="text-sm">
                        <a href="{{route('password.request')}}" class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">
                            Şifremi Unuttum?
                        </a>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all transform hover:scale-[1.02]">
                        Giriş Yap
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Footer Info -->
        <p class="mt-8 text-center text-xs text-gray-500 dark:text-gray-400">
            &copy; {{ date('Y') }} Perfas. Tüm hakları saklıdır.
        </p>
    </div>
</div>
@endsection

@section('script')
@endsection