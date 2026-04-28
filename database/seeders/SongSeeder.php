<?php

namespace Database\Seeders;

use App\Models\Song;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SongSeeder extends Seeder
{
    private $names = [
        'Lemon',
        'Flamingo',
        'Halzion',
        'Gunjou',
        'My future',
        'Lost cause',
        'Shinunoga E-wa',
        'Send My Love',
        'Thắc mắc',
        'Tiny love',
        'Tình yêu xanh lá',
        'Mai mình xa',
        'Ca theo đàn',
        '20 năm ở thế giới',
        'Chết trong em',
        'Khát vọng',
        'Màu hoa đỏ',
        'Đất nước',
        'Thói đời',
        'Đêm buồn tỉnh lẻ',
        'Tình nghèo có nhau',
        'Hoa sứ nhà nàng',
        'Nỗi buồn hoa phượng',
        'Chiều mưa biên giới',
        'Diễm xưa',
        'Ướt mi',
        'Biển nhớ',
        'Dấu tình sầu',
        'Mưa nửa đêm',
        'Rồi mai tôi đưa em'
    ];
    private $sonTungSongNames = [
        'Hãy trao cho anh',
        'Lạc trôi',
        'Nơi này có anh',
        'Chạy ngay đi',
        'Chúng ta của hiện tại',
        'Có chắc yêu là đây',
        'Muộn rồi mà sao còn'
    ];

    private $sonTungDescriptions = [
        'Ca khúc dance-pop pha Latin pop mang năng lượng bùng nổ, đánh dấu giai đoạn Sơn Tùng M-TP mở rộng âm nhạc ra thị trường quốc tế.',
        'Bản future bass / pop mang màu sắc u tối, giai điệu cuốn và chất bay đặc trưng, một trong những ca khúc định hình phong cách của Sơn Tùng M-TP.',
        'Bản pop-ballad ngọt ngào, lãng mạn với giai điệu dễ nhớ và ca từ tỏ tình đầy cảm xúc, thuộc nhóm ca khúc được yêu thích nhất của Sơn Tùng M-TP.',
        'Ca khúc dance-pop sôi động với nhịp điệu dồn dập, mang tinh thần mạnh mẽ và bứt phá đặc trưng của Sơn Tùng M-TP.',
        'Bản pop-ballad hiện đại, nhẹ nhàng và tình cảm, kể về một mối quan hệ vừa gần gũi vừa nhiều day dứt.',
        'Ca khúc pop ballad ngọt ngào, trong sáng, được phối khí ấm áp và giàu cảm xúc yêu đương.',
        'Bản ballad buồn, tiết tấu chậm, giàu cảm xúc tiếc nuối và cô đơn trong tình yêu.'
    ];

    private $sonTungMoods = [
        'Hãy trao cho anh' => 'energetic',
        'Lạc trôi' => 'epic',
        'Nơi này có anh' => 'romantic',
        'Chạy ngay đi' => 'energetic',
        'Chúng ta của hiện tại' => 'romantic',
        'Có chắc yêu là đây' => 'romantic',
        'Muộn rồi mà sao còn' => 'sad'
    ];

    private $sonTungTempos = [
        'Hãy trao cho anh' => 128,
        'Lạc trôi' => 100,
        'Nơi này có anh' => 104,
        'Chạy ngay đi' => 126,
        'Chúng ta của hiện tại' => 84,
        'Có chắc yêu là đây' => 96,
        'Muộn rồi mà sao còn' => 72
    ];

    private $sonTungEnergies = [
        'Hãy trao cho anh' => 8,
        'Lạc trôi' => 6,
        'Nơi này có anh' => 5,
        'Chạy ngay đi' => 8,
        'Chúng ta của hiện tại' => 4,
        'Có chắc yêu là đây' => 5,
        'Muộn rồi mà sao còn' => 3
    ];

    private $descriptions = [
        'Phát hành dưới dạng đĩa đơn vào ngày 14 tháng 3 năm 2018. Bên cạnh đó, đây cũng chính là ca khúc chủ đề của bộ phim truyền hình đình đám Unnatural lên sóng cùng năm',
        'Yonezu bị ảnh hưởng bởi việc nhớ lại những điều từ khi anh ấy uống rượu. Bài hát được kể theo góc nhìn của một người tìm kiếm khoái lạc.',
        'Halzion dựa trên Soredemo, Happy End, một truyện ngắn do Hashizume Shunki viết, đánh dấu lần đầu tiên Yoasobi hợp tác với một tiểu thuyết gia chuyên nghiệp.',
        "Lấy cảm hứng từ bộ truyện tranh Blue Period của Tsubasa Yamaguchi, bài hát được mô tả là 'một bài hát cổ vũ truyền cảm hứng cho người nghe bằng cách đắm chìm vào những gì họ thích và thể hiện những gì họ thấy'.",
        "Một bản ballad R&B và ambient với ảnh hưởng của soul và jazz, lời bài hát đề cập đến một bài ca ngợi tình yêu bản thân và sức mạnh cá nhân.",
        "Eilish sử dụng phong cách hát ngân nga. Trong lời bài hát, cô ấy ăn mừng sự chia tay với một người bạn đời cũ.",
        "'Shinunoga E-Wa' là một ca khúc tình yêu mãnh liệt trong album HELP EVER HURT NEVER của Fujii Kaze.",
        "'Send My Love (To Your New Lover)' là ca khúc pop sôi động trong album 25 của Adele.",
        'mô tả Thắc mắc',
        'mô tả Tiny love',
        'mô tả Tình yêu xanh lá',
        'mô tả Mai mình xa',
        'mô tả Ca theo đàn',
        'mô tả 20 năm ở thế giới',
        'mô tả Chết trong em',
        'Ca khúc nhạc đỏ nổi tiếng của nhạc sĩ Phạm Minh Tuấn, thể hiện khát vọng cống hiến và tình yêu Tổ quốc sâu sắc.',
        'Ca khúc nhạc đỏ xúc động của nhạc sĩ Thuận Yến, viết về màu hoa đỏ gắn liền với sự hy sinh của những người lính.',
        'Ca khúc nhạc cách mạng hùng tráng của nhạc sĩ Phạm Minh Tuấn, ngợi ca vẻ đẹp và lịch sử hào hùng của đất nước.',
        'Nhạc phẩm bolero bất hủ của nhạc sĩ Trúc Phương, nói về thói đời bạc bẽo và sự thay lòng đổi dạ.',
        'Ca khúc bolero nổi tiếng kể về nỗi cô đơn của người lưu lạc ở tỉnh lẻ trong đêm vắng.',
        'Bài hát bolero ngọt ngào ca ngợi tình yêu đôi lứa dù cuộc sống nghèo khó nhưng luôn có nhau.',
        'Ca khúc bolero Nam Bộ trữ tình với hình ảnh hoa sứ thơm ngát gắn liền với mối tình quê hương.',
        'Nhạc vàng quen thuộc gắn với hình ảnh hoa phượng đỏ và nỗi buồn chia tay mùa hè.',
        'Bài nhạc vàng hào hùng, xúc động về người lính và buổi chiều nơi biên cương xa xôi.',
        'Ca khúc trữ tình bất hủ của nhạc sĩ Trịnh Công Sơn, gợi lên hình ảnh người con gái Huế mộng mơ và tình yêu dang dở.',
        'Ca khúc đầu tay của nhạc sĩ Trịnh Công Sơn, với giai điệu buồn man mác về một tình yêu câm lặng trong mưa.',
        'Ca khúc trữ tình của nhạc sĩ Trịnh Công Sơn, gợi nỗi nhớ nhung da diết qua hình ảnh biển vắng và sóng gió.',
        'Ca khúc hải ngoại nổi tiếng của nhạc sĩ Ngô Thụy Miên, với giai điệu lãng mạn về dấu ấn của một tình yêu buồn.',
        'Bản nhạc hải ngoại buồn về đêm mưa và nỗi cô đơn khi xa người thương.',
        'Ca khúc hải ngoại trữ tình của nhạc sĩ Trần Duy Đức, kể về lời hứa tiễn đưa và nỗi luyến lưu khó tả.'
    ];

    private $moods = [
        'Lemon' => 'sad',
        'Flamingo' => 'energetic',
        'Halzion' => 'romantic',
        'Gunjou' => 'epic',
        'My future' => 'focus',
        'Lost cause' => 'chill',
        'Shinunoga E-wa' => 'romantic',
        'Send My Love' => 'happy',
        'Thắc mắc' => 'chill',
        'Tiny love' => 'romantic',
        'Tình yêu xanh lá' => 'chill',
        'Mai mình xa' => 'sad',
        'Ca theo đàn' => 'chill',
        '20 năm ở thế giới' => 'epic',
        'Chết trong em' => 'angry',
        'Khát vọng' => 'epic',
        'Màu hoa đỏ' => 'epic',
        'Đất nước' => 'epic',
        'Thói đời' => 'sad',
        'Đêm buồn tỉnh lẻ' => 'sad',
        'Tình nghèo có nhau' => 'romantic',
        'Hoa sứ nhà nàng' => 'romantic',
        'Nỗi buồn hoa phượng' => 'sad',
        'Chiều mưa biên giới' => 'sad',
        'Diễm xưa' => 'sad',
        'Ướt mi' => 'sad',
        'Biển nhớ' => 'sad',
        'Dấu tình sầu' => 'sad',
        'Mưa nửa đêm' => 'sad',
        'Rồi mai tôi đưa em' => 'romantic'
        ,
        'Hãy trao cho anh' => 'energetic',
        'Lạc trôi' => 'epic',
        'Nơi này có anh' => 'romantic',
        'Chạy ngay đi' => 'energetic',
        'Chúng ta của hiện tại' => 'romantic',
        'Có chắc yêu là đây' => 'romantic',
        'Muộn rồi mà sao còn' => 'sad'
    ];

    private $tempos = [
        'Lemon' => 80,
        'Flamingo' => 150,
        'Halzion' => 90,
        'Gunjou' => 140,
        'My future' => 70,
        'Lost cause' => 75,
        'Shinunoga E-wa' => 85,
        'Send My Love' => 120,
        'Thắc mắc' => 78,
        'Tiny love' => 82,
        'Tình yêu xanh lá' => 88,
        'Mai mình xa' => 76,
        'Ca theo đàn' => 90,
        '20 năm ở thế giới' => 135,
        'Chết trong em' => 110,
        'Khát vọng' => 100,
        'Màu hoa đỏ' => 88,
        'Đất nước' => 95,
        'Thói đời' => 65,
        'Đêm buồn tỉnh lẻ' => 68,
        'Tình nghèo có nhau' => 72,
        'Hoa sứ nhà nàng' => 75,
        'Nỗi buồn hoa phượng' => 69,
        'Chiều mưa biên giới' => 80,
        'Diễm xưa' => 60,
        'Ướt mi' => 58,
        'Biển nhớ' => 63,
        'Dấu tình sầu' => 70,
        'Mưa nửa đêm' => 63,
        'Rồi mai tôi đưa em' => 74
        ,
        'Hãy trao cho anh' => 128,
        'Lạc trôi' => 100,
        'Nơi này có anh' => 104,
        'Chạy ngay đi' => 126,
        'Chúng ta của hiện tại' => 84,
        'Có chắc yêu là đây' => 96,
        'Muộn rồi mà sao còn' => 72
    ];

    private $energies = [
        'Lemon' => 4,
        'Flamingo' => 9,
        'Halzion' => 5,
        'Gunjou' => 8,
        'My future' => 3,
        'Lost cause' => 3,
        'Shinunoga E-wa' => 5,
        'Send My Love' => 7,
        'Thắc mắc' => 4,
        'Tiny love' => 5,
        'Tình yêu xanh lá' => 4,
        'Mai mình xa' => 3,
        'Ca theo đàn' => 4,
        '20 năm ở thế giới' => 8,
        'Chết trong em' => 7,
        'Khát vọng' => 8,
        'Màu hoa đỏ' => 7,
        'Đất nước' => 8,
        'Thói đời' => 2,
        'Đêm buồn tỉnh lẻ' => 2,
        'Tình nghèo có nhau' => 3,
        'Hoa sứ nhà nàng' => 3,
        'Nỗi buồn hoa phượng' => 2,
        'Chiều mưa biên giới' => 3,
        'Diễm xưa' => 2,
        'Ướt mi' => 2,
        'Biển nhớ' => 2,
        'Dấu tình sầu' => 2,
        'Mưa nửa đêm' => 2,
        'Rồi mai tôi đưa em' => 3
        ,
        'Hãy trao cho anh' => 8,
        'Lạc trôi' => 6,
        'Nơi này có anh' => 5,
        'Chạy ngay đi' => 8,
        'Chúng ta của hiện tại' => 4,
        'Có chắc yêu là đây' => 5,
        'Muộn rồi mà sao còn' => 3
    ];

    // 11=Nhạc Đỏ, 12=Nhạc Vàng, 13=Nhạc Cách Mạng, 14=Nhạc Trữ Tình, 15=Nhạc Bolero, 16=Nhạc Hải Ngoại
    private $categoryIds = [
        'Khát vọng' => 11,
        'Màu hoa đỏ' => 11,
        'Đất nước' => 13,
        'Thói đời' => 15,
        'Đêm buồn tỉnh lẻ' => 15,
        'Tình nghèo có nhau' => 15,
        'Hoa sứ nhà nàng' => 15,
        'Nỗi buồn hoa phượng' => 12,
        'Chiều mưa biên giới' => 12,
        'Diễm xưa' => 14,
        'Ướt mi' => 14,
        'Biển nhớ' => 14,
        'Dấu tình sầu' => 16,
        'Mưa nửa đêm' => 16,
        'Rồi mai tôi đưa em' => 16
    ];

    public function run(): void
    {
        $from = count(Song::all());

        for ($i = $from; $i < $from + 2; $i++) {
            DB::table('songs')->insert([
                'name' => $this->names[$i],
                'author_id' => 1,
                'playlist_id' => 1,
                'category_id' => rand(1, 10),
                'description' => $this->descriptions[$i],
                'lyrics' => '/default.txt',
                'thumbnail' => '/default.jpg',
                'total_played' => 0,
                'status' => 1,
                'price' => 10000,
                'mood' => $this->moods[$this->names[$i]],
                'tempo' => $this->tempos[$this->names[$i]],
                'energy' => $this->energies[$this->names[$i]],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = $from + 2; $i < $from + 4; $i++) {
            DB::table('songs')->insert([
                'name' => $this->names[$i],
                'author_id' => 2,
                'playlist_id' => 2,
                'category_id' => rand(1, 10),
                'description' => $this->descriptions[$i],
                'lyrics' => '/default.txt',
                'thumbnail' => '/default.jpg',
                'total_played' => 0,
                'status' => 1,
                'price' => 10000,
                'mood' => $this->moods[$this->names[$i]],
                'tempo' => $this->tempos[$this->names[$i]],
                'energy' => $this->energies[$this->names[$i]],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = $from + 4; $i < $from + 6; $i++) {
            DB::table('songs')->insert([
                'name' => $this->names[$i],
                'author_id' => 3,
                'playlist_id' => 3,
                'category_id' => rand(1, 10),
                'description' => $this->descriptions[$i],
                'lyrics' => '/default.txt',
                'thumbnail' => '/default.jpg',
                'total_played' => 0,
                'status' => 1,
                'price' => 10000,
                'mood' => $this->moods[$this->names[$i]],
                'tempo' => $this->tempos[$this->names[$i]],
                'energy' => $this->energies[$this->names[$i]],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        DB::table('songs')->insert([
            'name' => $this->names[6],
            'author_id' => 4,
            'playlist_id' => 4,
            'category_id' => rand(1, 10),
            'description' => $this->descriptions[6],
            'lyrics' => '/default.txt',
            'thumbnail' => '/default.jpg',
            'total_played' => 0,
            'status' => 1,
            'price' => 10000,
            'mood' => $this->moods[$this->names[6]],
            'tempo' => $this->tempos[$this->names[6]],
            'energy' => $this->energies[$this->names[6]],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('songs')->insert([
            'name' => $this->names[7],
            'author_id' => 5,
            'playlist_id' => 5,
            'category_id' => rand(1, 10),
            'description' => $this->descriptions[7],
            'lyrics' => '/default.txt',
            'thumbnail' => '/default.jpg',
            'total_played' => 0,
            'status' => 1,
            'price' => 10000,
            'mood' => $this->moods[$this->names[7]],
            'tempo' => $this->tempos[$this->names[7]],
            'energy' => $this->energies[$this->names[7]],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        for ($i = 0; $i < 7; $i++) {
            DB::table('songs')->insert([
                'name' => $this->names[$i + 8],
                'author_id' => 6,
                'playlist_id' => 6,
                'category_id' => rand(1, 10),
                'description' => $this->descriptions[$i + 8],
                'lyrics' => '/default.txt',
                'thumbnail' => '/default.jpg',
                'total_played' => 0,
                'status' => 1,
                'price' => 10000,
                'mood' => $this->moods[$this->names[$i + 8]],
                'tempo' => $this->tempos[$this->names[$i + 8]],
                'energy' => $this->energies[$this->names[$i + 8]],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 0; $i < 3; $i++) {
            DB::table('songs')->insert([
                'name' => $this->names[$i + 15],
                'author_id' => 7,
                'playlist_id' => 7,
                'category_id' => $this->categoryIds[$this->names[$i + 15]],
                'description' => $this->descriptions[$i + 15],
                'lyrics' => '/default.txt',
                'thumbnail' => '/default.jpg',
                'total_played' => 0,
                'status' => 1,
                'price' => 10000,
                'mood' => $this->moods[$this->names[$i + 15]],
                'tempo' => $this->tempos[$this->names[$i + 15]],
                'energy' => $this->energies[$this->names[$i + 15]],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 0; $i < 3; $i++) {
            DB::table('songs')->insert([
                'name' => $this->names[$i + 18],
                'author_id' => 8,
                'playlist_id' => 8,
                'category_id' => $this->categoryIds[$this->names[$i + 18]],
                'description' => $this->descriptions[$i + 18],
                'lyrics' => '/default.txt',
                'thumbnail' => '/default.jpg',
                'total_played' => 0,
                'status' => 1,
                'price' => 10000,
                'mood' => $this->moods[$this->names[$i + 18]],
                'tempo' => $this->tempos[$this->names[$i + 18]],
                'energy' => $this->energies[$this->names[$i + 18]],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 0; $i < 3; $i++) {
            DB::table('songs')->insert([
                'name' => $this->names[$i + 21],
                'author_id' => 9,
                'playlist_id' => 9,
                'category_id' => $this->categoryIds[$this->names[$i + 21]],
                'description' => $this->descriptions[$i + 21],
                'lyrics' => '/default.txt',
                'thumbnail' => '/default.jpg',
                'total_played' => 0,
                'status' => 1,
                'price' => 10000,
                'mood' => $this->moods[$this->names[$i + 21]],
                'tempo' => $this->tempos[$this->names[$i + 21]],
                'energy' => $this->energies[$this->names[$i + 21]],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 0; $i < 3; $i++) {
            DB::table('songs')->insert([
                'name' => $this->names[$i + 24],
                'author_id' => 10,
                'playlist_id' => 10,
                'category_id' => $this->categoryIds[$this->names[$i + 24]],
                'description' => $this->descriptions[$i + 24],
                'lyrics' => '/default.txt',
                'thumbnail' => '/default.jpg',
                'total_played' => 0,
                'status' => 1,
                'price' => 10000,
                'mood' => $this->moods[$this->names[$i + 24]],
                'tempo' => $this->tempos[$this->names[$i + 24]],
                'energy' => $this->energies[$this->names[$i + 24]],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 0; $i < 3; $i++) {
            DB::table('songs')->insert([
                'name' => $this->names[$i + 27],
                'author_id' => 11,
                'playlist_id' => 11,
                'category_id' => $this->categoryIds[$this->names[$i + 27]],
                'description' => $this->descriptions[$i + 27],
                'lyrics' => '/default.txt',
                'thumbnail' => '/default.jpg',
                'total_played' => 0,
                'status' => 1,
                'price' => 10000,
                'mood' => $this->moods[$this->names[$i + 27]],
                'tempo' => $this->tempos[$this->names[$i + 27]],
                'energy' => $this->energies[$this->names[$i + 27]],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 0; $i < count($this->sonTungSongNames); $i++) {
            DB::table('songs')->insert([
                'name' => $this->sonTungSongNames[$i],
                'author_id' => 12,
                'playlist_id' => 12,
                'category_id' => 1,
                'description' => $this->sonTungDescriptions[$i],
                'lyrics' => '/default.txt',
                'thumbnail' => '/default.jpg',
                'total_played' => 0,
                'status' => 1,
                'price' => 10000,
                'mood' => $this->sonTungMoods[$this->sonTungSongNames[$i]],
                'tempo' => $this->sonTungTempos[$this->sonTungSongNames[$i]],
                'energy' => $this->sonTungEnergies[$this->sonTungSongNames[$i]],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = $from; $i < count($this->names); $i++) {
            $song = Song::find($i + 1);
            if ($song) {
                $song->thumbnail = '/' . $this->names[$i] . ' thumbnail.jpg';
                $song->lyrics = '/' . $this->names[$i] . ' lyrics.txt';
                $song->total_played = rand(0, 5000);
                $song->touch();
            }
        }

        $sonTungOffset = count($this->names);
        for ($i = 0; $i < count($this->sonTungSongNames); $i++) {
            $song = Song::find($from + $sonTungOffset + $i + 1);
            if ($song) {
                $song->thumbnail = '/' . $this->sonTungSongNames[$i] . ' thumbnail.jpg';
                $song->lyrics = '/' . $this->sonTungSongNames[$i] . ' lyrics.txt';
                $song->total_played = rand(0, 5000);
                $song->touch();
            }
        }
    }
}