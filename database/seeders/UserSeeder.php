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
        'Adele',
        'Thịnh Suy',
        'Trọng Tấn',
        'Chế Linh',
        'Hương Lan',
        'Khánh Ly',
        'Tuấn Ngọc'
    ];

    private $emails = [
        'kenshi@gmail.com',
        'yoasobi@gmail.com',
        'billie@gmail.com',
        'fujikaze@gmail.com',
        'adele@gmail.com',
        'thinhsuy@gmail.com',
        'trongtan@gmail.com',
        'chelinh@gmail.com',
        'huonglan@gmail.com',
        'khanhlyvn@gmail.com',
        'tuanngoc@gmail.com'
    ];

    private $descriptions = [
        'Kenshi Yonezu (米津玄師) là một nghệ sĩ đa tài người Nhật Bản: ca sĩ, nhạc sĩ, nhà sản xuất âm nhạc và họa sĩ minh họa...',
        'YOASOBI là một nhóm nhạc pop Nhật Bản gồm hai thành viên: Ayase và Ikura...',
        'Billie Eilish Pirate Baird O"Connell, sinh ngày 18/12/2001 tại Los Angeles, là một ca sĩ kiêm nhạc sĩ người Mỹ...',
        'Fujii Kaze là một nghệ sĩ trẻ tài năng người Nhật Bản, nổi bật với giọng hát nội lực và khả năng sáng tác sâu sắc...',
        'Adele là ca sĩ kiêm nhạc sĩ người Anh nổi tiếng với giọng hát đầy cảm xúc và phong cách soul, pop và blues...',
        'Mô tả ca sĩ Thịnh Suy',
        'Trọng Tấn là ca sĩ nhạc đỏ và cách mạng hàng đầu Việt Nam, nổi bật với giọng tenor vang khỏe và cách thể hiện hào hùng, đầy cảm xúc.',
        'Chế Linh là danh ca nhạc vàng – bolero người Việt gốc Chăm, với giọng hát trầm ấm, da diết và sự nghiệp kéo dài hơn nửa thế kỷ.',
        'Hương Lan là nữ danh ca nhạc vàng – bolero và nhạc trữ tình quê hương, nổi tiếng với giọng hát trong trẻo, đậm chất miền Nam.',
        'Khánh Ly là nữ danh ca người Việt Nam, gắn liền với dòng nhạc trữ tình và nhạc Trịnh Công Sơn, sở hữu giọng hát đặc trưng sâu lắng, u buồn.',
        'Tuấn Ngọc là ca sĩ hải ngoại người Mỹ gốc Việt, được mệnh danh là "giọng ca vàng" của làng nhạc hải ngoại với phong cách trữ tình, sang trọng.'
    ];

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

        DB::table('users')->insert([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'description' => null,
            'password' => Hash::make('12345678'),
            'avatar' => '/',
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}