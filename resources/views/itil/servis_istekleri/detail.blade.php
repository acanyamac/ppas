@extends('layouts.master')
@section('title', 'Sample Page')

@section('css')

@endsection

@section('style')


@endsection

@section('breadcrumb-title')
    <h3>Servis İstekleri</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Servis İstekleri</li>
    <li class="breadcrumb-item active">Talepler</li>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Talebi Yanıtla</h3>
                    </div>


                    <div class="card-body">

                        <form class="form-horizontal"
                            action="{{ route('service-request-response.storeResponse', $serviceRequest->id) }}"
                            method="POST">
                            @csrf

                            <div class="mb-3 row">

                                @switch($serviceRequest->level)
                                    @case(1)
                                        <span class="badge badge-success p-3">Seviye 1</span>
                                    @break

                                    @case(2)
                                        <span class="badge badge-warning p-3">Seviye 2</span>
                                    @break

                                    @case(3)
                                        <span class="badge badge-danger p-3">Seviye 3</span>
                                    @break

                                    @default
                                @endswitch
                            </div>

                            <!-- Text input-->
                            <div class="mb-3 row">
                                <h5>{{ $serviceRequest->title }} - {{ $serviceRequest->updated_at }} </h5>
                                <p>{{ $serviceRequest->description }}</p>


                            </div>

                            @if ($serviceRequestResponses)

                           
                                @foreach ($serviceRequestResponses as $response)
                                <hr>
                                    <div class="mb-3 row">

                                        <p>{{ $response->response }}</p>
                                        <strong>Cevap Tarihi {{ $response->updated_at }} </strong>


                                    </div>
                                @endforeach
                                <!-- Text input-->

                            @endif



                            <div class="form-group mb-2">
                                <label>Yanıtınız</label>
                                <textarea class="form-control @error('response') is-invalid @enderror" name="response" id="response" rows="5"></textarea>
                                @error('response')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>





                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary">Yanıtla</button>
                                <a href="#" class="btn btn-secondary">Geri Dön</a>
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
