<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $colors = [
            '#a41a3f',
            '#bb20c3',
            '#5556c3',
            '#6da5b8',
            '#468c72',
            '#72ac6d',
            '#bcaf72',
            '#c8621a',
            'blue',
            'green',
            'yellow',
            'orange',
            'red',
            'indigo',
            'violet',
            'purple',
            'pink',
            'silver',
            'gold',
            'brown',
            'gray',
            'black',
            '#891247',
            '#240d17',
            '#494245',
            '#524083',
            '#216132',
            '#f208e8',
            '#7b2808',
        ];

        $names = [
            'Lionel Vo',
            'Hồng Quân',
            'Anh Dũng',
            'Anh Minh',
            'Chí Kiên',
            'Đăng Khoa',
            'Chiến Thắng',
            'Đức Tài',
            'Đình Trung',
            'Gia Huy',
            'Hải Đăng',
            'Huy Hoàng',
            'Hữu Đạt',
            'Hùng Cường',
            'Hoàng Phi',
            'Mạnh Khôi',
            'Kiến Văn',
            'Hữu Phước',
            'Khôi Vĩ',
            'Mạnh Hùng',
            'Huyền Anh',
            'Thùy Anh',
            'Tú Anh',
            'Diệu Anh',
            'Nguyệt Ánh',
            'Mỹ Châm',
            'Bích Diệp',
            'Thu Diệp',
            'Minh Khuê',
            'Bích Liên',
            'Ánh Ngọc',
            'Quỳnh Châu',
            'Thanh Bích',
            'Bảo Vy',
            'Hoài An',
            'Khả Hân',
            'Linh Chi',
            'Thanh Hà',
            'An Nhiên',
            'Quỳnh Anh',
            'Phương Linh',
            'Thiên Bình',
            'Thanh Thảo',
        ];
        $users = [];
        $nameLength = count($names);
        for ($i = 0; $i < $nameLength; $i++) {
            $name = $names[$i];
            $email = $this->convertName($name) . '@gmail.com';
            $users[] = User::create([
                'full_name' => $names[$i],
                'email' => $email,
                'password' => Hash::make('secret'),
                'color' => $colors[array_rand($colors)],
            ]);
        }

        $chatChannels = [];

        foreach ($users as $key => $user) {
            foreach ($users as $item) {
                if ($user->id == $item->id || $this->check($chatChannels, $user->id, $item->id)) {
                    continue;
                }
                $chatChannels[] = [
                    'sender_id' => $user->id,
                    'receiver_id' => $item->id,
                    'last_message_at' => now()->format('Y-m-d H:i:s.u'),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        DB::table('chat_channels')->insert($chatChannels);
    }

    public function check(array $chatChannels, $userId1, $userId2)
    {
        $item = array_filter($chatChannels, function ($value) use ($userId1, $userId2) {
            return ($value['sender_id'] == $userId1 && $value['receiver_id'] == $userId2)
                || ($value['sender_id'] == $userId2 && $value['receiver_id'] == $userId1);
        });

        return !empty($item);
    }

    public function convertName($str)
    {
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            ''=>' ',
        );

        foreach($unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        return strtolower($str);
    }
}
