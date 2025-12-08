@extends('layouts.master')

@section('title', 'Tagleme Başarı Oranı')

@section('breadcrumb-title')
    <h3>Tagleme Başarı Oranı (Süre Bazlı)</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Performance Agent</li>
    <li class="breadcrumb-item">İstatistikler</li>
    <li class="breadcrumb-item active">Tagleme Oranı</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Filtreler -->
    <div class="row mb-3">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Başlangıç Tarihi</label>
                                <input type="date" name="start_date" class="form-control" 
                                       value="{{ $filters['start_date'] }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Bitiş Tarihi</label>
                                <input type="date" name="end_date" class="form-control" 
                                       value="{{ $filters['end_date'] }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary d-block w-100">
                                    <i class="fa fa-filter"></i> Filtrele
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Özet Kartlar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-primary">{{ number_format($taggingRate['total'], 2) }}</h2>
                    <p class="mb-0">Toplam Süre (Saat)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-success">{{ number_format($taggingRate['tagged'], 2) }}</h2>
                    <p class="mb-0">Taglenmiş (Saat)</p>
                    <small class="text-muted">%{{ number_format($taggingRate['tagging_rate'], 1) }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-warning">{{ number_format($taggingRate['untagged'], 2) }}</h2>
                    <p class="mb-0">Taglenmemiş (Saat)</p>
                    <small class="text-muted">%{{ number_format(100 - $taggingRate['tagging_rate'], 1) }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-info">{{ number_format($taggingRate['auto_tagged'], 2) }}</h2>
                    <p class="mb-0">Otomatik (Saat)</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Tagleme Oranı Gauge Chart -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Tagleme Başarı Oranı</h5>
                </div>
                <div class="card-body">
                    <div style="height: 300px; position: relative;">
                        <canvas id="taggingRatePieChart"></canvas>
                    </div>
                    <div class="text-center mt-3">
                        <h2 class="
                            @if($taggingRate['tagging_rate'] >= 80) text-success
                            @elseif($taggingRate['tagging_rate'] >= 60) text-info
                            @elseif($taggingRate['tagging_rate'] >= 40) text-warning
                            @else text-danger
                            @endif
                        ">
                            %{{ number_format($taggingRate['tagging_rate'], 1) }}
                        </h2>
                        <p class="text-muted">Başarı Oranı</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Otomatik vs Manuel Tagleme -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Otomatik / Manuel Tagleme (Saat)</h5>
                </div>
                <div class="card-body">
                    <div style="height: 300px; position: relative;">
                        <canvas id="autoManualChart"></canvas>
                    </div>
                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>
                                <i class="fa fa-circle text-success"></i> Otomatik
                            </span>
                            <strong>{{ number_format($taggingRate['auto_tagged'], 2) }} Saat</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>
                                <i class="fa fa-circle text-info"></i> Manuel
                            </span>
                            <strong>{{ number_format($taggingRate['manual_tagged'], 2) }} Saat</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Tagleme Durumu Özeti</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Durum</th>
                                    <th>Süre (Saat)</th>
                                    <th>Yüzde</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Taglenmiş (Toplam)</strong></td>
                                    <td>{{ number_format($taggingRate['tagged'], 2) }}</td>
                                    <td>%{{ number_format($taggingRate['tagging_rate'], 1) }}</td>
                                    <td>
                                        <div class="progress" style="height: 25px;">
                                            <div class="progress-bar bg-success" 
                                                 style="width: {{ $taggingRate['tagging_rate'] }}%">
                                                %{{ number_format($taggingRate['tagging_rate'], 1) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;<i class="fa fa-level-up fa-rotate-90"></i> Otomatik</td>
                                    <td>{{ number_format($taggingRate['auto_tagged'], 2) }}</td>
                                    <td>%{{ number_format($taggingRate['auto_percentage'], 1) }}</td>
                                    <td>
                                        <div class="progress" style="height: 25px;">
                                            <div class="progress-bar bg-primary" 
                                                 style="width: {{ $taggingRate['auto_percentage'] }}%">
                                                %{{ number_format($taggingRate['auto_percentage'], 1) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;<i class="fa fa-level-up fa-rotate-90"></i> Manuel</td>
                                    <td>{{ number_format($taggingRate['manual_tagged'], 2) }}</td>
                                    <td>%{{ number_format($taggingRate['manual_percentage'], 1) }}</td>
                                    <td>
                                        <div class="progress" style="height: 25px;">
                                            <div class="progress-bar bg-info" 
                                                 style="width: {{ $taggingRate['manual_percentage'] }}%">
                                                %{{ number_format($taggingRate['manual_percentage'], 1) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="table-warning">
                                    <td><strong>Taglenmemiş</strong></td>
                                    <td>{{ number_format($taggingRate['untagged'], 2) }}</td>
                                    <td>%{{ number_format(100 - $taggingRate['tagging_rate'], 1) }}</td>
                                    <td>
                                        <div class="progress" style="height: 25px;">
                                            <div class="progress-bar bg-warning" 
                                                 style="width: {{ 100 - $taggingRate['tagging_rate'] }}%">
                                                %{{ number_format(100 - $taggingRate['tagging_rate'], 1) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @if($taggingRate['untagged'] > 0)
                        <div class="alert alert-warning mt-3">
                            <i class="fa fa-exclamation-triangle"></i> 
                            Henüz <strong>{{ number_format($taggingRate['untagged'], 2) }} saatlik</strong> aktivite taglenmemiş. 
                            <a href="{{ route('activities.auto-tag') }}" class="alert-link">Otomatik tagleme başlat</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Tagging Rate Pie Chart
    const pieCtx = document.getElementById('taggingRatePieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Taglenmiş (Saat)', 'Taglenmemiş (Saat)'],
            datasets: [{
                data: [{{ $taggingRate['tagged'] }}, {{ $taggingRate['untagged'] }}],
                backgroundColor: ['#51bb25', '#ffc107'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.raw.toFixed(2) + ' Saat';
                            return label;
                        }
                    }
                }
            }
        }
    });

    // Auto vs Manual Chart
    const autoManualCtx = document.getElementById('autoManualChart').getContext('2d');
    new Chart(autoManualCtx, {
        type: 'bar',
        data: {
            labels: ['Otomatik', 'Manuel'],
            datasets: [{
                label: 'Süre (Saat)',
                data: [{{ $taggingRate['auto_tagged'] }}, {{ $taggingRate['manual_tagged'] }}],
                backgroundColor: ['#51bb25', '#17a2b8']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Saat'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.raw.toFixed(2) + ' Saat';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
