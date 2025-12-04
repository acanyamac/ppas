<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\StatisticsService;
use App\Models\Category;
use Illuminate\Http\Request;

class StatisticsViewController extends Controller
{
    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    public function index(Request $request)
    {
        $filters = [
            'start_date' => $request->get('start_date', now()->subDays(30)->format('Y-m-d')),
            'end_date' => $request->get('end_date', now()->format('Y-m-d')),
            'user_id' => $request->get('user_id'),
        ];
        
        $statistics = $this->statisticsService->getCategoryStatistics($filters);
        $categories = Category::active()->get();
        
        return view('performance.statistics.index', compact('statistics', 'categories', 'filters'));
    }

    public function taggingRate(Request $request)
    {
        $filters = [
            'start_date' => $request->get('start_date', now()->subDays(30)->format('Y-m-d')),
            'end_date' => $request->get('end_date', now()->format('Y-m-d')),
        ];
        
        $taggingRate = $this->statisticsService->getTaggingRate($filters);
        
        return view('performance.statistics.tagging-rate', compact('taggingRate', 'filters'));
    }

    public function timeDistribution(Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(7)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $groupBy = $request->get('group_by', 'day');
        
        $distribution = $this->statisticsService->getTimeDistribution($startDate, $endDate, $groupBy);
        
        return view('performance.statistics.time-distribution', compact('distribution', 'startDate', 'endDate', 'groupBy'));
    }

    public function workOther(Request $request)
    {
        $filters = [
            'start_date' => $request->get('start_date', now()->subDays(30)->format('Y-m-d')),
            'end_date' => $request->get('end_date', now()->format('Y-m-d')),
        ];
        
        $workOtherRatio = $this->statisticsService->getWorkOtherRatio($filters);
        
        return view('performance.statistics.work-other', compact('workOtherRatio', 'filters'));
    }
}
