@extends('layouts.master')

@section('title', 'Otomatik Tagleme')

@section('breadcrumb-title')
    <h3>Otomatik Tagleme</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Performance Agent</li>
    <li class="breadcrumb-item active">Otomatik Tagleme</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-primary">{{ number_format($totalCount) }}</h2>
                    <p class="mb-0">Toplam Aktivite</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-success">{{ number_format($taggedCount) }}</h2>
                    <p class="mb-0">Taglenmiş Aktivite</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-warning">{{ number_format($untaggedCount) }}</h2>
                    <p class="mb-0">Taglenmemiş Aktivite</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Otomatik Tagleme Başlat</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($untaggedCount > 0)
                        <form action="{{ route('activities.auto-tag.run') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">İşlenecek Aktivite Sayısı</label>
                                    <input type="number" name="limit" class="form-control" 
                                           value="100" min="1" max="1000">
                                    <small class="text-muted">Maksimum 1000 aktivite işlenebilir</small>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa fa-magic"></i> Otomatik Tagleme Başlat
                            </button>
                        </form>

                        <div class="alert alert-info mt-4">
                            <h6>Otomatik Tagleme Nasıl Çalışır?</h6>
                            <ul>
                                <li>Taglenmemiş aktiviteler <code>process_name</code>, <code>title</code> ve <code>url</code> alanlarında keyword araması yapılır</li>
                                <li>Eşleşen keyword'ler önceliklerine göre sıralanır</li>
                                <li>En yüksek öncelikli keyword'ün kategorisi ile aktivite taglenır</li>
                                <li>Eşleşme tipine göre güven skoru hesaplanır</li>
                            </ul>
                        </div>
                    @else
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle"></i> Tüm aktiviteler taglenmiş durumda!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
