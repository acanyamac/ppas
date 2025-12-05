<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\AutoTaggingService;
use App\Models\Activity;
use App\Models\Category;
use Illuminate\Http\Request;

class ActivityViewController extends Controller
{
    protected $autoTaggingService;

    public function __construct(AutoTaggingService $autoTaggingService)
    {
        $this->autoTaggingService = $autoTaggingService;
    }

    public function index(Request $request)
    {
        $query = Activity::with('categories')->orderBy('start_time_utc', 'desc');
        
        // Kategori filtresi
        if ($request->has('category_id') && $request->category_id) {
            $query->byCategory($request->category_id);
        }
        
        $activities = $query->limit(1000)->get();
        $categories = Category::active()->get();
        
        return view('performance.activities.index', compact('activities', 'categories'));
    }

    public function tagged()
    {
        $activities = Activity::tagged()
            ->with('categories')
            ->orderBy('start_time_utc', 'desc')
            ->limit(1000)
            ->get();
        $categories = Category::active()->get();
        
        return view('performance.activities.tagged', compact('activities', 'categories'));
    }

    public function untagged()
    {
        $activities = Activity::untagged()
            ->orderBy('start_time_utc', 'desc')
            ->limit(1000)
            ->get();
        $categories = Category::active()->get();
        
        $totalCount = Activity::untagged()->count();
        
        return view('performance.activities.untagged', compact('activities', 'categories', 'totalCount'));
    }

    public function autoTagPage()
    {
        $untaggedCount = Activity::untagged()->count();
        $taggedCount = Activity::tagged()->count();
        $totalCount = Activity::count();
        
        return view('performance.activities.auto-tag', compact('untaggedCount', 'taggedCount', 'totalCount'));
    }

    public function autoTagRun(Request $request)
    {
        $limit = $request->get('limit', 100);
        
        $result = $this->autoTaggingService->tagUntaggedActivities($limit);
        
        return redirect()->route('activities.auto-tag')
            ->with('success', "Otomatik tagleme tamamlandı. İşlenen: {$result['processed']}, Taglenen: {$result['tagged']}");
    }

    public function show($id)
    {
        $activity = Activity::with('categories')->findOrFail($id);
        return view('performance.activities.show', compact('activity'));
    }
}
