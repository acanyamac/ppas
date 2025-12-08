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
        
        $totalDuration = Activity::sum('duration_ms');
        $taggedDuration = Activity::tagged()->sum('duration_ms');
        $untaggedDuration = Activity::untagged()->sum('duration_ms');
        
        $taggedActivities = round($taggedDuration / (1000 * 60 * 60), 2); // Saat
        $untaggedActivities = round($untaggedDuration / (1000 * 60 * 60), 2); // Saat
        
        $taggingRate = $totalDuration > 0 ? round(($taggedDuration / $totalDuration) * 100, 2) : 0;

        // Son 7 günlük toplam süre trendi (Saat)
        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dailyDuration = Activity::whereDate('start_time_utc', $date)->sum('duration_ms');
            $last7Days[] = [
                'date' => $date,
                'count' => round($dailyDuration / (1000 * 60 * 60), 2),
            ];
        }

        // İş/Diğer oranı
        $workOtherRatio = $this->statisticsService->getWorkOtherRatio();

        // En çok kullanılan kategoriler (top 5)
        $topCategories = $this->statisticsService->getCategoryStatistics([], 5);
        $topCategories = collect($topCategories['categories']);

        // Son taglenmiş aktiviteler
        $recentTaggedActivities = Activity::tagged()
            ->with('categories')
            ->orderBy('start_time_utc', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalCategories',
            'totalKeywords',
            'taggedActivities',
            'untaggedActivities',
            'taggingRate',
            'last7Days',
            'workOtherRatio',
            'topCategories',
            'recentTaggedActivities'
        ));
    }
}
