<?php

namespace Database\Seeders;

use App\Models\Playlist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PlaylistSeeder extends Seeder
{
    private $names = [
        'Stray Sheep',
        'The book',
        'Happier than ever',
        'HELP EVER HURT NEVER',
        '25',
        'Thinhsuynghi',
        'Khát Vọng - Trọng Tấn',
        'Tuyển Tập Chế Linh',
        'Tuyển Tập Hương Lan',
        'Tình Ca Khánh Ly',
        'Dấu Tình Sầu - Tuấn Ngọc',
        'Tuyển Tập Sơn Tùng M-TP'
    ];

    private $descriptions = [
        'Được phát hành vào ngày 5 tháng 8 năm 2020. Tên của album được lấy cảm hứng từ New Testament.',
        'The Book là EP đầu tay của Yoasobi. Phát hành vào ngày 6 tháng 1 năm 2021, thông qua Sony Music Entertainment Japan, cùng ngày với đĩa đơn Kaibutsu, đi kèm với mùa thứ hai của Beastars.',
        'Là album phòng thu thứ hai của Billie Eilish được ra mắt vào ngày 30 tháng 7 năm 2021 bởi hãng đĩa Darkroom và Interscope Records.',
        'HELP EVER HURT NEVER là album phòng thu đầu tay của Fujii Kaze, phát hành vào ngày 20 tháng 5 năm 2020. Album gồm 11 ca khúc do chính anh sáng tác, thể hiện phong cách âm nhạc pha trộn độc đáo giữa pop, R&B, soul và funk.',
        '25 là album phòng thu thứ ba của Adele, phát hành vào ngày 20 tháng 11 năm 2015. Đây là một tác phẩm đánh dấu sự trở lại mạnh mẽ của cô sau thời gian vắng bóng để tập trung cho cuộc sống cá nhân.',
        'mô tả album thinhsuynghi',
        'Tuyển tập những ca khúc nhạc đỏ và cách mạng hào hùng được thể hiện qua giọng ca tenor vang khỏe của Trọng Tấn.',
        'Tuyển tập những ca khúc bolero và nhạc vàng bất hủ gắn liền với tên tuổi danh ca Chế Linh qua nhiều thập kỷ.',
        'Tuyển tập những bài nhạc vàng, bolero và dân ca Nam Bộ quen thuộc nhất của danh ca Hương Lan.',
        'Tuyển tập những ca khúc trữ tình sâu lắng gắn liền với tên tuổi danh ca Khánh Ly, đặc biệt là nhạc Trịnh Công Sơn.',
        'Tuyển tập các tình khúc hải ngoại sang trọng, đầy cảm xúc qua giọng ca vàng của Tuấn Ngọc.',
        'Tuyển tập những ca khúc pop nổi bật gắn liền với tên tuổi Sơn Tùng M-TP, từ ballad tình cảm đến các bản dance-pop sôi động.'
    ];

    public function run(): void
    {
        $from = count(Playlist::all());
        for ($i = $from; $i < count($this->names); $i++) {
            DB::table('playlists')->insert([
                'name' => $this->names[$i],
                'description' => $this->descriptions[$i],
                'author_id' => $i + 1,
                'thumbnail' => '/' . $this->names[$i] . ' thumbnail.jpg',
                'type' => 1,
                'total_song' => 2,
                'price' => 10000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 4; $i < 6; $i++) {
            $playlist = Playlist::find($i);
            $playlist->total_song = 1;
            $playlist->touch();
        }

        Playlist::whereKey(6)->update(['total_song' => 7]);
        Playlist::whereKey(7)->update(['total_song' => 3]);
        Playlist::whereKey(8)->update(['total_song' => 3]);
        Playlist::whereKey(9)->update(['total_song' => 3]);
        Playlist::whereKey(10)->update(['total_song' => 3]);
        Playlist::whereKey(11)->update(['total_song' => 3]);
    }
}