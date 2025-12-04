@extends('layouts.master')

@section('title', 'İş/Diğer Oranı')

@section('breadcrumb-title')
    <h3>İş / Diğer Dağılımı</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Performance Agent</li>
    <li class="breadcrumb-item">İstatistikler</li>
    <li class="breadcrumb-item active">İş/Diğer Oranı</li>
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
                            <div class="col-md-3">
                                <label class="form-label">Başlangıç Tarihi</label>
                                <input type="date" name="start_date" class="form-control" 
                                       value="{{ $filters['start_date'] }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Bitiş Tarihi</label>
                                <input type="date" name="end_date" class="form-control" 
                                       value="{{ $filters['end_date'] }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="btn-group d-block" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="setDateRange(7)">
                                        7 Gün
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="setDateRange(30)">
                                        30 Gün
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="setDateRange(90)">
                                        90 Gün
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
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
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-primary">{{ number_format($workOtherRatio['work']['duration_hours'], 1) }}</h2>
                    <p class="mb-0">İş Saatleri</p>
                    <small class="text-muted">{{ number_format($workOtherRatio['work']['activity_count']) }} aktivite</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-secondary">{{ number_format($workOtherRatio['other']['duration_hours'], 1) }}</h2>
                    <p class="mb-0">Diğer Saatler</p>
                    <small class="text-muted">{{ number_format($workOtherRatio['other']['activity_count']) }} aktivite</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-success">{{ number_format($workOtherRatio['total']['duration_hours'], 1) }}</h2>
                    <p class="mb-0">Toplam Saat</p>
                    <small class="text-muted">{{ number_format($workOtherRatio['total']['activity_count']) }} aktivite</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Pie Chart -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>İş / Diğer Oranı (Süre Bazlı)</h5>
                </div>
                <div class="card-body">
                    <canvas id="workOtherPieChart" height="150"></canvas>
                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>
                                <i class="fa fa-circle text-primary"></i> İş
                            </span>
                            <strong>%{{ number_format($workOtherRatio['work']['percentage'], 1) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>
                                <i class="fa fa-circle text-secondary"></i> Diğer
                            </span>
                            <strong>%{{ number_format($workOtherRatio['other']['percentage'], 1) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Aktivite Sayısı Karşılaştırması</h5>
                </div>
                <div class="card-body">
                    <canvas id="activityCountChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Detay Tablo -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Detaylı İstatistikler</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>İş Aktiviteleri</h6>
                            <table class="table">
                                <tr>
                                    <th>Aktivite Sayısı:</th>
                                    <td>{{ number_format($workOtherRatio['work']['activity_count']) }}</td>
                                </tr>
                                <tr>
                                    <th>Toplam Süre:</th>
                                    <td>{{ number_format($workOtherRatio['work']['duration_hours'], 2) }} saat</td>
                                </tr>
                                <tr>
                                    <th>Ortalama Süre:</th>
                                    <td>{{ number_format($workOtherRatio['work']['avg_duration_minutes'], 1) }} dakika</td>
                                </tr>
                                <tr>
                                    <th>Yüzde:</th>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" style="width: {{ $workOtherRatio['work']['percentage'] }}%">
                                                %{{ number_format($workOtherRatio['work']['percentage'], 1) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Diğer Aktiviteler</h6>
                            <table class="table">
                                <tr>
                                    <th>Aktivite Sayısı:</th>
                                    <td>{{ number_format($workOtherRatio['other']['activity_count']) }}</td>
                                </tr>
                                <tr>
                                    <th>Toplam Süre:</th>
                                    <td>{{ number_format($workOtherRatio['other']['duration_hours'], 2) }} saat</td>
                                </tr>
                                <tr>
                                    <th>Ortalama Süre:</th>
                                    <td>{{ number_format($workOtherRatio['other']['avg_duration_minutes'], 1) }} dakika</td>
                                </tr>
                                <tr>
                                    <th>Yüzde:</th>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-secondary" style="width: {{ $workOtherRatio['other']['percentage'] }}%">
                                                %{{ number_format($workOtherRatio['other']['percentage'], 1) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function setDateRange(days) {
        const endDate = new Date();
        const startDate = new Date();
        startDate.setDate(startDate.getDate() - days);
        
        document.querySelector('input[name="start_date"]').value = startDate.toISOString().split('T')[0];
        document.querySelector('input[name="end_date"]').value = endDate.toISOString().split('T')[0];
    }

    // Pie Chart
    const pieCtx = document.getElementById('workOtherPieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['İş', 'Diğer'],
            datasets: [{
                data: [
                    {{ $workOtherRatio['work']['duration_hours'] }},
                    {{ $workOtherRatio['other']['duration_hours'] }}
                ],
                backgroundColor: ['#7366ff', '#6c757d'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Activity Count Bar Chart
    const barCtx = document.getElementById('activityCountChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['İş', 'Diğer'],
            datasets: [{
                label: 'Aktivite Sayısı',
                data: [
                    {{ $workOtherRatio['work']['activity_count'] }},
                    {{ $workOtherRatio['other']['activity_count'] }}
                ],
                backgroundColor: ['#7366ff', '#6c757d']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
