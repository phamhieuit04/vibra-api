<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\UserInterestedIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterestedController extends Controller
{
    public function saveInterested(Request $request)
    {
        $params = $request->all();
        try {
            UserInterestedIn::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                ],
                [
                    'category_id' => $params['category_id'] ?? null,
                    'hobby_id' => $params['hobby_id'] ?? null,
                ]
            );

            return ApiResponse::success();
        } catch (\Throwable $th) {
            return ApiResponse::internalServerError();
        }
    }
}
