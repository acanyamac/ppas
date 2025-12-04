<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\KeywordService;
use App\Models\Category;
use App\Models\CategoryKeyword;
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
        $keywords = CategoryKeyword::with('category')->orderBy('priority', 'desc')->get();
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
        $keyword = CategoryKeyword::findOrFail($id);
        $categories = Category::active()->get();
        return view('performance.keywords.edit', compact('keyword', 'categories'));
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
