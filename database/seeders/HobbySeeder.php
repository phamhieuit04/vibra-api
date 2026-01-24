<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HobbySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hobbies = [
            'Vẽ tranh',
            'Đọc sách',
            'Đọc truyện tranh',
            'Xem phim',
            'Chơi game',
            'Nghe podcast',
            'Viết lách',
            'Tập gym',
            'Chạy bộ',
            'Thiền',
            'Học tập',
            'Làm việc',
            'Du lịch',
            'Nấu ăn'
        ];

        foreach ($hobbies as $hobby) {
            DB::table('hobbies')->updateOrInsert(
                [
                    'name' => $hobby,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
