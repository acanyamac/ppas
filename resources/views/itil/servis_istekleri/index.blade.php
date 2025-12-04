@extends('layouts.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">

@endsection

@section('breadcrumb-title')
    <h3>Servis İstekleri</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Servis İstekleri</li>
    <li class="breadcrumb-item active">Servis İstekleri</li>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body">
                        @if ($message = session('message'))
                            <div class="alert alert-success">{{ $message }}</div>
                        @endif


                        <div class="table-responsive">
                            <table class="display" id="service-request-dt">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Başlık</th>
                                        <th>Konu</th>
                                        <th>Servis ismi</th>
                                        <th>Seviyesi</th>
                                        <th>Durumu</th>
                                        <th>Tarihi</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>



                                    @foreach ($serviceRequests as $serviceRequest)
                                        <tr>
                                            <td>{{ $serviceRequest->id }}</td>
                                            <td>{{ $serviceRequest->title }}</td>
                                            <td>{{ $serviceRequest->description }}</td>
                                            <td>{{ $serviceRequest->subGroup->name }}</td>
                                            <td>
                                                @switch($serviceRequest->level)
                                                    @case(1)
                                                        <span class="badge badge-success p-3">1</span>
                                                    @break

                                                    @case(2)
                                                        <span class="badge badge-warning p-3">2</span>
                                                    @break

                                                    @case(3)
                                                        <span class="badge badge-danger p-3">3</span>
                                                    @break

                                                    @default
                                                @endswitch
                                            </td>
                                            <td>
                                                @switch($serviceRequest->request_filter_id)
                                                    @case(1)
                                                        <span class="badge badge-dark p-2">Cevap Bekleniyor</span>
                                                    @break

                                                    @case(4)
                                                    <span class="badge badge-dark p-2">Cevaplandı</span>

                                                    @break

                                                    @default
                                                @endswitch
                                            </td>
                                            <td>{{ $serviceRequest->created_at }}</td>
                                            <td>
                                                <a href="{{ route('service_requests.show',$serviceRequest->id ) }}"
                                                    class="btn btn-outline-info btn-air-info btn-lg"
                                                    title="Görüntüle">
                                                    <i class="fa fa-search"></i></a>
                                            </td>







                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Zero Configuration  Ends-->

        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/js/service-request-dt.js') }}"></script>


@endsection
