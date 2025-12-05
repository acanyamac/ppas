@extends('layouts.master')

@section('title', 'Kullanıcı İstatistikleri')

@section('css')
@endsection

@section('breadcrumb-title')
    <h3>{{ $user->name ?? $user->username }} İstatistikleri</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Performance Agent</li>
    <li class="breadcrumb-item"><a href="{{ route('computer-users.index') }}">Kullanıcılar</a></li>
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
                                       value="{{ $filters['start_date'] ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Bitiş Tarihi</label>
                                <input type="date" name="end_date" class="form-control" 
                                       value="{{ $filters['end_date'] ?? '' }}">
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
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-secondary">{{ number_format($workOtherRatio['other']['duration_hours'], 1) }}</h2>
                    <p class="mb-0">Diğer Saatler</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h2 class="text-success">{{ number_format($workOtherRatio['total']['duration_hours'], 1) }}</h2>
                    <p class="mb-0">Toplam Saat</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Pie Chart -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>İş / Diğer Dağılımı</h5>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="workOtherPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Categories Chart -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>En Çok Kullanılan Kategoriler</h5>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="topCategoriesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Son Aktiviteler</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Process</th>
                                    <th>Başlık</th>
                                    <th>Kategoriler</th>
                                    <th>Tarih</th>
                                    <th>Süre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivities as $activity)
                                <tr>
                                    <td><code>{{ Str::limit($activity->process_name, 20) }}</code></td>
                                    <td>{{ Str::limit($activity->title, 40) }}</td>
                                    <td>
                                        @foreach($activity->categories as $category)
                                            <span class="badge bg-primary">{{ $category->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $activity->start_time_utc->format('d.m.Y H:i') }}</td>
                                    <td>{{ $activity->duration_formatted }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Aktivite bulunamadı</td>
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
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
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

    // Top Categories Chart
    const topCatCtx = document.getElementById('topCategoriesChart').getContext('2d');
    new Chart(topCatCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topCategories->pluck('name')->toArray()) !!},
            datasets: [{
                label: 'Aktivite Sayısı',
                data: {!! json_encode($topCategories->pluck('activity_count')->toArray()) !!},
                backgroundColor: '#7366ff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endsection
