<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Services\RecommendationService;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function getRecommendations(Request $request)
    {
        $params = $request->all();
        $userId = $params['user_id'];
        $songs = RecommendationService::recommendSongsForUser($userId);
        return ApiResponse::success($songs);
    }
}
