@extends('layouts.master')
@section('title', 'Kullanıcı Güncelle')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Kullanıcı Güncelle</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Mevcut kullanıcı bilgilerini düzenleyin</p>
    </div>
@endsection

@section('breadcrumb-items')
    <li class="flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
        <a href="{{ route('kullanicilar.index') }}" class="text-primary-600 hover:text-primary-700">Kullanıcı İşlemleri</a>
    </li>
    <li class="flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
        <span class="text-gray-600 dark:text-gray-400">Kullanıcı Güncelle</span>
    </li>
@endsection

@section('content')
<div class="card">
    <div class="card-header border-b border-gray-200 dark:border-gray-700">
        <h5 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <i class="fas fa-user-edit text-primary-500"></i>
            Kullanıcı Güncelle
        </h5>
    </div>

    <div class="card-body">
        <form action="{{ route('kullanicilar.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Unit -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="unit_id">Birimi</label>
                    <select id="unit_id" name="unit_id" class="form-select block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}" @selected($user->details->unit->id == $unit->id)>
                                {{ $unit->parent ? $unit->parent->name . ' / ' : '' }}{{ $unit->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="title_id">Ünvan</label>
                    <select id="title_id" name="title_id" class="form-select block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        @foreach ($titles as $title)
                            <option value="{{ $title->id }}" @selected($user->details->title && $user->details->title->id == $title->id)>
                                {{ $title->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Role -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="role_id">Rolü</label>
                    <select id="role_id" name="role_id" class="form-select block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500">
                        @foreach ($roles as $role)
                            @if ($role->name != 'Super Admin')
                                <option value="{{ $role->id }}" @selected($user->hasRole($role->name))>
                                    {{ $role->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="name">Kullanıcı Adı</label>
                    <input id="name" name="name" type="text" value="{{ $user->name }}"
                        class="form-input block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="last_name">Kullanıcı Soyadı</label>
                    <input id="last_name" name="last_name" type="text" value="{{ $user->last_name }}"
                        class="form-input block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('last_name') border-red-500 @enderror">
                    @error('last_name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="email">E-Posta</label>
                    <input id="email" name="email" type="email" value="{{ $user->email }}"
                        class="form-input block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="phone">İletişim</label>
                    <input id="phone" name="phone" type="text" value="{{ $user->details->phone }}"
                        class="form-input block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="password">Şifre (Değiştirmek için doldurun)</label>
                    <input id="password" name="password" type="password"
                        class="form-input block w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <a href="{{ route('kullanicilar.index') }}" class="btn btn-secondary">Vazgeç</a>
                <button type="submit" class="btn btn-primary">Güncelle</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')

@endsection
