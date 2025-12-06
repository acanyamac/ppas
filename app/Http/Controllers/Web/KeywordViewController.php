<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\KeywordService;
use App\Models\Category;
use App\Models\CategoryKeyword;
use App\Models\KeywordOverride;
use App\Models\Unit;
use App\Models\ComputerUser;
use Illuminate\Http\Request;

class KeywordViewController extends Controller
{
    protected $keywordService;

    public function __construct(KeywordService $keywordService)
    {
        $this->keywordService = $keywordService;
    }

    public function index()
    {
        // Eager load overrides count
        $keywords = CategoryKeyword::with('category')->withCount('overrides')->orderBy('priority', 'desc')->get();
        $categories = Category::active()->get();
        return view('performance.keywords.index', compact('keywords', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('performance.keywords.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'keyword' => 'required|string|max:255',
            'match_type' => 'required|in:exact,contains,starts_with,ends_with,regex',
            'priority' => 'required|integer|min:1|max:10',
        ]);

        $this->keywordService->create($request->all());

        return redirect()->route('keywords.index')
            ->with('success', 'Keyword başarıyla oluşturuldu.');
    }

    public function edit(string $id)
    {
        $keyword = CategoryKeyword::with(['overrides.category', 'overrides.unit', 'overrides.computerUser'])
            ->findOrFail($id);
            
        $categories = Category::active()->get();
        $units = Unit::orderBy('name')->get();
        $computerUsers = ComputerUser::orderBy('name')->get(); // name null olabilir gerçi
        
        return view('performance.keywords.edit', compact('keyword', 'categories', 'units', 'computerUsers'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'keyword' => 'required|string|max:255',
            'match_type' => 'required|in:exact,contains,starts_with,ends_with,regex',
            'priority' => 'required|integer|min:1|max:10',
        ]);

        $this->keywordService->update($id, $request->all());

        return redirect()->route('keywords.index')
            ->with('success', 'Keyword başarıyla güncellendi.');
    }

    public function destroy(string $id)
    {
        $this->keywordService->delete($id);

        return redirect()->route('keywords.index')
            ->with('success', 'Keyword başarıyla silindi.');
    }
    
    /**
     * Keyword Override Ekleme
     */
    public function storeOverride(Request $request, $keywordId)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:unit,user',
            'unit_id' => 'required_if:type,unit|nullable|exists:units,id',
            'computer_user_id' => 'required_if:type,user|nullable|exists:computer_users,id',
        ]);

        if ($request->type === 'unit') {
             KeywordOverride::updateOrCreate(
                ['keyword_id' => $keywordId, 'unit_id' => $request->unit_id],
                ['category_id' => $request->category_id, 'computer_user_id' => null]
             );
        } else {
            KeywordOverride::updateOrCreate(
                ['keyword_id' => $keywordId, 'computer_user_id' => $request->computer_user_id],
                ['category_id' => $request->category_id, 'unit_id' => null]
             );
        }

        return back()->with('success', 'İstisna başarıyla kaydedildi.');
    }

    /**
     * Keyword Override Silme
     */
    public function destroyOverride($id)
    {
        KeywordOverride::destroy($id);
        return back()->with('success', 'İstisna silindi.');
    }

    public function test()
    {
        return view('performance.keywords.test');
    }

    public function import()
    {
        return view('performance.keywords.import');
    }

    public function importPost(Request $request)
    {
        $request->validate([
            'keywords' => 'required|array',
        ]);

        $result = $this->keywordService->bulkImport($request->get('keywords'));

        return redirect()->route('keywords.index')
            ->with('success', "Toplu import tamamlandı. Başarılı: {$result['success']}, Başarısız: {$result['failed']}");
    }
}
