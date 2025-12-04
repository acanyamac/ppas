@extends('layouts.master')
@section('title', 'Denetim Görüşü')

@section('css')


@endsection

@section('style')


<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">

@endsection

@section('breadcrumb-title')
    <h3>Denetim Görüşü Oluştur</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Denetim Raporları</li>
    <li class="breadcrumb-item active">Denetim Görüşü Oluştur</li>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-header">

                        <h5>Lütfen denetim seçiniz</h5>

                    </div>



                    <div class="card-body">
                        

                        <form class="form-horizontal" action="{{ route('denetim-gorusu.list') }}" method="POST">
                            @csrf

                            <div class="mb-3 row">
                                <label class="col-lg-12 form-label text-lg-start" for="audit_id">Denetim</label>
                                <div class="col-lg-12">
                                    <select class="form-control" name="audit_id" id="audit_id">

                                        @if ($audits->count())
                                            @foreach ($audits as $item)
                                                <option value="{{ $item->id }}" @selected($item->id == request()->get('audit_id'))>
                                                    {{ $item->institution_name }}
                                                    ({{ \Carbon\Carbon::parse($item->audit_date)->format('d-m-Y') }})
                                                </option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>

                            </div>

                            <!-- Select Button -->
                            <div class="mb-3 row">

                                <div class="col-lg-4">
                                    <button id="btnSelectAuditOpinion" type="submit" name="btnSelect"
                                        class="btn btn-primary">Seçiniz</button>
                                </div>


                            </div>



                        </form>

                     



                    </div>
                </div>
            </div>
            <!-- Zero Configuration  Ends-->

        </div>
        @if (isset($audit))
            <div class="row">

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Denetim Görüşü</h5>
                        </div>
                        <form action="{{ route('denetim-gorusu.store')}}"  method="POST" style="display: inline">
                            @csrf

                            <input type="hidden" name="audit_id" value="{{$audit->id}}"/>

                            <div class="card-body">
                                <textarea id="editor1" name="editor1" cols="30" rows="50">
                                    <p>{{ $audit->institution_name }} Bakanlığına / Kurumuna / Anonim Şirketine / ....</p>
                                            
                                    <p>6 Temmuz 2019 tarihinde yayımlanarak yürürlüğe giren Bilgi ve İletişim Güvenliği Tedbirleri konulu Cumhurbaşkanlığı Genelgesi uyarınca yayımlanan Bilgi ve İletişim Güvenliği Rehberi'nin .../... sürümüne yönelik uyum denetimlerini gerçekleştirmek üzere ..... sayılı ve  ......  tarihli resmi yazı ile görevlendirilmiş bulunuyoruz.</p>

                                    <p>{{ $audit->institution_name }} Bakanlık / Kurum / Anonim Şirketi / ……...…. Yönetimi, Bilgi ve İletişim Güvenliği Rehberi’nde yer verilen usul ve esaslar çerçevesindeki uygulama sürecini ve varlık
                                                gruplarına uygulanması gereken tedbirleri yerine getirmekle sorumludur.</p>

                                    <p>Bilgi ve İletişim Güvenliği Rehberi uyum denetimini gerçekleştiren denetim ekibi olarak sorumluluğumuz, gerçekleştirdiğimiz denetim çalışmalarına istinaden Rehber uygulama
                                                sürecinin ve varlık gruplarına uygulanan tedbirlerin etkinliğine yönelik görüş bildirmektir</p>

                                    <p>Denetim çalışmaları, Bilgi ve İletişim Güvenliği Denetim Rehberi’nde yer alan usul ve esaslara uygun olarak planlanmış, Bilgi ve İletişim Güvenliği Rehberi uygulama sürecinin ve
                                                    varlık gruplarına uygulanması gereken tedbirlerin etkinliğini ölçmeye makul güvence sağlayacak şekilde yürütülmüştür. Denetim çalışmaları ({{ $audit->institution_name }} / Bakanlığının /
                                                    Kurumunun / Anonim Şirketinin /…) sunduğu bilgi, belge, yazılı ve sözlü beyanlar çerçevesinde Bilgi ve İletişim Güvenliği Denetim Rehberi’nde yer alan denetim yöntemleri ve ihtiyaç
                                                    duyduğumuz ölçüde benzeri diğer denetim tekniklerinin uygulanmasını içermektedir.</p>

                                    <p>Yapılan denetimde, tedbirlerin yerine getirilmesi amacıyla uygulanan kontrollerin doğasında bulunan kısıtlar nedeniyle eksikliklerin tespit edilememe riski bulunmaktadır. Bunlarla birlikte, ({{ $audit->institution_name }} / Bakanlığının / Kurumunun / Anonim Şirketinin /........) bilgi sistemleri yapısının veya mevcut şartların değişmesi durumunda bulguların ve bulgularla ilişkili risklerin değişikliğe uğrama olasılığı vardır.</p>

                                    <p>Gerçekleştirilen denetim çalışmaları sonucunda topladığımız kanıtlar ve elde ettiğimiz bulgular neticesinde:</p>

                                    <p>Bilgi ve İletişim Güvenliği Rehberi uygulama sürecinde:</p>

                                    <ol>
                                        <li>Kurum varlık gruplarının, Rehberde yer alan varlık grubu ana başlıkları ile uyumlu olacak şekilde tanımlanma durumu “kısmen
                                            gerçekleştirilmiştir”, “tamamen gerçekleştirilmiştir”, “hiç gerçekleştirilmemiştir.”</li>

                                            <li>Kurum bilgi varlıklarının mutlaka bir varlık grubu altında tanımlanma durumu “kısmen gerçekleştirilmiştir”, “tamamen gerçekleştirilmiştir”,
                                                “hiç gerçekleştirilmemiştir.”</li>

                                                <li>Varlık grupları tanımlama çalışmalarının varsa bilgi güvenliği yönetim sistemi kapsamında oluşturulan varlık envanteri ile ilişkilendirilme
                                                    durumu “kısmen gerçekleştirilmiştir”, “tamamen gerçekleştirilmiştir”, “hiç gerçekleştirilmemiştir.”</li>

                                                    <li>Varlık grupları kritiklik derecelerinin Rehbere uygun olarak belirlenme durumu “kısmen gerçekleştirilmiştir”, “tamamen gerçekleştirilmiştir”,
                                                        “hiç gerçekleştirilmemiştir.”</li>

                                                        <li>Varlık gruplarının kritiklik derecesine uygun tedbirlerin belirlenmesi “kısmen gerçekleştirilmiştir”, “tamamen gerçekleştirilmiştir”, “hiç
                                                            
                                                            gerçekleştirilmemiştir.”</li>
                                                            <li>Uygulama ve teknoloji alanına yönelik tedbirler ve sıkılaştırma tedbirlerinin varlık grubu ile uygun bir şekilde eşleştirilmesi “kısmen
                                                                gerçekleştirilmiştir”, “tamamen gerçekleştirilmiştir”, “hiç gerçekleştirilmemiştir.”</li>

                                                                <li>Her bir varlık grubu için mevcut durum ve boşluk analizi çalışmalarının yapılması “kısmen gerçekleştirilmiştir”, “tamamen gerçekleştirilmiştir”,
                                                                    “hiç gerçekleştirilmemiştir.”</li>

                                                                    <li>Telafi edici kontrollerin dokümante edilmesi “kısmen gerçekleştirilmiştir”, “tamamen gerçekleştirilmiştir”, “hiç gerçekleştirilmemiştir.”</li>
                                                                    <li>Rehber uygulama yol haritasının oluşturulma durumu “kısmen gerçekleştirilmiştir”, “tamamen gerçekleştirilmiştir”, “hiç
                                                                        gerçekleştirilmemiştir.”</li>


                                    </ol>
                                
                                    <p>Denetim kapsamındaki varlık gruplarına Bilgi ve İletişim Güvenliği Rehberi’nde yer alan tedbirlerden uygulanması gerekenlerin etkinlik durumu aşağıdaki tabloda yer almaktadır.</p>

                                    <table>
                                        <thead>

                                            <tr>
                                                <th rowspan="2">Varlık Grubu Ana Başlığı No</td>
                                                <th rowspan="2">Varlık Grubu No</td>
                                                <th rowspan="2">Uygulanması Gereken Toplam Tedbir Sayısı</td>
                                                <th colspan="3">Tedbirlerin Etkinlik Durumu</td>
                                            </tr>
                                            <tr>
                                                <th>Etkin Olan Tedbir Sayısı</th>
                                                <th>Etkin Olmayan Tedbir Sayısı</th>
                                                <th>Kısmen Etkin Tedbir Sayısı</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>

                                            
                                                @foreach ($data as $item)
                                                    <tr>
                                                        <td>{{ $item->main_group_no }}</td>
                                                        <td>{{ $item->sub_group_no }}</td>
                                                        <td>{{ $item->total }}</td>
                                                        <td>{{ $item->total_E }}</td>
                                                        <td>{{ $item->total_ED }}</td>
                                                        <td>{{ $item->total_K }}</td>

                                                    </tr>
                                                @endforeach

                                        </tbody>
                                    </table>

                                    <p>Düzenleme Yeri :</p>

                                    <p>Düzenleme Tarihi :</p>

                                    <p>Denetim Koordinatörü :</p>

                                    <p>.............................................................</p>

                                    <p>İmza:</p>

                                    <p><b>Denetçiler</b></p>

                                    @foreach ($auditAuditors as $auditAuditor)

                                    <p>{{$auditAuditor->auditors->name}} {{$auditAuditor->auditors->last_name}}</p>
                                        
                                    @endforeach

                                </textarea>


                            </div>
                            <div class="card-footer">
                                
                                    <button type="submit"
                                        class="btn btn-primary mb-2">Denetim Görüşünü Kaydet</button>
                            
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        {{-- <div class="row">
          
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

        </div> --}}

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
