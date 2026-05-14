<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowSeeder extends Seeder
{
    public function run(): void
    {
        $artistIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $userIds = [13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33];

        $follows = [];

        foreach ($userIds as $userId) {
            $followCount = rand(2, 5);
            $randomArtists = array_rand(array_flip($artistIds), $followCount);

            if (!is_array($randomArtists)) {
                $randomArtists = [$randomArtists];
            }

            foreach ($randomArtists as $artistId) {
                $follows[] = [
                    'user_id' => $userId,
                    'artist_id' => $artistId,
                    'playlist_id' => null,
                    'song_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('libraries')->insert($follows);
    }
}
