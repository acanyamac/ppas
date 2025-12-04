@extends('layouts.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')


@endsection

@section('breadcrumb-title')
    <h3>Roller</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Rol İşlemleri</li>
    <li class="breadcrumb-item active">Rol İzinleri</li>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Role izin ekle</h3>
                    </div>



                    <div class="card-body">
                        @if ($message = session('message'))
                            <div class="alert alert-success">{{ $message }}</div>
                        @endif
                        <form class="form-horizontal" action="{{ route('roller.store') }}" method="POST">
                            @csrf


                            <!-- Select Basic -->
                            <div class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="role_id">Roller</label>
                                <div class="col-lg-12">
                                    <select id="role_id" name="role_id" class="form-control btn-square">
                                        @if ($roles->count())
                                            <option value="" disabled selected>Lütfen bir rol seçiniz.</option>
                                            @foreach ($roles as $key => $role)
                                                {{-- @selected(old('role_id') == $role->id) --}}
                                                @if ($role->name != 'Super Admin')
                                                    <option value="{{ $role->id }}">
                                                        {{ $role->name }}</option>
                                                @endif
                                            @endforeach

                                        @endif


                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">

                                <div class="col-sm-4 tabs-responsive-side">
                                    <div class="nav flex-column nav-pills border-tab nav-left" id="v-pills-tab"
                                        role="tablist" aria-orientation="vertical">

                                        @foreach ($menus as $key => $menu)
                                            @if ($menu->parent_id == 0)
                                                <a class="nav-link" id="v-pills-{{ $menu->id }}-tab"
                                                    data-bs-toggle="pill" href="#v-pills-{{ $menu->id }}" role="tab"
                                                    aria-controls="v-pills-{{ $menu->id }}"
                                                    aria-selected="{{ $key == 0 ? 'true' : 'false' }}">
                                                    {{ $menu->name }}
                                                </a>
                                            @endif
                                        @endforeach




                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="tab-content" id="v-pills-tabContent">

                                        {{-- @foreach ($menus as $menu)
                                            @if ($menu->parent_id == 0)
                                                <div class="tab-pane fade show" id="v-pills-{{$menu->id}}" role="tabpanel"
                                                    aria-labelledby="v-pills-{{$menu->id}}-tab">
                                            @endif

                                            @foreach ($subMenus as $subMenu)
                                            
                                                @if ($subMenu->parent_id == $menu->id)
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="switchCheck{{$subMenu->id}}" data="{{$subMenu->name}}" name="{{$subMenu->name}}">
                                                        <label class="form-check-label" for="switchCheck{{$subMenu->id}}">{{$subMenu->name}}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                            

                                            @if ($menu->parent_id == 0)
                                                </div>
                                            @endif
                                        @endforeach --}}


                                        @foreach ($menus as $menu)
                                            @if ($menu->parent_id == 0)
                                                <div class="tab-pane fade show" id="v-pills-{{ $menu->id }}"
                                                    role="tabpanel" aria-labelledby="v-pills-{{ $menu->id }}-tab">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="selectAll{{ $menu->id }}" data-select-all="true"
                                                            data-parent-id="{{ $menu->id }}">
                                                        <label class="form-check-label"
                                                            for="selectAll{{ $menu->id }}">Tümünü Seç</label>
                                                    </div>

                                                    @foreach ($subMenus as $subMenu)
                                                        @if ($subMenu->parent_id == $menu->id)
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox"
                                                                    role="switch" id="switchCheck{{ $subMenu->id }}"
                                                                    data="{{ $subMenu->name }}"
                                                                    name="{{ $subMenu->name }}">
                                                                <label class="form-check-label"
                                                                    for="switchCheck{{ $subMenu->id }}">{{ $subMenu->name }}</label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach





                                    </div>

                                </div>



                            </div>




                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary">Kaydet</button>
                                <a href="{{ route('roller.index') }}" class="btn btn-secondary">Vazgeç</a>
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
