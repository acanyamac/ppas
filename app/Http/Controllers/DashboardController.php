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
        // İstatistik kartları için veriler
        $totalCategories = Category::count();
        $totalKeywords = CategoryKeyword::count();
        $taggedActivities = Activity::tagged()->count();
        $untaggedActivities = Activity::untagged()->count();
        $totalActivities = Activity::count();
        $taggingRate = $totalActivities > 0 ? round(($taggedActivities / $totalActivities) * 100, 2) : 0;

        // Son 7 günlük aktivite trendi
        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $last7Days[] = [
                'date' => $date,
                'count' => Activity::whereDate('start_time_utc', $date)->count(),
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
