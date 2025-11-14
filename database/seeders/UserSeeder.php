<?php

namespace Database\Seeders;

use App\Helpers\FileHelper;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    private $names = [
        'Kenshi Yonezu',
        'Yoasobi',
        'Billie Eilish',
        'Fujii Kaze',
        'Adele'
    ];

    private $emails = [
        'kenshi@gmail.com',
        'yoasobi@gmail.com',
        'billie@gmail.com',
        'fujikaze@gmail.com',
        'adele@gmail.com'
    ];

    private $descriptions = [
        'Kenshi Yonezu (米津玄師) là một nghệ sĩ đa tài người Nhật Bản: ca sĩ, nhạc sĩ, nhà sản xuất âm nhạc và họa sĩ minh họa...',
        'YOASOBI là một nhóm nhạc pop Nhật Bản gồm hai thành viên: Ayase và Ikura...',
        'Billie Eilish Pirate Baird O’Connell, sinh ngày 18/12/2001 tại Los Angeles, là một ca sĩ kiêm nhạc sĩ người Mỹ...',
        'Fujii Kaze là một nghệ sĩ trẻ tài năng người Nhật Bản, nổi bật với giọng hát nội lực và khả năng sáng tác sâu sắc...',
        'Adele là ca sĩ kiêm nhạc sĩ người Anh nổi tiếng với giọng hát đầy cảm xúc và phong cách soul, pop và blues...'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < count($this->names); $i++) {
            $user = new User;
            $user->email = $this->emails[$i];
            DB::table('users')->insert([
                'name' => $this->names[$i],
                'email' => $this->emails[$i],
                'description' => $this->descriptions[$i],
                'password' => Hash::make('12345678'),
                'avatar' => '/' . FileHelper::getNameFromEmail($user) . '.jpg',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        $faker = Faker::create('vi_VN');
        $records = [];

        for ($i = 0; $i < 20; $i++) {
            $fakeUser = (object) ['email' => $faker->unique()->safeEmail()];
            $records[] = [
                'name' => $faker->name(),
                'email' => $fakeUser->email,
                'description' => null,
                'password' => Hash::make('12345678'),
                'avatar' => '/' . FileHelper::getNameFromEmail($fakeUser) . '.jpg',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('users')->insert($records);
    }
}