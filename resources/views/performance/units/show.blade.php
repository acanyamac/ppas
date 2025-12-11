@extends('layouts.master')

@section('title', 'Birim Detayları: ' . $unit->name)

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/chart/apex-chart/apex-chart.css') }}">
@endsection

@section('breadcrumb-title')
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $unit->name }}</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Birim performans analizi ve istatistikleri</p>
    </div>
@endsection

@section('breadcrumb-items')
    <li class="flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
        <span class="text-gray-600 dark:text-gray-400">Performance</span>
    </li>
    <li class="flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
        <a href="{{ route('unit-statistics.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-600">Birimler</a>
    </li>
    <li class="flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
        <span class="text-gray-600 dark:text-gray-400">Detay</span>
    </li>
@endsection

@section('content')

<!-- Filtreler -->
@include('performance.computer_users.partials.filter', ['route' => route('unit-statistics.show', $unit->id), 'filters' => $filters])

<!-- İstatistik Kartları -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
    <!-- Toplam Süre -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Toplam Çalışma</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $workOtherRatio['total']['duration_hours'] }} <span class="text-sm font-normal text-gray-500">saat</span>
                    </h3>
                </div>
                <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-primary-600 dark:text-primary-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Verimlilik -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Verim Oranı</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-2xl font-bold text-green-600 dark:text-green-400">
                            %{{ $workOtherRatio['work']['percentage'] }}
                        </h3>
                        <span class="text-xs text-gray-500">{{ $workOtherRatio['work']['duration_hours'] }} saat iş</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-green-600 dark:text-green-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Kullanıcı Sayısı -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Personel</p>
                    <h3 class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $unit->users_count }}</h3>
                    <p class="text-xs text-gray-500 mt-1">toplam kullanıcı</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Mesai İçi/Dışı -->
    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Mesai Dışı</p>
                    <h3 class="text-2xl font-bold text-orange-600 dark:text-orange-400">
                        {{ $workingHourStats['outside_hours']['work'] }} <span class="text-sm font-normal text-gray-500">saat</span>
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">iş aktivitesi</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-moon text-orange-600 dark:text-orange-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">
    <!-- Haftalık Ritim -->
    <div class="col-span-1 xl:col-span-2 card">
        <div class="card-header border-b border-gray-200 dark:border-gray-700">
            <h5 class="font-bold text-gray-900 dark:text-white">Birim Haftalık Ritmi</h5>
        </div>
        <div class="card-body">
            <div id="weeklyRhythmChart"></div>
        </div>
    </div>

    <!-- Kategori Dağılımı -->
    <div class="card">
        <div class="card-header border-b border-gray-200 dark:border-gray-700">
            <h5 class="font-bold text-gray-900 dark:text-white">Kategori Dağılımı</h5>
        </div>
        <div class="card-body">
            <div id="categoryChart"></div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Top Keywords -->
    <div class="card">
        <div class="card-header border-b border-gray-200 dark:border-gray-700">
            <h5 class="font-bold text-gray-900 dark:text-white">En Çok Kullanılan Kelimeler</h5>
        </div>
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Kelime</th>
                            <th class="text-right">Kullanım</th>
                            <th class="text-right">Süre (Saat)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topKeywords as $keyword)
                        <tr>
                            <td class="font-medium text-gray-700 dark:text-gray-300">{{ $keyword['keyword'] }}</td>
                            <td class="text-right">{{ number_format($keyword['count']) }}</td>
                            <td class="text-right">{{ $keyword['duration_hours'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top Processes -->
    <div class="card">
        <div class="card-header border-b border-gray-200 dark:border-gray-700">
            <h5 class="font-bold text-gray-900 dark:text-white">En Çok Kullanılan Uygulamalar</h5>
        </div>
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Uygulama</th>
                            <th class="text-right">Süre (Saat)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topProcesses as $process)
                        <tr>
                            <td class="font-medium text-gray-700 dark:text-gray-300">
                                <span class="px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded font-mono text-xs">
                                    {{ $process['process_name'] }}
                                </span>
                            </td>
                            <td class="text-right">{{ $process['duration_hours'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Kullanıcı Listesi -->
<div class="card">
    <div class="card-header border-b border-gray-200 dark:border-gray-700">
        <h5 class="font-bold text-gray-900 dark:text-white">Birim Personeli Performans Özeti</h5>
    </div>
    <div class="card-body">
        <div class="overflow-x-auto">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Personel</th>
                        <th>Toplam Aktivite</th>
                        <th>Toplam Süre (Saat)</th>
                        <th>Detay</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($computerUsers as $user)
                    <tr>
                        <td class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-gray-500"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white">{{ $user->name ?? $user->username }}</div>
                                <div class="text-xs text-gray-500">{{ $user->username }}</div>
                            </div>
                        </td>
                        <td>{{ number_format($user->activities_count) }}</td>
                        <td>{{ number_format($user->total_duration_hours, 1) }}</td>
                        <td>
                            <a href="{{ route('computer-users.show', $user->id) }}" class="text-primary-600 hover:text-primary-800">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
<script>
    // Weekly Rhythm Chart
    var weeklyOptions = {
        chart: {
            height: 350,
            type: 'bar',
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                columnWidth: '45%',
            }
        },
        dataLabels: { enabled: false },
        stroke: { show: true, width: 2, colors: ['transparent'] },
        series: [{
            name: 'Ortalama Çalışma (Saat)',
            data: @json(array_column($weeklyRhythm, 'avg_hours'))
        }],
        xaxis: {
            categories: @json(array_column($weeklyRhythm, 'day')),
        },
        yaxis: {
            title: { text: 'Saat' }
        },
        fill: { opacity: 1 },
        colors: ['#7366ff']
    };
    new ApexCharts(document.querySelector("#weeklyRhythmChart"), weeklyOptions).render();

    // Category Distribution Chart
    var categoryOptions = {
        series: @json($topCategories->pluck('percentage')),
        chart: {
            width: 380,
            type: 'donut',
        },
        labels: @json($topCategories->pluck('name')),
        responsive: [{
            breakpoint: 480,
            options: {
                chart: { width: 200 },
                legend: { position: 'bottom' }
            }
        }],
        colors: ['#7366ff', '#51bb25', '#f73164', '#f8d62b', '#a927f9']
    };
    new ApexCharts(document.querySelector("#categoryChart"), categoryOptions).render();
</script>
@endsection
