<?php

namespace App\Services;

use App\Models\Song;
use App\Models\UserInterestedIn;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class RecommendationService
{
    const MIN_LISTEN_COUNT_FOR_COLLABORATIVE = 20;
    const FULL_COLLABORATIVE_THRESHOLD = 50;

    private static $hobbyMusicMapping = [
        'Vẽ tranh' => ['moods' => ['chill', 'focus'], 'energy_range' => [2, 5], 'tempo_range' => [60, 95]],
        'Đọc sách' => ['moods' => ['focus', 'chill'], 'energy_range' => [1, 4], 'tempo_range' => [60, 85]],
        'Đọc truyện tranh' => ['moods' => ['happy', 'chill'], 'energy_range' => [3, 6], 'tempo_range' => [70, 100]],
        'Xem phim' => ['moods' => ['chill', 'romantic', 'epic'], 'energy_range' => [2, 7], 'tempo_range' => [70, 110]],
        'Chơi game' => ['moods' => ['energetic', 'epic', 'angry'], 'energy_range' => [6, 10], 'tempo_range' => [100, 150]],
        'Nghe podcast' => ['moods' => ['focus', 'chill'], 'energy_range' => [2, 5], 'tempo_range' => [65, 90]],
        'Viết lách' => ['moods' => ['focus', 'chill', 'romantic'], 'energy_range' => [2, 5], 'tempo_range' => [60, 90]],
        'Tập gym' => ['moods' => ['energetic', 'happy'], 'energy_range' => [7, 10], 'tempo_range' => [110, 160]],
        'Chạy bộ' => ['moods' => ['energetic', 'happy'], 'energy_range' => [7, 10], 'tempo_range' => [120, 160]],
        'Thiền' => ['moods' => ['chill'], 'energy_range' => [1, 3], 'tempo_range' => [50, 75]],
        'Học tập' => ['moods' => ['focus', 'chill'], 'energy_range' => [2, 5], 'tempo_range' => [60, 90]],
        'Làm việc' => ['moods' => ['focus', 'chill'], 'energy_range' => [3, 6], 'tempo_range' => [70, 100]],
        'Du lịch' => ['moods' => ['happy', 'energetic', 'chill'], 'energy_range' => [4, 8], 'tempo_range' => [80, 120]],
        'Nấu ăn' => ['moods' => ['happy', 'chill'], 'energy_range' => [4, 7], 'tempo_range' => [80, 110]]
    ];

    public static function recommendSongsForUser($userId, $limit = 10)
    {
        $totalListens = DB::table('user_listen_history')
            ->where('user_id', $userId)
            ->sum('times');

        $weights = self::calculateRecommendationWeights($totalListens);

        $collaborativeSongs = self::getCollaborativeRecommendations($userId, $limit * 2);
        $contentBasedSongs = self::getContentBasedRecommendations($userId, $limit * 2);

        $recommendations = self::mergeRecommendations(
            $collaborativeSongs,
            $contentBasedSongs,
            $weights,
            $limit
        );

        return $recommendations;
    }

    private static function calculateRecommendationWeights($totalListens)
    {
        if ($totalListens < self::MIN_LISTEN_COUNT_FOR_COLLABORATIVE) {
            return [
                'collaborative' => 0,
                'content_based' => 1
            ];
        } elseif ($totalListens < self::FULL_COLLABORATIVE_THRESHOLD) {
            $progress = ($totalListens - self::MIN_LISTEN_COUNT_FOR_COLLABORATIVE) /
                (self::FULL_COLLABORATIVE_THRESHOLD - self::MIN_LISTEN_COUNT_FOR_COLLABORATIVE);

            return [
                'collaborative' => $progress * 0.8,
                'content_based' => 1 - ($progress * 0.8)
            ];
        } else {
            return [
                'collaborative' => 0.9,
                'content_based' => 0.1
            ];
        }
    }

    private static function getCollaborativeRecommendations($userId, $limit)
    {
        $userHistory = DB::table('user_listen_history')
            ->where('user_id', $userId)
            ->pluck('times', 'song_id');

        if ($userHistory->isEmpty()) {
            return collect();
        }

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
            if ($common->isEmpty()) {
                continue;
            }

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

            if ($sim > 0.1) {
                $similarities[$otherId] = $sim;
            }
        }

        if (empty($similarities)) {
            return collect();
        }

        arsort($similarities);
        $topSimilarUsers = array_slice($similarities, 0, 50, true);

        $weightedScores = [];
        $simSums = [];

        foreach ($topSimilarUsers as $otherId => $sim) {
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

        $songs = Song::with('author')->whereIn('id', $songIds)->get();

        return $songs->map(function ($song) use ($weightedScores) {
            $song->recommendation_score = $weightedScores[$song->id] ?? 0;
            return $song;
        });
    }

    private static function getContentBasedRecommendations($userId, $limit)
    {
        $interests = UserInterestedIn::where('user_id', $userId)->first();

        if (!$interests) {
            return collect();
        }

        $categories = array_filter(explode(',', $interests->category_id ?? ''));
        $hobbyIds = array_filter(explode(',', $interests->hobby_id ?? ''));

        if (empty($categories)) {
            return collect();
        }

        $listenedSongIds = DB::table('user_listen_history')
            ->where('user_id', $userId)
            ->pluck('song_id');

        $query = Song::with('author')
            ->whereIn('category_id', $categories)
            ->whereNotIn('id', $listenedSongIds)
            ->where('status', 1);

        if (!empty($hobbyIds)) {
            $hobbyNames = DB::table('hobbies')
                ->whereIn('id', $hobbyIds)
                ->pluck('name');

            $allMoods = [];
            $energyRanges = [];
            $tempoRanges = [];

            foreach ($hobbyNames as $hobbyName) {
                if (isset(self::$hobbyMusicMapping[$hobbyName])) {
                    $mapping = self::$hobbyMusicMapping[$hobbyName];
                    $allMoods = array_merge($allMoods, $mapping['moods']);
                    $energyRanges[] = $mapping['energy_range'];
                    $tempoRanges[] = $mapping['tempo_range'];
                }
            }

            if (!empty($allMoods)) {
                $allMoods = array_unique($allMoods);
                $query->where(function ($q) use ($allMoods, $energyRanges, $tempoRanges) {
                    $q->whereIn('mood', $allMoods);

                    if (!empty($energyRanges)) {
                        $minEnergy = min(array_column($energyRanges, 0));
                        $maxEnergy = max(array_column($energyRanges, 1));
                        $q->orWhereBetween('energy', [$minEnergy, $maxEnergy]);
                    }

                    if (!empty($tempoRanges)) {
                        $minTempo = min(array_column($tempoRanges, 0));
                        $maxTempo = max(array_column($tempoRanges, 1));
                        $q->orWhereBetween('tempo', [$minTempo, $maxTempo]);
                    }
                });
            }
        }

        $songs = $query->inRandomOrder()
            ->limit($limit)
            ->get();

        return $songs->map(function ($song) use ($categories, $hobbyIds) {
            $score = 0;

            if (in_array($song->category_id, $categories)) {
                $score += 1.0;
            }

            if (!empty($hobbyIds)) {
                $hobbyNames = DB::table('hobbies')
                    ->whereIn('id', $hobbyIds)
                    ->pluck('name');

                foreach ($hobbyNames as $hobbyName) {
                    if (isset(self::$hobbyMusicMapping[$hobbyName])) {
                        $mapping = self::$hobbyMusicMapping[$hobbyName];

                        if (in_array($song->mood, $mapping['moods'])) {
                            $score += 0.5;
                        }

                        if (
                            $song->energy >= $mapping['energy_range'][0] &&
                            $song->energy <= $mapping['energy_range'][1]
                        ) {
                            $score += 0.3;
                        }

                        if (
                            $song->tempo >= $mapping['tempo_range'][0] &&
                            $song->tempo <= $mapping['tempo_range'][1]
                        ) {
                            $score += 0.2;
                        }
                    }
                }
            }

            $score += min(($song->total_played / 5000) * 0.3, 0.3);

            $song->recommendation_score = $score;
            return $song;
        });
    }

    private static function mergeRecommendations(
        Collection $collaborativeSongs,
        Collection $contentBasedSongs,
        array $weights,
        int $limit
    ) {
        $songScores = [];

        foreach ($collaborativeSongs as $song) {
            $songScores[$song->id] = [
                'song' => $song,
                'score' => ($song->recommendation_score ?? 0) * $weights['collaborative']
            ];
        }

        foreach ($contentBasedSongs as $song) {
            if (isset($songScores[$song->id])) {
                $songScores[$song->id]['score'] += ($song->recommendation_score ?? 0) * $weights['content_based'];
            } else {
                $songScores[$song->id] = [
                    'song' => $song,
                    'score' => ($song->recommendation_score ?? 0) * $weights['content_based']
                ];
            }
        }

        uasort($songScores, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        $recommendations = collect(array_slice($songScores, 0, $limit))
            ->map(function ($item) {
                unset($item['song']->recommendation_score);
                return $item['song'];
            });

        return $recommendations;
    }

    public static function getUserRecommendationStats($userId)
    {
        $totalListens = DB::table('user_listen_history')
            ->where('user_id', $userId)
            ->sum('times');

        $weights = self::calculateRecommendationWeights($totalListens);

        return [
            'total_listens' => $totalListens,
            'weights' => $weights,
            'recommendation_stage' => self::getRecommendationStage($totalListens)
        ];
    }

    private static function getRecommendationStage($totalListens)
    {
        if ($totalListens < self::MIN_LISTEN_COUNT_FOR_COLLABORATIVE) {
            return 'cold_start';
        } elseif ($totalListens < self::FULL_COLLABORATIVE_THRESHOLD) {
            return 'transitioning';
        } else {
            return 'mature';
        }
    }
}