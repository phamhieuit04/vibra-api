<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UserListenHistory extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = DB::table('users')->pluck('id')->toArray();
        $songIds = DB::table('songs')->pluck('id')->toArray();

        if (empty($userIds) || empty($songIds)) {
            return;
        }

        $records = [];

        foreach ($userIds as $userId) {
            $randomSongs = collect($songIds)->shuffle()->take(rand(5, count($songIds)));

            foreach ($randomSongs as $songId) {
                $records[] = [
                    'user_id' => $userId,
                    'song_id' => $songId,
                    'times' => rand(5, 100),
                    'created_at' => Carbon::now()->subDays(rand(0, 30)),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        for ($i = 0; $i < 400; $i++) {
            $records[] = [
                'user_id' => $userIds[array_rand($userIds)],
                'song_id' => $songIds[array_rand($songIds)],
                'times' => rand(1, 80),
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
                'updated_at' => Carbon::now(),
            ];
        }

        $chunks = array_chunk($records, 500);
        foreach ($chunks as $chunk) {
            DB::table('user_listen_history')->insert($chunk);
        }
    }
}