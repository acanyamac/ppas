@extends('layouts.master')

@section('title', 'Taglenmemiş Aktiviteler')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Taglenmemiş Aktiviteler</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Henüz kategorize edilmemiş aktiviteler</p>
    </div>
@endsection

@section('breadcrumb-items')
    <li class="flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
        <a href="{{ route('activities.index') }}" class="text-primary-600 hover:text-primary-700">Aktiviteler</a>
    </li>
    <li class="flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
        <span class="text-gray-600 dark:text-gray-400">Taglenmemiş</span>
    </li>
@endsection

@section('content')
<div class="card">
    <div class="card-header border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h5 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="fas fa-exclamation-circle text-orange-500"></i>
                    Taglenmemiş Aktivite Listesi
                </h5>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('activities.auto-tag') }}" class="btn btn-primary text-sm shadow-lg hover:shadow-xl transition-shadow">
                    <i class="fas fa-magic mr-1"></i> Otomatik Tagleme
                </a>
                <a href="{{ route('activities.index') }}" class="btn btn-secondary text-sm">
                    <i class="fas fa-list mr-1"></i> Tümü
                </a>
                <a href="{{ route('activities.tagged') }}" class="btn btn-success text-sm text-white">
                    <i class="fas fa-check-circle mr-1"></i> Taglenmiş
                </a>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        @if($totalCount > 0)
            <div class="flex items-center p-4 mb-6 bg-orange-50 border-l-4 border-orange-500 dark:bg-orange-900/20 rounded-r-lg">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-orange-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-orange-700 dark:text-orange-300">
                        Şu anda <strong>{{ number_format($totalCount) }}</strong> aktivite kategorize edilmeyi bekliyor.
                        <a href="{{ route('activities.auto-tag') }}" class="font-bold underline hover:text-orange-900 dark:hover:text-orange-100 ml-1">
                            Otomatik tagleme başlatın
                        </a>
                    </p>
                </div>
            </div>
        @else
            <div class="flex items-center p-4 mb-6 bg-green-50 border-l-4 border-green-500 dark:bg-green-900/20 rounded-r-lg">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700 dark:text-green-300 font-medium">
                        Harika! Tüm aktiviteler kategorize edilmiş durumda.
                    </p>
                </div>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="table" id="untaggedActivitiesTable">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="text-left font-semibold text-gray-600 dark:text-gray-400">Kullanıcı</th>
                        <th class="text-left font-semibold text-gray-600 dark:text-gray-400">Process Name</th>
                        <th class="text-left font-semibold text-gray-600 dark:text-gray-400">Başlık</th>
                        <th class="text-left font-semibold text-gray-600 dark:text-gray-400">URL</th>
                        <th class="text-left font-semibold text-gray-600 dark:text-gray-400">Süre</th>
                        <th class="text-left font-semibold text-gray-600 dark:text-gray-400">Zaman</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($activities as $activity)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                <i class="fas fa-user mr-1 text-xs"></i> {{ $activity->username }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <code class="text-xs bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded text-pink-600 dark:text-pink-400 font-mono">
                                {{ Str::limit($activity->process_name, 30) }}
                            </code>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                            {{ Str::limit($activity->title, 50) }}
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-500">
                            @if($activity->url)
                                <a href="#" class="hover:text-primary-600 truncate block max-w-xs" title="{{ $activity->url }}">
                                    {{ Str::limit($activity->url, 40) }}
                                </a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm font-mono text-gray-600 dark:text-gray-400">
                            {{ $activity->duration_formatted }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500" data-order="{{ $activity->start_time_utc->timestamp }}">
                            {{ $activity->start_time_utc->format('d.m.Y H:i') }}
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
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#untaggedActivitiesTable').DataTable({
            "pageLength": 50,
            "order": [[5, 'desc']],
            "language": { "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json" },
            "responsive": true
        });
    });
</script>
@endsection
