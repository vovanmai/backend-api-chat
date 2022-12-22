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
        $users = [];
        for ($i = 1; $i<= 50; $i++) {
            $users[] = User::create([
                'full_name' => 'Fullname ' . $i,
                'email' => "test{$i}@gmail.com",
                'password' => Hash::make('secret'),
                'color' => $colors[array_rand($colors)],
            ]);
        }

        $chatChannels = [];

        foreach ($users as $key => $user) {
            if ($key > 0) { break; }
            foreach ($users as $item) {
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
}
