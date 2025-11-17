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
        $params = $request->all();
        $userId = Auth::id();
        $songs = RecommendationService::recommendSongsForUser($userId);

        if (!$songs) {
            $categories = UserInterestedIn::select('category_id')
                ->where('user_id', $userId)
                ->orderBy('created_at', 'DESC')->first();
            $categories = explode(',', $categories['category_id']);
            $songs = Song::with('author')
                ->whereIn('category_id', $categories)->limit(10)->get();
        }

        FileHelper::getSongsUrl($songs);

        return ApiResponse::success($songs);
    }
}
