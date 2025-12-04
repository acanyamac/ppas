@extends('layouts.master')
@section('title', 'Denetim Görüşü')

@section('css')


@endsection

@section('style')


<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">

@endsection

@section('breadcrumb-title')
    <h3>Denetim Görüşleri</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Denetim Raporları</li>
    <li class="breadcrumb-item active">Denetim Görüşleri</li>
@endsection

@section('content')


    <div class="container-fluid">
    
      

        <div class="row">
          
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body">
                        @if ($message = session('message'))
                            <div class="alert alert-success">{{ $message }}</div>
                        @endif


                        <div class="table-responsive">
                            <table class="display" id="general-datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Denetim</th>
                                        <th>Denetleme Tarihi</th>
                                        <th>İndir</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($auditOpinions->count())

                                        @foreach ($auditOpinions as $key => $auditOpinion)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $auditOpinion->audits->institution_name}} </td>
                                                <td>{{ \Carbon\Carbon::parse($auditOpinion->audits->audit_date)->format('d-m-Y') }}</td>
                                                <td><a href="{{ route('export-auditOpinion',  $auditOpinion->id) }}"
                                                    class="btn btn-outline-info btn-air-info btn-lg"
                                                    title="Denetim Görüşünü İndir">
                                                    <i class="fa fa-file-pdf-o"></i></a></td>
                                                <td>
                                                    <ul class="action">
                                                
                                                        <li class="delete">
                                                            <form id="form-delete"
                                                                action="{{ route('denetim-gorusu.destroy', $auditOpinion->id) }}"
                                                                method="POST" style="display: inline"
                                                                onsubmit="return confirm('Emin misiniz?')">
                                                                @csrf
                                                                @method('delete')
                                                                <button class="btn btn-sm"><i
                                                                        class="icon-trash"></i></button>
                                                            </form>
                                                        </li>

                                                    </ul>
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

    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/editor/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/editor/ckeditor/styles.js') }}"></script>
    <script src="{{ asset('assets/js/editor/ckeditor/ckeditor.custom.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/js/general-datatable.js') }}"></script>


@endsection
