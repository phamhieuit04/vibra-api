<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\FileHelper;
use App\Models\DeviceToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $params = $request->all();
        try {
            Auth::attempt([
                'email' => $params['email'],
                'password' => $params['password']
            ]);
            $user = Auth::user();
            $user->token = $user->createToken(
                $user->email,
                ['*'],
                now()->addDays(7)
            )->plainTextToken;
            $user->avatar_path = FileHelper::getAvatar($user);

            return ApiResponse::success($user);
        } catch (\Throwable $th) {
            return ApiResponse::dataNotfound();
        }
    }

    public function signup(Request $request)
    {
        $params = $request->all();
        try {
            $user = User::create([
                'name' => explode('@', $params['email'])[0],
                'email' => $params['email'],
                'password' => Hash::make($params['password']),
                'avatar' => '/default.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            Storage::disk('public-api')->copy(
                'assets/avatars/default.jpg',
                'uploads/' . FileHelper::getNameFromEmail($user) . '/avatars/default.jpg'
            );

            return ApiResponse::success($user);
        } catch (\Throwable $th) {
            return ApiResponse::internalServerError();
        }
    }

    public function logout()
    {
        try {
            Auth::user()->tokens()->delete();
            DeviceToken::where('user_id', Auth::user()->id)->delete();

            return ApiResponse::success();
        } catch (\Throwable $th) {
            return ApiResponse::internalServerError();
        }
    }

    public function checkToken(Request $request)
    {
        $params = $request->all();
        [$id, $token] = explode('|', $params['token']);

        if (!$token) {
            return ApiResponse::unauthorized();
        }

        $hashedToken = hash('sha256', $token);

        $token = PersonalAccessToken::where('id', $id)
            ->where('token', $hashedToken)
            ->first();

        if (!$token) {
            return ApiResponse::unauthorized();
        }

        if ($token->expires_at && now()->greaterThan($token->expires_at)) {
            return ApiResponse::unauthorized();
        }

        $user = $token->tokenable;
        $user->avatar_path = FileHelper::getAvatar($user);
        
        return ApiResponse::success([
            $data = $user
        ]);
    }
}
