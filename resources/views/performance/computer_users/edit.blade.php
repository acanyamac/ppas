@extends('layouts.master')

@section('title', 'Kullanıcı Düzenle')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Kullanıcı Düzenle</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">                                       
                        <svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('computer-users.index') }}">Kullanıcılar</a></li>
                    <li class="breadcrumb-item active">Düzenle</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Kullanıcı Bilgileri</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('computer-users.update', $user->id) }}" method="POST" class="theme-form">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="col-form-label pt-0" for="username">Kullanıcı Adı (Sistem)</label>
                            <input class="form-control" id="username" type="text" value="{{ $user->username }}" disabled>
                            <small class="text-muted">Bu alan değiştirilemez.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="col-form-label pt-0" for="motherboard_uuid">Anakart UUID</label>
                            <input class="form-control" id="motherboard_uuid" type="text" value="{{ $user->motherboard_uuid }}" disabled>
                            <small class="text-muted">Bu alan değiştirilemez.</small>
                        </div>

                        <div class="mb-3">
                            <label class="col-form-label pt-0" for="name">Ad Soyad / Görünen İsim</label>
                            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" value="{{ old('name', $user->name) }}" placeholder="Kullanıcının adı soyadı">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="col-form-label pt-0" for="unit_id">Birim</label>
                            <select class="form-select @error('unit_id') is-invalid @enderror" id="unit_id" name="unit_id">
                                <option value="">Birim Seçiniz</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" {{ old('unit_id', $user->unit_id) == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('unit_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Kullanıcının bağlı olduğu birim. Keyword sınıflandırmaları bu birime göre değişebilir.</small>
                        </div>

                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Güncelle</button>
                            <a href="{{ route('computer-users.index') }}" class="btn btn-light">İptal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
