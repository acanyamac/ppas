@extends('layouts.master')

@section('title', 'Taglenmiş Aktiviteler')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
@endsection

@section('breadcrumb-title')
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Taglenmiş Aktiviteler</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kategorize edilmiş kullanıcı aktiviteleri</p>
    </div>
@endsection

@section('breadcrumb-items')
    <li class="flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
        <a href="{{ route('activities.index') }}" class="text-primary-600 hover:text-primary-700">Aktiviteler</a>
    </li>
    <li class="flex items-center">
        <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
        <span class="text-gray-600 dark:text-gray-400">Taglenmiş</span>
    </li>
@endsection

@section('content')
<div class="card">
    <div class="card-header border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h5 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    Taglenmiş Aktivite Listesi
                </h5>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('activities.index') }}" class="btn btn-secondary text-sm">
                    <i class="fas fa-list mr-1"></i> Tümü
                </a>
                <a href="{{ route('activities.untagged') }}" class="btn btn-warning text-sm text-white">
                    <i class="fas fa-exclamation-circle mr-1"></i> Taglenmemiş
                </a>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <div class="overflow-x-auto">
            <table class="table" id="taggedActivitiesTable">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="text-left font-semibold text-gray-600 dark:text-gray-400">Kullanıcı</th>
                        <th class="text-left font-semibold text-gray-600 dark:text-gray-400">Process Name</th>
                        <th class="text-left font-semibold text-gray-600 dark:text-gray-400">Başlık</th>
                        <th class="text-left font-semibold text-gray-600 dark:text-gray-400">Kategoriler</th>
                        <th class="text-left font-semibold text-gray-600 dark:text-gray-400">Güven Skoru</th>
                        <th class="text-left font-semibold text-gray-600 dark:text-gray-400">Tip</th>
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
                                {{ Str::limit($activity->process_name, 25) }}
                            </code>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                            {{ Str::limit($activity->title, 40) }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-1">
                                @foreach($activity->categories as $category)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300" 
                                          title="{{ $category->pivot->matched_keyword ?? '' }}">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @php $avgScore = $activity->categories->avg('pivot.confidence_score') ?? 0; @endphp
                            <div class="flex items-center gap-2">
                                <div class="w-16 bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full {{ $avgScore >= 80 ? 'bg-green-500' : ($avgScore >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                         style="width: {{ $avgScore }}%"></div>
                                </div>
                                <span class="text-xs font-bold {{ $avgScore >= 80 ? 'text-green-600' : ($avgScore >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                    %{{ number_format($avgScore, 0) }}
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @php $isManual = $activity->categories->first()?->pivot->is_manual ?? false; @endphp
                            @if($isManual)
                                <span class="text-xs text-purple-600 dark:text-purple-400 font-medium">
                                    <i class="fas fa-hand-pointer mr-1"></i> Manuel
                                </span>
                            @else
                                <span class="text-xs text-green-600 dark:text-green-400 font-medium">
                                    <i class="fas fa-magic mr-1"></i> Otomatik
                                </span>
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
        $('#taggedActivitiesTable').DataTable({
            "pageLength": 50,
            "order": [[7, 'desc']], 
            "language": { "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json" },
            "responsive": true
        });
    });
</script>
@endsection
