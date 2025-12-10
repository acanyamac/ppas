<?php

namespace App\Http\Controllers;
use App\Models\Entity;
use App\Models\GapAnalysis;
use App\Models\Audits\Audit;
use App\Models\SurveyResult;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Services\StatisticsService;
use App\Models\Activity;
use App\Models\Category;
use App\Models\CategoryKeyword;

class DashboardController extends Controller
{
    protected $categoryService;
    protected $statisticsService;

    public function __construct(CategoryService $categoryService, StatisticsService $statisticsService)
    {
        $this->categoryService = $categoryService;
        $this->statisticsService = $statisticsService;
    }

    public function index()
    {
        // İstatistik kartları için veriler (Süre bazlı - Saat)
        $totalCategories = Category::count();
        $totalKeywords = CategoryKeyword::count();
        $totalActivities = Activity::count();
        
        $totalDuration = Activity::sum('duration_ms');
        $taggedDuration = Activity::tagged()->sum('duration_ms');
        $untaggedDuration = Activity::untagged()->sum('duration_ms');
        
        $taggedActivities = round($taggedDuration / (1000 * 60 * 60), 2); // Saat
        $untaggedActivities = round($untaggedDuration / (1000 * 60 * 60), 2); // Saat
        $totalHours = round($totalDuration / (1000 * 60 * 60), 2);
        
        $taggingRate = $totalDuration > 0 ? round(($taggedDuration / $totalDuration) * 100, 2) : 0;

        // Son 7 günlük çoklu trend (Tagged vs Untagged vs Total)
        $last7Days = [];
        $last7DaysTagged = [];
        $last7DaysUntagged = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $totalDaily = Activity::whereDate('start_time_utc', $date)->sum('duration_ms');
            $taggedDaily = Activity::tagged()->whereDate('start_time_utc', $date)->sum('duration_ms');
            $untaggedDaily = Activity::untagged()->whereDate('start_time_utc', $date)->sum('duration_ms');
            
            $last7Days[] = [
                'date' => $date,
                'count' => round($totalDaily / (1000 * 60 * 60), 2),
            ];
            $last7DaysTagged[] = round($taggedDaily / (1000 * 60 * 60), 2);
            $last7DaysUntagged[] = round($untaggedDaily / (1000 * 60 * 60), 2);
        }

        // Son 30 günlük trend (Sadece İş Kategorisi)
        $last30Days = [];
        $workCategories = Category::where('type', 'work')->pluck('id');
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dailyDuration = Activity::whereDate('start_time_utc', $date)
                ->whereHas('categories', function($query) use ($workCategories) {
                    $query->whereIn('categories.id', $workCategories);
                })
                ->sum('duration_ms');
            $last30Days[] = [
                'date' => $date,
                'count' => round($dailyDuration / (1000 * 60 * 60), 2),
            ];
        }

        // Saatlik dağılım (24 saat - Sadece İş Kategorisi)
        $hourlyDistribution = [];
        for ($hour = 0; $hour < 24; $hour++) {
            $hourlyDuration = Activity::whereRaw('HOUR(start_time_utc) = ?', [$hour])
                ->whereHas('categories', function($query) use ($workCategories) {
                    $query->whereIn('categories.id', $workCategories);
                })
                ->sum('duration_ms');
            $hourlyDistribution[] = round($hourlyDuration / (1000 * 60 * 60), 2);
        }

        // İş/Diğer oranı
        $workOtherRatio = $this->statisticsService->getWorkOtherRatio();

        // En çok kullanılan kategoriler (top 8)
        $topCategories = $this->statisticsService->getCategoryStatistics([], 8);
        $topCategories = collect($topCategories['categories']);

        // En çok kullanılan keywords (top 10)
        // Keywords ile eşleşen aktivitelerin sayısına göre sıralama
        $topKeywords = CategoryKeyword::with('category')
            ->active()
            ->get()
            ->map(function($keyword) {
                // Her keyword için eşleşen aktivite sayısını hesapla
                $matchCount = Activity::where(function($query) use ($keyword) {
                    $query->where('process_name', 'LIKE', '%' . $keyword->keyword . '%')
                          ->orWhere('title', 'LIKE', '%' . $keyword->keyword . '%');
                })->count();
                
                $keyword->match_count = $matchCount;
                return $keyword;
            })
            ->sortByDesc('match_count')
            ->take(10);

        // En çok kullanılan process'ler (top 10)
        $topProcesses = Activity::select('process_name')
            ->selectRaw('COUNT(*) as activity_count')
            ->selectRaw('SUM(duration_ms) as total_duration')
            ->groupBy('process_name')
            ->orderByDesc('total_duration')
            ->limit(10)
            ->get()
            ->map(function($item) {
                $item->total_hours = round($item->total_duration / (1000 * 60 * 60), 2);
                return $item;
            });

        // Son taglenmiş aktiviteler
        $recentTaggedActivities = Activity::tagged()
            ->with('categories')
            ->orderBy('start_time_utc', 'desc')
            ->limit(10)
            ->get();

        // Bugünkü özet
        $todayStats = [
            'total' => round(Activity::whereDate('start_time_utc', today())->sum('duration_ms') / (1000 * 60 * 60), 2),
            'tagged' => round(Activity::tagged()->whereDate('start_time_utc', today())->sum('duration_ms') / (1000 * 60 * 60), 2),
            'activities' => Activity::whereDate('start_time_utc', today())->count(),
        ];

        return view('dashboard', compact(
            'totalCategories',
            'totalKeywords',
            'totalActivities',
            'totalHours',
            'taggedActivities',
            'untaggedActivities',
            'taggingRate',
            'last7Days',
            'last7DaysTagged',
            'last7DaysUntagged',
            'last30Days',
            'hourlyDistribution',
            'workOtherRatio',
            'topCategories',
            'topKeywords',
            'topProcesses',
            'recentTaggedActivities',
            'todayStats'
        ));
    }
}
