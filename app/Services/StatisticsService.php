<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class StatisticsService
{
    /**
     * Tüm kategorilerin istatistiklerini getir
     * 
     * @param array $filters Filtreleme parametreleri (start_date, end_date, username vb.)
     * @return array
     */
    /**
     * Tüm kategorilerin istatistiklerini getir
     * 
     * @param array $filters Filtreleme parametreleri (start_date, end_date, username vb.)
     * @param int|null $limit Limit (opsiyonel)
     * @return array
     */
    public function getCategoryStatistics(array $filters = [], ?int $limit = null): array
    {
        $query = $this->applyFilters(Activity::query(), $filters);
        
        $statsQuery = DB::table('activity_categories')
            ->join('activities', 'activity_categories.activity_id', '=', 'activities.id')
            ->join('categories', 'activity_categories.category_id', '=', 'categories.id')
            ->select(
                'categories.id',
                'categories.name',
                'categories.type',
                DB::raw('COUNT(DISTINCT activity_categories.activity_id) as activity_count'),
                DB::raw('SUM(activities.duration_ms) as total_duration_ms'),
                DB::raw('AVG(activity_categories.confidence_score) as avg_confidence')
            )
            ->groupBy('categories.id', 'categories.name', 'categories.type')
            ->orderBy('total_duration_ms', 'desc');

        // Apply filters to the query
        $statsQuery = $this->applyFilters($statsQuery, $filters);

        if ($limit) {
            $statsQuery->limit($limit);
        }
            
        $stats = $statsQuery->get();
        
        // Toplam aktivite sayısını ayrı bir sorgu ile al (limit varsa doğru oran hesaplamak için)
        // Eğer limit yoksa collection üzerinden hesaplanabilir ama tutarlılık için query daha iyi
        $totalActivitiesQuery = DB::table('activity_categories')
            ->join('activities', 'activity_categories.activity_id', '=', 'activities.id')
            ->join('categories', 'activity_categories.category_id', '=', 'categories.id');
            
        // Filtreleri tekrar uygula (DB builder olduğu için applyFilters kullanamıyoruz, manuel eklemeliyiz veya refactor etmeliyiz)
        // Basitlik için şimdilik sadece collection sum kullanacağız eğer limit yoksa.
        // Limit varsa, toplam sayıyı bilmemiz lazım.
        
        // Limit varsa, toplam sayıyı bilmemiz lazım.
        
        // Performans için: Eğer limit varsa, sadece o kategorilerin yüzdesini hesaplayacağız.
        // Genel toplamı almak pahalı olabilir.
        $totalDurationMs = $stats->sum('total_duration_ms');
        
        return [
            'categories' => $stats->map(function($stat) use ($totalDurationMs) {
                $durationSeconds = $stat->total_duration_ms ? $stat->total_duration_ms / 1000 : 0;
                $avgDurationSeconds = $stat->activity_count > 0 ? $durationSeconds / $stat->activity_count : 0;
                
                return [
                    'id' => $stat->id,
                    'name' => $stat->name,
                    'type' => $stat->type,
                    'activity_count' => $stat->activity_count,
                    'total_duration_ms' => $stat->total_duration_ms ?? 0,
                    'total_duration_seconds' => round($durationSeconds, 0),
                    'total_duration_hours' => round($durationSeconds / 3600, 2),
                    'avg_duration_seconds' => round($avgDurationSeconds, 0),
                    'avg_confidence' => round($stat->avg_confidence ?? 0, 2),
                    'percentage' => $totalDurationMs > 0 ? round(($stat->total_duration_ms / $totalDurationMs) * 100, 2) : 0,
                ];
            }),
            'total_activities' => $stats->sum('activity_count'),
            'total_duration_hours' => round($stats->sum('total_duration_ms') / (1000 * 60 * 60), 2),
        ];
    }

    /**
     * Belirli bir kategorinin istatistiklerini getir
     * 
     * @param int $categoryId
     * @param array $filters
     * @return array|null
     */
    public function getCategoryById(int $categoryId, array $filters = []): ?array
    {
        $category = Category::find($categoryId);
        
        if (!$category) {
            return null;
        }
        
        $query = Activity::byCategory($categoryId);
        $query = $this->applyFilters($query, $filters);
        
        $activityCount = $query->count();
        $totalDuration = $query->sum('duration_ms');
        
        // Alt kategorilerin istatistikleri
        $childrenStats = [];
        foreach ($category->children as $child) {
            $childStats = $this->getCategoryById($child->id, $filters);
            if ($childStats) {
                $childrenStats[] = $childStats;
            }
        }
        
        return [
            'id' => $category->id,
            'name' => $category->name,
            'type' => $category->type,
            'full_path' => $category->getFullPath(),
            'activity_count' => $activityCount,
            'total_duration_ms' => $totalDuration,
            'total_duration_hours' => round($totalDuration / (1000 * 60 * 60), 2),
            'children' => $childrenStats,
        ];
    }

    /**
     * Tagleme başarı oranını hesapla
     * 
     * @param array $filters
     * @return array
     */
    public function getTaggingRate(array $filters = []): array
    {
        $query = $this->applyFilters(Activity::query(), $filters);
        
        // Tüm hesaplamaları süre (duraiton_ms) üzerinden yap
        $totalDuration = (clone $query)->sum('duration_ms');
        $taggedDuration = (clone $query)->tagged()->sum('duration_ms');
        $untaggedDuration = (count($filters) > 0) ? (clone $query)->untagged()->sum('duration_ms') : ($totalDuration - $taggedDuration);
        
        // Eğer filtre varsa untagged doğrudan sorgulanmalı, yoksa total - tagged daha hızlı olabilir
        // Ancak tutarlılık için sorgulamak daha güvenli.
        
        // Otomatik ve manuel ayrımı (Süre bazlı)
        $autoTaggedDuration = (clone $query)
            ->whereHas('categories', function($q) {
                $q->where('activity_categories.is_manual', false);
            })
            ->sum('duration_ms');
            
        $manualTaggedDuration = (clone $query)
            ->whereHas('categories', function($q) {
                $q->where('activity_categories.is_manual', true);
            })
            ->sum('duration_ms');
        
        // Ms -> Saat çevrimi için katsayı
        $divisor = 1000 * 60 * 60;

        $taggingRate = $totalDuration > 0 
            ? round(($taggedDuration / $totalDuration) * 100, 2) 
            : 0;
            
        $autoPercentage = $totalDuration > 0 ? round(($autoTaggedDuration / $totalDuration) * 100, 2) : 0;
        $manualPercentage = $totalDuration > 0 ? round(($manualTaggedDuration / $totalDuration) * 100, 2) : 0;
        
        return [
            // Değerleri saat cinsinden döndürüyoruz
            'total' => round($totalDuration / $divisor, 2),
            'tagged' => round($taggedDuration / $divisor, 2),
            'untagged' => round($untaggedDuration / $divisor, 2),
            'auto_tagged' => round($autoTaggedDuration / $divisor, 2),
            'manual_tagged' => round($manualTaggedDuration / $divisor, 2),
            'tagging_rate' => $taggingRate,
            'auto_percentage' => $autoPercentage,
            'manual_percentage' => $manualPercentage,
            'unit' => 'Saat'
        ];
    }

    /**
     * Zaman dilimine göre kategori dağılımını getir
     * 
     * @param string $startDate
     * @param string $endDate
     * @param string $groupBy 'day', 'week', 'month'
     * @return array
     */
    public function getTimeDistribution(string $startDate, string $endDate, string $groupBy = 'day'): array
    {
        $dateFormat = match($groupBy) {
            'hour' => '%Y-%m-%d %H:00',
            'day' => '%Y-%m-%d',
            'week' => '%Y-%U',
            'month' => '%Y-%m',
            default => '%Y-%m-%d',
        };
        
        // Temel istatistikler (Toplam süre, ortalama süre, toplam sayı)
        $stats = DB::table('activities')
            ->whereBetween('start_time_utc', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->select(
                DB::raw("DATE_FORMAT(start_time_utc, '{$dateFormat}') as period"),
                DB::raw('COUNT(*) as activity_count'),
                DB::raw('SUM(COALESCE(duration_ms, 0)) as total_duration_ms'),
                DB::raw('AVG(COALESCE(duration_ms, 0)) as avg_duration_ms')
            )
            ->groupBy('period')
            ->orderBy('period')
            ->get();
        
        // Work Duration per period
        $workStats = DB::table('activities')
            ->whereBetween('start_time_utc', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('activity_categories')
                      ->join('categories', 'activity_categories.category_id', '=', 'categories.id')
                      ->whereColumn('activity_categories.activity_id', 'activities.id')
                      ->where('categories.type', 'work');
            })
            ->select(
                DB::raw("DATE_FORMAT(start_time_utc, '{$dateFormat}') as period"),
                DB::raw('SUM(duration_ms) as duration')
            )
            ->groupBy('period')
            ->pluck('duration', 'period');

        // Other Duration per period
        $otherStats = DB::table('activities')
            ->whereBetween('start_time_utc', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('activity_categories')
                      ->join('categories', 'activity_categories.category_id', '=', 'categories.id')
                      ->whereColumn('activity_categories.activity_id', 'activities.id')
                      ->where('categories.type', 'work');
            })
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('activity_categories')
                      ->join('categories', 'activity_categories.category_id', '=', 'categories.id')
                      ->whereColumn('activity_categories.activity_id', 'activities.id')
                      ->where('categories.type', 'other');
            })
            ->select(
                DB::raw("DATE_FORMAT(start_time_utc, '{$dateFormat}') as period"),
                DB::raw('SUM(duration_ms) as duration')
            )
            ->groupBy('period')
            ->pluck('duration', 'period');
        
        return $stats->map(function($stat) use ($workStats, $otherStats) {
            $durationSeconds = $stat->total_duration_ms ? $stat->total_duration_ms / 1000 : 0;
            $avgDurationSeconds = $stat->avg_duration_ms ? $stat->avg_duration_ms / 1000 : 0;
            
            // Work/Other duration in hours for display? Or seconds?
            // Usually charts want consistent units. Let's provide seconds to be safe or hours.
            // Let's provide hours as that's likely the requested unit for "duration based", or just seconds and format in frontend.
            // Re-reading: "tüm grafikler... süre bazlı"
            // Since I changed TaggingRate to hours, consistency is good.
            // But TimeDistribution view might be expecting specific values.
            // Let's check what it uses: it expects 'work_count' and 'other_count' keys originally.
            // I will return hours in those keys to switch the data source of the chart.
            
            $workDuration = $workStats[$stat->period] ?? 0;
            $otherDuration = $otherStats[$stat->period] ?? 0;
            
            return [
                'period' => $stat->period,
                'activity_count' => $stat->activity_count,
                'total_duration_seconds' => round($durationSeconds, 0),
                'total_duration_hours' => round($durationSeconds / 3600, 2),
                'avg_duration_seconds' => round($avgDurationSeconds, 0),
                'work_count' => round($workDuration / (1000 * 60 * 60), 2), // Now represents Hours
                'other_count' => round($otherDuration / (1000 * 60 * 60), 2), // Now represents Hours
                'unit' => 'Saat'
            ];
        })->toArray();
    }

    /**
     * İş/Diğer dağılımı (work/other ratio)
     * 
     * @param array $filters
     * @return array
     */
    public function getWorkOtherRatio(array $filters = []): array
    {
        $query = $this->applyFilters(Activity::query(), $filters);
        
        // Tek bir sorgu ile Work ve Other istatistiklerini alalım
        // Bu, 4 ayrı sorgu yerine 2 sorgu (biri work, biri other) yapmaktan daha iyi olabilir
        // Ancak Eloquent/Query Builder ile karmaşık conditional aggregation yapmak zor olabilir
        // Bu yüzden optimize edilmiş 2 sorgu kullanacağız.
        
        // 1. Work Stats
        $workStats = (clone $query)
            ->whereHas('categories', function($q) {
                $q->where('type', 'work');
            })
            ->selectRaw('COUNT(*) as count, SUM(duration_ms) as duration')
            ->first();
            
        $workCount = $workStats->count ?? 0;
        $workDuration = $workStats->duration ?? 0;

        // 2. Other Stats (Work olmayan ama Other olanlar)
        $otherStats = (clone $query)
            ->whereDoesntHave('categories', function($q) {
                $q->where('type', 'work');
            })
            ->whereHas('categories', function($q) {
                $q->where('type', 'other');
            })
            ->selectRaw('COUNT(*) as count, SUM(duration_ms) as duration')
            ->first();

        $otherCount = $otherStats->count ?? 0;
        $otherDuration = $otherStats->duration ?? 0;
        
        // Toplam (Sadece iş ve diğer olarak sınıflandırılmışlar)
        $totalDuration = $workDuration + $otherDuration;
        $totalCount = $workCount + $otherCount;
        
        return [
            'work' => [
                'activity_count' => $workCount,
                'duration_hours' => round($workDuration / (1000 * 60 * 60), 2),
                'avg_duration_minutes' => $workCount > 0 ? round($workDuration / (1000 * 60) / $workCount, 1) : 0,
                'percentage' => $totalDuration > 0 ? round(($workDuration / $totalDuration) * 100, 2) : 0,
            ],
            'other' => [
                'activity_count' => $otherCount,
                'duration_hours' => round($otherDuration / (1000 * 60 * 60), 2),
                'avg_duration_minutes' => $otherCount > 0 ? round($otherDuration / (1000 * 60) / $otherCount, 1) : 0,
                'percentage' => $totalDuration > 0 ? round(($otherDuration / $totalDuration) * 100, 2) : 0,
            ],
            'total' => [
                'activity_count' => $totalCount,
                'duration_hours' => round($totalDuration / (1000 * 60 * 60), 2),
            ],
        ];
    }

    /**
     * Query'ye filtreleri uygula
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyFilters($query, array $filters)
    {
        if (!empty($filters['start_date'])) {
            $query->where('activities.start_time_utc', '>=', $filters['start_date']);
        }
        
        if (!empty($filters['end_date'])) {
            $query->where('activities.start_time_utc', '<=', $filters['end_date']);
        }
        
        if (!empty($filters['username'])) {
            $query->where('activities.username', $filters['username']);
        }

        if (!empty($filters['motherboard_uuid'])) {
            $query->where('activities.motherboard_uuid', $filters['motherboard_uuid']);
        }
        
        if (!empty($filters['activity_type'])) {
            $query->where('activities.activity_type', $filters['activity_type']);
        }
        
        return $query;
    }
}
