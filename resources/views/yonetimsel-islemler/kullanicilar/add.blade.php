@extends('layouts.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')


@endsection

@section('breadcrumb-title')
    <h3>Kullanıcılar</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Kullanıcı İşlemleri</li>
    <li class="breadcrumb-item active">Kullanıcı Ekle</li>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Yeni Kullanıcı Ekle</h3>
                    </div>


                    <div class="card-body">

                        <form class="form-horizontal" action="{{ route('kullanicilar.store') }}" method="POST">
                            @csrf

                            <!-- Select Basic -->
                            <div class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="unit_id">Birimi</label>
                                <div class="col-lg-12">
                                    <select id="unit_id" name="unit_id" class="form-control btn-square">
                                        @if ($units->count())

                                            @foreach ($units as $key => $unit)
                                                <option value="{{ $unit->id }}" @selected(old('unit_id') == $unit->id)>
                                                    {{ $unit->whereId($unit->parent_id)->first()->name }} /
                                                    {{ $unit->name }}
                                                </option>
                                            @endforeach

                                        @endif


                                    </select>
                                </div>
                            </div>

                            <!-- Select Basic -->
                            <div class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="title_id">Ünvan</label>
                                <div class="col-lg-12">
                                    <select id="title_id" name="title_id"
                                        class="form-control btn-square @error('title_id') is-invalid @enderror">
                                        @if ($titles->count())

                                            @foreach ($titles as $key => $title)
                                                <option value="{{ $title->id }}" @selected(old('title_id') == $title->id)>
                                                    {{ $title->name }}</option>
                                            @endforeach

                                        @endif


                                    </select>
                                </div>
                            </div>

                            <!-- Select Basic -->
                            <div class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="role_id">Rolü</label>
                                <div class="col-lg-12">
                                    <select id="role_id" name="role_id" class="form-control btn-square">
                                        @if ($roles->count())

                                            @foreach ($roles as $key => $role)
                                                @if ($role->name != 'Super Admin')
                                                    <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>
                                                        {{ $role->name }}</option>
                                                @endif
                                            @endforeach

                                        @endif


                                    </select>
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="name">Kullanıcı Adı</label>
                                <div class="col-lg-12">
                                    <input id="name" name="name" type="text" value=" {{ old('name') }}"
                                        class="form-control btn-square input-md @error('name') is-invalid @enderror">

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="last_name">Kullanıcı Soyadı</label>
                                <div class="col-lg-12">
                                    <input id="last_name" name="last_name" type="text" value=" {{ old('last_name') }}"
                                        class="form-control
                                        btn-square input-md @error('last_name') is-invalid @enderror">
                                    @error('last_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="mail">E-Posta</label>
                                <div class="col-lg-12">
                                    <input id="mail" name="mail" type="text" value=" {{ old('mail') }}"
                                        class="form-control
                                        btn-square input-md @error('mail') is-invalid @enderror">
                                    @error('mail')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="phone">Telefon</label>
                                <div class="col-lg-12">
                                    <input id="phone" name="phone" type="text" value=" {{ old('phone') }}"
                                        class="form-control btn-square input-md @error('phone') is-invalid @enderror">
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="textinput">Şifre</label>
                                <div class="col-lg-12">
                                    <input id="password" name="password" type="password"
                                        class="form-control btn-square input-md @error('password') is-invalid @enderror">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary">Kaydet</button>
                                <a href="{{ route('kullanicilar.index') }}" class="btn btn-secondary">Vazgeç</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
            <!-- Zero Configuration  Ends-->

        </div>
    </div>
@endsection

@section('script')


    <script src="{{ asset('assets/js/custom.js') }}"></script>


@endsection
