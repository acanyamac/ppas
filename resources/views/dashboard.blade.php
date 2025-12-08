@extends('layouts.master')

@section('title', 'Dashboard')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Dashboard</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Toplam Kategori -->
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-shrink-0">
                            <div class="icon-square bg-primary">
                                <i class="fa fa-folder" style="font-size: 24px; color: white;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Toplam Kategori</h6>
                            <h3 class="mt-2 mb-0">{{ $totalCategories }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toplam Keyword -->
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-shrink-0">
                            <div class="icon-square bg-success">
                                <i class="fa fa-key" style="font-size: 24px; color: white;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Toplam Keyword</h6>
                            <h3 class="mt-2 mb-0">{{ $totalKeywords }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Taglenmiş Aktiviteler -->
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-shrink-0">
                            <div class="icon-square bg-warning">
                                <i class="fa fa-check-circle" style="font-size: 24px; color: white;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Taglenmiş (Saat)</h6>
                            <h3 class="mt-2 mb-0">{{ $taggedActivities }}</h3>
                            <small class="text-muted">%{{ $taggingRate }} başarı oranı</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Taglenmemiş Aktiviteler -->
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-shrink-0">
                            <div class="icon-square bg-danger">
                                <i class="fa fa-exclamation-circle" style="font-size: 24px; color: white;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">Taglenmemiş (Saat)</h6>
                            <h3 class="mt-2 mb-0">{{ $untaggedActivities }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Aktivite Trendi -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Son 7 Günlük Toplam Süre Trendi (Saat)</h5>
                </div>
                <div class="card-body">
                    <canvas id="activityTrendChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- İş/Diğer Oranı -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>İş / Diğer Dağılımı</h5>
                </div>
                <div class="card-body">
                    <div style="height: 200px;">
                        <canvas id="workOtherChart"></canvas>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fa fa-circle text-primary"></i> İş</span>
                            <strong>{{ $workOtherRatio['work']['duration_hours'] ?? 0 }} saat</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><i class="fa fa-circle text-secondary"></i> Diğer</span>
                            <strong>{{ $workOtherRatio['other']['duration_hours'] ?? 0 }} saat</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- En Çok Kullanılan Kategoriler -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>En Çok Kullanılan Kategoriler</h5>
                </div>
                <div class="card-body">
                    <canvas id="topCategoriesChart" height="150"></canvas>
                </div>
            </div>
        </div>

        <!-- Son Taglenmiş Aktiviteler -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Son Taglenmiş Aktiviteler</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordernone">
                            <thead>
                                <tr>
                                    <th>Process</th>
                                    <th>Başlık</th>
                                    <th>Kategoriler</th>
                                    <th>Tarih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTaggedActivities as $activity)
                                <tr>
                                    <td><code>{{ Str::limit($activity->process_name, 20) }}</code></td>
                                    <td>{{ Str::limit($activity->title, 30) }}</td>
                                    <td>
                                        @foreach($activity->categories->take(2) as $category)
                                            <span class="badge bg-primary">{{ $category->name }}</span>
                                        @endforeach
                                        @if($activity->categories->count() > 2)
                                            <span class="badge bg-secondary">+{{ $activity->categories->count() - 2 }}</span>
                                        @endif
                                    </td>
                                    <td><small>{{ $activity->start_time_utc->format('d.m.Y H:i') }}</small></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Henüz taglenmiş aktivite yok</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-square {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Aktivite Trendi Chart
    const trendCtx = document.getElementById('activityTrendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($last7Days, 'date')) !!},
            datasets: [{
                label: 'Süre (Saat)',
                data: {!! json_encode(array_column($last7Days, 'count')) !!},
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
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

    // İş/Diğer Pie Chart
    const pieCtx = document.getElementById('workOtherChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['İş', 'Diğer'],
            datasets: [{
                data: [
                    {{ $workOtherRatio['work']['duration_hours'] ?? 0 }},
                    {{ $workOtherRatio['other']['duration_hours'] ?? 0 }}
                ],
                backgroundColor: ['#7366ff', '#6c757d']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw + ' Saat';
                        }
                    }
                }
            }
        }
    });

    // Top Kategoriler Chart
    const topCatCtx = document.getElementById('topCategoriesChart').getContext('2d');
    new Chart(topCatCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topCategories->pluck('name')->toArray()) !!},
            datasets: [{
                label: 'Süre (Saat)',
                data: {!! json_encode($topCategories->pluck('total_duration_hours')->toArray()) !!}, // data changed to duration
                backgroundColor: '#7366ff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
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
</script>
@endsection

