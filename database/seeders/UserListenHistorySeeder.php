<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UserListenHistorySeeder extends Seeder
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

        $totalSongs = count($songIds);
        $records = [];

        foreach ($userIds as $userId) {

            // Mỗi user chỉ nghe từ 10% đến 30% tổng số bài hát
            $listenCount = rand(
                intval($totalSongs * 0.10),
                intval($totalSongs * 0.30)
            );

            $randomSongs = collect($songIds)->shuffle()->take($listenCount);

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

        // Giữ nguyên logic của bạn: thêm 400 bản ghi phụ
        for ($i = 0; $i < 400; $i++) {
            $records[] = [
                'user_id' => $userIds[array_rand($userIds)],
                'song_id' => $songIds[array_rand($songIds)],
                'times' => rand(1, 80),
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
                'updated_at' => Carbon::now(),
            ];
        }

        // Insert theo chunks
        foreach (array_chunk($records, 500) as $chunk) {
            DB::table('user_listen_history')->insert($chunk);
        }
    }
}