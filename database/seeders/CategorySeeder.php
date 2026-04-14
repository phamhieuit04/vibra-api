<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    private $names = [
        'Pop',
        'Rock',
        'Hip Hop',
        'Jazz',
        'Classical',
        'Electronic',
        'Anime',
        'Country',
        'Blues',
        'R&B',
        'Nhạc Đỏ',
        'Nhạc Vàng',
        'Nhạc Cách Mạng',
        'Nhạc Trữ Tình',
        'Nhạc Bolero',
        'Nhạc Hải Ngoại',
        'Nhạc Thiếu Nhi'
    ];

    private $descriptions = [
        'Thể loại phổ biến với giai điệu bắt tai, ca từ đơn giản và dễ nghe.',
        'Thể loại mạnh mẽ với âm thanh guitar điện và trống đặc trưng, thường thể hiện cảm xúc mãnh liệt.',
        'Thể loại giàu nhịp điệu và lời rap, thể hiện câu chuyện và cảm xúc cá nhân.',
        'Thể loại ngẫu hứng với nhạc cụ sống động như saxophone, thường mang sắc thái thư giãn hoặc phức tạp.',
        'Âm nhạc bác học với cấu trúc tinh tế, thường được trình diễn bởi dàn nhạc cổ điển.',
        'Thể loại sử dụng âm thanh điện tử và beat lặp lại, phổ biến trong các lễ hội và câu lạc bộ đêm.',
        'Thể loại mang phong cách wibu, với nhịp điều và lời hát cảm xúc, như kể câu chuyện đầy xúc cảm của bản thân',
        'Thể loại âm nhạc truyền thống Mỹ, thường kể chuyện qua lời ca mộc mạc và giai điệu dịu dàng.',
        'Thể loại sâu lắng và đầy cảm xúc, khởi nguồn từ cộng đồng người Mỹ gốc Phi ở miền Nam nước Mỹ.',
        'Thể loại pha trộn giữa soul, funk và pop, nổi bật với giọng hát đầy nội lực và cảm xúc.',
        'Dòng nhạc cách mạng mang âm hưởng hào hùng, ngợi ca Tổ quốc, lý tưởng và tinh thần chiến đấu của dân tộc Việt Nam.',
        'Dòng nhạc miền Nam trước 1975 với giai điệu buồn man mác, lời ca trữ tình về tình yêu, quê hương và thân phận.',
        'Dòng nhạc ra đời trong thời kỳ kháng chiến, mang âm hưởng hùng tráng, thể hiện tinh thần yêu nước và đấu tranh.',
        'Dòng nhạc nhẹ nhàng, sâu lắng với giai điệu và lời ca đậm chất thơ, thường nói về tình yêu và cuộc sống.',
        'Dòng nhạc Nam Bộ mộc mạc, tha thiết với nhịp điệu chậm rãi, thường gắn với hình ảnh sông nước và tình cảm đôi lứa.',
        'Dòng nhạc Việt được sáng tác và trình bày bởi cộng đồng người Việt ở nước ngoài, mang nỗi nhớ quê hương da diết.',
        'Dòng nhạc trong sáng, vui tươi dành cho trẻ em với giai điệu đơn giản, dễ nhớ và lời ca hồn nhiên.'
    ];

    private $thumbnails = [
        '/pop.jpg',
        '/rock.jpg',
        '/hiphop.jpg',
        '/jazz.jpg',
        '/classical.jpg',
        '/electronic.jpg',
        '/anime.jpg',
        '/country.jpg',
        '/blues.jpg',
        '/r&b.jpg',
        '/nhacdo.jpg',
        '/nhacvang.jpg',
        '/nhaccachmang.jpg',
        '/nhactrutinh.jpg',
        '/nhacbolero.jpg',
        '/nhachaingoai.jpg',
        '/nhacthieunhi.jpg'
    ];

    public function run(): void
    {
        for ($i = 0; $i < count($this->names); $i++) {
            DB::table('categories')->insert([
                'name'        => $this->names[$i],
                'description' => $this->descriptions[$i] ?? "",
                'thumbnail'   => $this->thumbnails[$i] ?? "",
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ]);
        }
    }
}