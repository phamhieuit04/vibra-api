<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\FileHelper;
use App\Models\Song;
use App\Models\UserInterestedIn;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function getRecommendations(Request $request)
    {
        $userId = Auth::id();
        $limit = $request->input('limit', 10);

        try {
            $songs = RecommendationService::recommendSongsForUser($userId, $limit);

            if ($songs->isEmpty()) {
                $songs = $this->getFallbackRecommendations($userId, $limit);
            }

            FileHelper::getSongsUrl($songs);

            return ApiResponse::success([
                'songs' => $songs,
                'stats' => RecommendationService::getUserRecommendationStats($userId)
            ]);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to get recommendations: ' . $e->getMessage(), 500);
        }
    }

    private function getFallbackRecommendations($userId, $limit)
    {
        $interests = UserInterestedIn::where('user_id', $userId)->first();

        if ($interests && $interests->category_id) {
            $categories = array_filter(explode(',', $interests->category_id));

            if (!empty($categories)) {
                return Song::with('author')
                    ->whereIn('category_id', $categories)
                    ->where('status', 1)
                    ->orderByDesc('total_played')
                    ->limit($limit)
                    ->get();
            }
        }

        return Song::with('author')
            ->where('status', 1)
            ->orderByDesc('total_played')
            ->limit($limit)
            ->get();
    }

    public function getRecommendationStats()
    {
        $userId = Auth::id();
        $stats = RecommendationService::getUserRecommendationStats($userId);

        return ApiResponse::success($stats);
    }

    public function updateInterests(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|string',
            'hobby_id' => 'nullable|string'
        ]);

        $userId = Auth::id();

        UserInterestedIn::updateOrCreate(
            ['user_id' => $userId],
            [
                'category_id' => $validated['category_id'],
                'hobby_id' => $validated['hobby_id'] ?? ''
            ]
        );

        return ApiResponse::success(['message' => 'Interests updated successfully']);
    }
}
