<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\CategoryKeyword;
use Illuminate\Support\Facades\Log;

class AutoTaggingService
{
    /**
     * Tek bir aktiviteyi otomatik tagler
     * 
     * @param int $activityId
     * @return array Tagleme sonuçları
     */
    public function tagActivity(int $activityId): array
    {
        $activity = Activity::find($activityId);
        
        if (!$activity) {
            return [
                'success' => false,
                'message' => 'Aktivite bulunamadı',
            ];
        }
        
        $matches = $this->matchKeywords($activity);
        
        if (empty($matches)) {
            return [
                'success' => true,
                'message' => 'Eşleşen keyword bulunamadı',
                'tagged_count' => 0,
            ];
        }
        
        $taggedCount = 0;
        
        foreach ($matches as $match) {
            // Bu kategoriye zaten taglenmiş mi kontrol et
            if (!$activity->categories()->where('category_id', $match['category_id'])->exists()) {
                $activity->categories()->attach($match['category_id'], [
                    'matched_keyword' => $match['keyword'],
                    'match_type' => $match['match_type'],
                    'confidence_score' => $match['confidence_score'],
                    'is_manual' => false,
                    'tagged_at' => now(),
                ]);
                
                $taggedCount++;
            }
        }
        
        Log::info("Aktivite taglendi", [
            'activity_id' => $activityId,
            'tagged_count' => $taggedCount,
            'matches' => $matches,
        ]);
        
        return [
            'success' => true,
            'message' => "{$taggedCount} kategoriye taglendi",
            'tagged_count' => $taggedCount,
            'matches' => $matches,
        ];
    }

    /**
     * Taglenmemiş aktiviteleri toplu olarak tagler
     * 
     * @param int $limit Maksimum kaç aktivite tagleneceği
     * @return array İstatistikler
     */
    public function tagUntaggedActivities(int $limit = 100): array
    {
        $activities = Activity::untagged()->limit($limit)->get();
        
        $totalTagged = 0;
        $totalProcessed = 0;
        
        foreach ($activities as $activity) {
            $result = $this->tagActivity($activity->id);
            $totalProcessed++;
            
            if ($result['success'] && $result['tagged_count'] > 0) {
                $totalTagged++;
            }
        }
        
        return [
            'processed' => $totalProcessed,
            'tagged' => $totalTagged,
            'skipped' => $totalProcessed - $totalTagged,
        ];
    }

    /**
     * Aktivite için keyword eşleştirme yapar
     * 
     * @param Activity $activity
     * @return array Eşleşen keyword'ler ve kategoriler
     */
    protected function matchKeywords(Activity $activity): array
    {
        $matches = [];
        
        // Tüm aktif keyword'leri priority'ye göre getir
        $keywords = CategoryKeyword::with('category')
            ->active()
            ->byPriority()
            ->get();
        
        foreach ($keywords as $keyword) {
            $matched = false;
            $matchedField = null;
            
            // Process name'de kontrol et
            if ($activity->process_name && $keyword->matches($activity->process_name)) {
                $matched = true;
                $matchedField = 'process_name';
            }
            
            // Title'da kontrol et
            if (!$matched && $activity->title && $keyword->matches($activity->title)) {
                $matched = true;
                $matchedField = 'title';
            }
            
            // URL'de kontrol et (browser aktiviteleri için)
            if (!$matched && $activity->url && $keyword->matches($activity->url)) {
                $matched = true;
                $matchedField = 'url';
            }
            
            if ($matched) {
                // Bu kategoriye daha önce eşleşme eklenmemiş mi kontrol et
                $categoryAlreadyMatched = false;
                foreach ($matches as $existingMatch) {
                    if ($existingMatch['category_id'] === $keyword->category_id) {
                        $categoryAlreadyMatched = true;
                        break;
                    }
                }
                
                // Eğer bu kategori için daha yüksek priority'li eşleşme yoksa ekle
                if (!$categoryAlreadyMatched) {
                    $matches[] = [
                        'category_id' => $keyword->category_id,
                        'category_name' => $keyword->category->name,
                        'keyword' => $keyword->keyword,
                        'match_type' => $keyword->match_type,
                        'matched_field' => $matchedField,
                        'confidence_score' => $keyword->getConfidenceScore(),
                        'priority' => $keyword->priority,
                    ];
                }
            }
        }
        
        return $matches;
    }

    /**
     * Güven skoru hesaplama
     * 
     * @param string $matchType
     * @return float
     */
    protected function calculateConfidenceScore(string $matchType): float
    {
        return match($matchType) {
            'exact' => 100.0,
            'contains' => 80.0,
            'starts_with' => 70.0,
            'ends_with' => 70.0,
            'regex' => 60.0,
            default => 50.0,
        };
    }
}
