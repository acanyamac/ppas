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
    <li class="breadcrumb-item active">Kullanıcı Güncelle</li>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Kullanıcı Güncelle</h3>
                    </div>

                    <div class="card-body">

                        <form class="form-horizontal" action="{{ route('kullanicilar.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Select Basic -->
                            <div class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="unit_id">Birimi</label>
                                <div class="col-lg-12">

                                    @foreach ($units as $key => $unit)
                                        {{-- {{dd($unit);}} --}}
                                    @endforeach
                                    <select id="unit_id" name="unit_id" class="form-control btn-square">
                                        @if ($units->count())



                                            @foreach ($units as $key => $unit)
                                                <option value="{{ $unit->id }}" @selected($user->details->unit->id == $unit->id)>
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
                                    <select id="title_id" name="title_id" class="form-control btn-square">
                                        @if ($titles->count())

                                            @foreach ($titles as $key => $title)
                                                <option value="{{ $title->id }}" @selected($user->details->title->id == $title->id)>
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
                                                        <option value="{{ $role->id }}" @selected($user->hasRole($role->name))>
                                                            {{ $role->name }}</option>
                                                    @endif
                                                @endforeach
                                            @endif


                                        </select>
                                    </div>
                           


                            <!-- Text input-->
                            <div class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="name">Kullanıcı Adı</label>
                                <div class="col-lg-12">
                                    <input id="name" name="name" type="text" value=" {{ $user->name }} "
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
                                    <input id="last_name" name="last_name" type="text" value=" {{ $user->last_name }}"
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
                                <label class="col-lg-12 form-label text-lg-start" for="email">E-Posta</label>
                                <div class="col-lg-12">
                                    <input id="email" name="email" type="text" value="{{ $user->email }}"
                                        class="form-control
                                            btn-square input-md @error('email') is-invalid @enderror">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="phone">İletişim</label>
                                <div class="col-lg-12">
                                    <input id="phone" name="phone" type="text" value="{{ $user->details->phone }}"
                                        class="form-control btn-square input-md @error('mail') is-invalid @enderror">
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
                                <button type="submit" class="btn btn-primary">Güncelle</button>
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

@endsection
