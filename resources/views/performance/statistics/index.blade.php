@extends('layouts.master')

@section('title', 'Kategori İstatistikleri')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>Kategori İstatistikleri</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Performance Agent</li>
    <li class="breadcrumb-item active">İstatistikler</li>
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
                                    <button type="button" class="btn btn-outline-primary" onclick="setDateRange(7)">
                                        Son 7 Gün
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" onclick="setDateRange(30)">
                                        Son 30 Gün
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
        <!-- Kategori Dağılımı Grafik -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Kategori Bazlı Aktivite Dağılımı</h5>
                </div>
                <div class="card-body">
                    <canvas id="categoryDistributionChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Top 5 Kategoriler -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>En Çok Kullanılan Kategoriler</h5>
                </div>
                <div class="card-body">
                    <canvas id="topCategoriesChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Kategori Detay Tablosu -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Kategori Detayları</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Tip</th>
                                    <th>Aktivite Sayısı</th>
                                    <th>Toplam Süre</th>
                                    <th>Ort. Süre</th>
                                    <th>Yüzde</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statistics['categories'] as $cat)
                                <tr>
                                    <td>
                                        <strong>{{ $cat['name'] }}</strong>
                                    </td>
                                    <td>
                                        @if($cat['type'] == 'work')
                                            <span class="badge bg-primary">İş</span>
                                        @else
                                            <span class="badge bg-secondary">Diğer</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($cat['activity_count']) }}</td>
                                    <td>{{ gmdate('H:i:s', $cat['total_duration_seconds']) }}</td>
                                    <td>{{ gmdate('H:i:s', $cat['avg_duration_seconds']) }}</td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" role="progressbar" 
                                                 style="width: {{ $cat['percentage'] }}%">
                                                {{ number_format($cat['percentage'], 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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

    // Kategori Dağılım Chart
    const distributionCtx = document.getElementById('categoryDistributionChart').getContext('2d');
    new Chart(distributionCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($statistics['categories']->pluck('name')) !!},
            datasets: [{
                label: 'Toplam Süre (Saat)',
                data: {!! json_encode($statistics['categories']->pluck('total_duration_hours')) !!},
                backgroundColor: '#7366ff',
                borderColor: '#7366ff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.raw.toFixed(2) + ' Saat';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Top Kategoriler Pie Chart
    const topCatData = {!! json_encode($statistics['categories']->take(5)) !!};
    const topCatCtx = document.getElementById('topCategoriesChart').getContext('2d');
    new Chart(topCatCtx, {
        type: 'doughnut',
        data: {
            labels: topCatData.map(c => c.name),
            datasets: [{
                data: topCatData.map(c => c.total_duration_hours),
                backgroundColor: [
                    '#7366ff', '#f73164', '#51bb25', '#ffc107', '#17a2b8'
                ]
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
</script>
@endsection
