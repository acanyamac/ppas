@extends('layouts.master')

@section('title', 'Zaman Dağılımı')

@section('breadcrumb-title')
    <h3>Zaman Bazlı Dağılım (Süre)</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Performance Agent</li>
    <li class="breadcrumb-item">İstatistikler</li>
    <li class="breadcrumb-item active">Zaman Dağılımı</li>
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
                                       value="{{ $startDate }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Bitiş Tarihi</label>
                                <input type="date" name="end_date" class="form-control" 
                                       value="{{ $endDate }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Gruplama</label>
                                <select name="group_by" class="form-select">
                                    <option value="hour" {{ $groupBy == 'hour' ? 'selected' : '' }}>Saatlik</option>
                                    <option value="day" {{ $groupBy == 'day' ? 'selected' : '' }}>Günlük</option>
                                    <option value="week" {{ $groupBy == 'week' ? 'selected' : '' }}>Haftalık</option>
                                    <option value="month" {{ $groupBy == 'month' ? 'selected' : '' }}>Aylık</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary d-block w-100">
                                    <i class="fa fa-filter"></i> Filtrele
                                </button>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setQuickFilter('today')">
                                        Bugün
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setQuickFilter('week')">
                                        Bu Hafta
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setQuickFilter('month')">
                                        Bu Ay
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setQuickFilter('last7')">
                                        Son 7 Gün
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setQuickFilter('last30')">
                                        Son 30 Gün
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Zaman Bazlı Line Chart -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Toplam Süre Trendi ({{ ucfirst($groupBy) }} Bazlı - Saat)</h5>
                </div>
                <div class="card-body">
                    <canvas id="timeDistributionChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Süre Dağılımı -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Toplam Süre Dağılımı</h5>
                </div>
                <div class="card-body">
                    <canvas id="durationChart" height="150"></canvas>
                </div>
            </div>
        </div>

        <!-- İş/Diğer Süre Dağılımı -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>İş / Diğer Süre Dağılımı</h5>
                </div>
                <div class="card-body">
                    <canvas id="countChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Detay Tablo -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Detaylı Zaman Dağılımı</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Periyot</th>
                                    <th>Aktivite Sayısı</th>
                                    <th>Toplam Süre</th>
                                    <th>Ortalama Süre</th>
                                    <th>İş Süresi (Saat)</th>
                                    <th>Diğer Süre (Saat)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($distribution as $item)
                                <tr>
                                    <td><strong>{{ $item['period'] }}</strong></td>
                                    <td>{{ number_format($item['activity_count']) }}</td>
                                    <td>
                                        @php
                                            $totalSeconds = $item['total_duration_seconds'];
                                            $hours = floor($totalSeconds / 3600);
                                            $minutes = floor(($totalSeconds % 3600) / 60);
                                            $seconds = $totalSeconds % 60;
                                        @endphp
                                        {{ sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds) }}
                                    </td>
                                    <td>
                                        @php
                                            $avgSeconds = $item['avg_duration_seconds'];
                                            $avgHours = floor($avgSeconds / 3600);
                                            $avgMinutes = floor(($avgSeconds % 3600) / 60);
                                            $avgSecs = $avgSeconds % 60;
                                        @endphp
                                        {{ sprintf('%02d:%02d:%02d', $avgHours, $avgMinutes, $avgSecs) }}
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ number_format($item['work_count'], 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ number_format($item['other_count'], 2) }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Veri bulunamadı</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="table-info">
                                    <td><strong>TOPLAM</strong></td>
                                    <td><strong>{{ number_format(array_sum(array_column($distribution, 'activity_count'))) }}</strong></td>
                                    <td>
                                        @php
                                            $totalAllSeconds = array_sum(array_column($distribution, 'total_duration_seconds'));
                                            $totalHours = floor($totalAllSeconds / 3600);
                                            $totalMinutes = floor(($totalAllSeconds % 3600) / 60);
                                            $totalSecs = $totalAllSeconds % 60;
                                        @endphp
                                        <strong>{{ sprintf('%02d:%02d:%02d', $totalHours, $totalMinutes, $totalSecs) }}</strong>
                                    </td>
                                    <td>-</td>
                                    <td><strong>{{ number_format(array_sum(array_column($distribution, 'work_count')), 2) }}</strong></td>
                                    <td><strong>{{ number_format(array_sum(array_column($distribution, 'other_count')), 2) }}</strong></td>
                                </tr>
                            </tfoot>
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
    function setQuickFilter(type) {
        const startDateInput = document.querySelector('input[name="start_date"]');
        const endDateInput = document.querySelector('input[name="end_date"]');
        const groupBySelect = document.querySelector('select[name="group_by"]');
        const now = new Date();
        
        switch(type) {
            case 'today':
                startDateInput.value = now.toISOString().split('T')[0];
                endDateInput.value = now.toISOString().split('T')[0];
                groupBySelect.value = 'hour';
                break;
            case 'week':
                const weekStart = new Date(now.setDate(now.getDate() - now.getDay()));
                startDateInput.value = weekStart.toISOString().split('T')[0];
                endDateInput.value = new Date().toISOString().split('T')[0];
                groupBySelect.value = 'day';
                break;
            case 'month':
                const monthStart = new Date(now.getFullYear(), now.getMonth(), 1);
                startDateInput.value = monthStart.toISOString().split('T')[0];
                endDateInput.value = new Date().toISOString().split('T')[0];
                groupBySelect.value = 'day';
                break;
            case 'last7':
                const last7 = new Date();
                last7.setDate(last7.getDate() - 7);
                startDateInput.value = last7.toISOString().split('T')[0];
                endDateInput.value = new Date().toISOString().split('T')[0];
                groupBySelect.value = 'day';
                break;
            case 'last30':
                const last30 = new Date();
                last30.setDate(last30.getDate() - 30);
                startDateInput.value = last30.toISOString().split('T')[0];
                endDateInput.value = new Date().toISOString().split('T')[0];
                groupBySelect.value = 'day';
                break;
        }
    }

    const distributionData = {!! json_encode($distribution) !!};

    // Time Distribution Line Chart
    const lineCtx = document.getElementById('timeDistributionChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: distributionData.map(d => d.period),
            datasets: [{
                label: 'Toplam Süre (Saat)',
                data: distributionData.map(d => d.total_duration_hours),
                borderColor: '#7366ff',
                backgroundColor: 'rgba(115, 102, 255, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw + ' Saat';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Saat'
                    }
                }
            }
        }
    });

    // Duration Bar Chart
    const durationCtx = document.getElementById('durationChart').getContext('2d');
    new Chart(durationCtx, {
        type: 'bar',
        data: {
            labels: distributionData.map(d => d.period),
            datasets: [{
                label: 'Toplam Süre (saat)',
                data: distributionData.map(d => d.total_duration_hours), // Updated to use hours directly instead of seconds/3600 in JS
                backgroundColor: '#51bb25'
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
            }
        }
    });

    // Count Chart - Now Work/Other Duration Chart
    const countCtx = document.getElementById('countChart').getContext('2d');
    new Chart(countCtx, {
        type: 'bar',
        data: {
            labels: distributionData.map(d => d.period),
            datasets: [
                {
                    label: 'İş (Saat)',
                    data: distributionData.map(d => d.work_count),
                    backgroundColor: '#7366ff'
                },
                {
                    label: 'Diğer (Saat)',
                    data: distributionData.map(d => d.other_count),
                    backgroundColor: '#6c757d'
                }
            ]
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
                },
                x: {
                    stacked: false
                }
            }
        }
    });
</script>
@endsection
