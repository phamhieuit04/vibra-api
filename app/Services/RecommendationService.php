<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RecommendationService
{
    public static function recommendSongsForUser($userId, $limit = 10)
    {
        $userHistory = DB::table('user_listen_history')
            ->where('user_id', $userId)
            ->pluck('times', 'song_id');

        if ($userHistory->isEmpty())
            return collect();

        $otherUsers = DB::table('user_listen_history')
            ->select('user_id')
            ->where('user_id', '!=', $userId)
            ->distinct()
            ->pluck('user_id');

        $similarities = [];

        foreach ($otherUsers as $otherId) {
            $otherHistory = DB::table('user_listen_history')
                ->where('user_id', $otherId)
                ->pluck('times', 'song_id');

            $common = $userHistory->intersectByKeys($otherHistory);
            if ($common->isEmpty())
                continue;

            $dot = 0;
            $userNorm = 0;
            $otherNorm = 0;
            foreach ($common as $songId => $times) {
                $dot += $times * $otherHistory[$songId];
                $userNorm += pow($times, 2);
                $otherNorm += pow($otherHistory[$songId], 2);
            }

            $den = sqrt($userNorm) * sqrt($otherNorm);
            $sim = $den ? $dot / $den : 0;
            $similarities[$otherId] = $sim;
        }

        if (empty($similarities))
            return collect();

        $weightedScores = [];
        $simSums = [];

        foreach ($similarities as $otherId => $sim) {
            $songs = DB::table('user_listen_history')
                ->where('user_id', $otherId)
                ->whereNotIn('song_id', $userHistory->keys())
                ->pluck('times', 'song_id');

            foreach ($songs as $songId => $times) {
                $weightedScores[$songId] = ($weightedScores[$songId] ?? 0) + $sim * $times;
                $simSums[$songId] = ($simSums[$songId] ?? 0) + $sim;
            }
        }

        foreach ($weightedScores as $songId => $score) {
            $weightedScores[$songId] = $score / ($simSums[$songId] ?: 1);
        }

        arsort($weightedScores);
        $songIds = array_slice(array_keys($weightedScores), 0, $limit);

        return DB::table('songs')->whereIn('id', $songIds)->get();
    }
}