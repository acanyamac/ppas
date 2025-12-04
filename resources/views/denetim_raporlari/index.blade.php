@extends('layouts.master')
@section('title', 'Sample Page')

@section('css')
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">

@endsection

@section('breadcrumb-title')
    <h3>Rapor İşlemleri</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Denetim Raporları</li>
    <li class="breadcrumb-item active">Raporlar</li>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body">

                        @if ($message = session('warning'))
                            <div class="alert alert-warning">{{ $message }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="display" id="audits-reports-dt">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Denetlenen Kurum</th>
                                        <th>Denetleme Tarihi</th>
                                        <th>Ek - A</th>
                                        <th>Ek - B</th>
                                        <th>Ek - C</th>
                                        <th>Ek - C2</th>
                                        <th>Ek - E</th>
                                        <th>Ek - F</th>
                                        <th>Ek - G</th>

                                    </tr>
                                </thead>
                                {{-- <i class="fa fa-file-pdf-o"></i> --}}
                                <tbody>
                                    @if ($audits->count())

                                        @foreach ($audits as $key => $value)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value->institution_name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($value->audit_date)->format('d-m-Y') }}</td>
                                                <td>
                                                    <div>
                                                        <a href="{{ route('export-attachment-a', ['id1' => $value->id, 'format' => 'excel']) }}"
                                                            class="btn btn-outline-info btn-air-info btn-lg mb-2"
                                                            title="Ek - A (Denetim Ekibi Bilgisi) Excel Rapor İndir">
                                                            <i class="fa fa-file-excel-o"></i></a>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('export-attachment-a', ['id1' => $value->id, 'format' => 'pdf']) }}"
                                                            class="btn btn-outline-info btn-air-info btn-lg"
                                                            title="Ek - A (Denetim Ekibi Bilgisi) PDF Rapor İndir">
                                                            <i class="fa fa-file-pdf-o"></i></a>
                                                    </div> 
                                                </td>
                                                <td>
                                                    <div>
                                                        <a href="{{ route('export-attachment-b', ['id1' => $value->id, 'format' => 'excel']) }}"
                                                            class="btn btn-outline-info btn-air-info btn-lg mb-2"
                                                            title="Ek - B (Varlık Grupları ve Denetim Kapsamı) Excel Rapor İndir">
                                                            <i class="fa fa-file-excel-o"></i></a>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('export-attachment-b', ['id1' => $value->id, 'format' => 'pdf']) }}"
                                                            class="btn btn-outline-info btn-air-info btn-lg"
                                                            title="Ek - B (Varlık Grupları ve Denetim Kapsamı) PDF Rapor İndir">
                                                            <i class="fa fa-file-pdf-o"></i></a>
                                                    </div>
                                                   
                                                </td>
                                                <td>
                                                    <div>
                                                        <a href="{{ route('export-attachment-c', ['id1' => $value->id, 'format' => 'excel']) }}"
                                                            class="btn btn-outline-info btn-air-info btn-lg mb-2"
                                                            title="Ek - C (Denetim Raporu) Excel Rapor İndir">
                                                            <i class="fa fa-file-excel-o"></i></a>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('export-attachment-c', ['id1' => $value->id, 'format' => 'pdf']) }}"
                                                            class="btn btn-outline-info btn-air-info btn-lg"
                                                            title="Ek - C (Denetim Raporu) PDF Rapor İndir">
                                                            <i class="fa fa-file-pdf-o"></i></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <a href="{{ route('export-attachment-c2', ['id1' => $value->id, 'format' => 'excel']) }}"
                                                            class="btn btn-outline-info btn-air-info btn-lg mb-2"
                                                            title="Ek - C2 (Varlık Grubu Ve Kritiklik Derecesi Tanımlama Formu) Excel Rapor İndir">
                                                            <i class="fa fa-file-excel-o"></i></a>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('export-attachment-c2', ['id1' => $value->id, 'format' => 'pdf']) }}"
                                                            class="btn btn-outline-info btn-air-info btn-lg"
                                                            title="Ek - C2 (Varlık Grubu Ve Kritiklik Derecesi Tanımlama Formu) PDF Rapor İndir">
                                                            <i class="fa fa-file-pdf-o"></i></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <a href="{{ route('export-attachment-e', ['id1' => $value->id, 'format' => 'excel']) }}"
                                                            class="btn btn-outline-info btn-air-info btn-lg mb-2"
                                                            title="Ek - E (Rehber Uygulama Süreci Etkinlik Durumu) Excel Rapor İndir">
                                                            <i class="fa fa-file-excel-o"></i></a>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('export-attachment-e', ['id1' => $value->id, 'format' => 'pdf']) }}"
                                                            class="btn btn-outline-info btn-air-info btn-lg"
                                                            title="Ek - E (Rehber Uygulama Süreci Etkinlik Durumu) PDF Rapor İndir">
                                                            <i class="fa fa-file-pdf-o"></i></a>
                                                    </div>
                                                </td>
                                                <td> 
                                                    <div>
                                                        <a href="{{ route('export-attachment-f', ['id1' => $value->id, 'format' => 'excel']) }}"
                                                            class="btn btn-outline-info btn-air-info btn-lg mb-2"
                                                            title="Ek - F (Tedbir Etkinlik Durumu) Excel Rapor İndir">
                                                            <i class="fa fa-file-excel-o"></i></a>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('export-attachment-f', ['id1' => $value->id, 'format' => 'pdf']) }}"
                                                            class="btn btn-outline-info btn-air-info btn-lg"
                                                            title="Ek - F (Tedbir Etkinlik Durumu) PDF Rapor İndir">
                                                            <i class="fa fa-file-pdf-o"></i></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        <a href="{{ route('export-attachment-g', ['id1' => $value->id, 'format' => 'excel']) }}"
                                                            class="btn btn-outline-info btn-air-info btn-lg mb-2"
                                                            title="Ek - G (Tedbir Etkinlikleri Bulgu Tablosu) Excel Rapor İndir">
                                                            <i class="fa fa-file-excel-o"></i></a>

                                                            <a href="{{ route('export-attachment-g2', ['id1' => $value->id, 'format' => 'excel']) }}"
                                                                class="btn btn-outline-info btn-air-info btn-lg mb-2"
                                                                title="Ek - G2 (Uygulama Süreci Bulgu Tablosu) Excel Rapor İndir">
                                                                <i class="fa fa-file-excel-o"></i></a>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <a href="{{ route('export-attachment-g', ['id1' => $value->id, 'format' => 'pdf']) }}"
                                                            class="btn btn-outline-info btn-air-info btn-lg"
                                                            title="Ek - G (Bulgu Tablosu) PDF Rapor İndir">
                                                            <i class="fa fa-file-pdf-o"></i></a>
                                                            <a href="{{ route('export-attachment-g2', ['id1' => $value->id, 'format' => 'pdf']) }}"
                                                                class="btn btn-outline-info btn-air-info btn-lg"
                                                                title="Ek - G2 (Uygulama Süreci Bulgu Tablosu) PDF Rapor İndir">
                                                                <i class="fa fa-file-pdf-o"></i></a>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach



                                    @endif


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
    <script src="{{ asset('assets/js/audits-reports-dt.js') }}"></script>


@endsection
