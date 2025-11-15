<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
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
        return ApiResponse::success($songs);
    }
}
