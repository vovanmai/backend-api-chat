<?php

namespace App\Services\User;

use App\Data\Repositories\Eloquent\ChatChannelRepository;
use App\Data\Repositories\Eloquent\ChatMessageRepository;
use App\Data\Repositories\Eloquent\UnreadMessageTotalRepository;
use App\Data\Repositories\Eloquent\UserRepository;
use App\Events\SendMessage;
use App\Models\ChatChannel;
use App\Models\ChatMessage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterService
{

    /**
     * @var ChatChannelRepository
     */
    protected $chatChannelRepo;

    /**
     * @var UserRepository
     */
    protected $userRepo;

    /**
     * @var UnreadMessageTotalRepository
     */
    protected $unreadMessageTotalRepo;

    public function __construct(
        ChatChannelRepository $chatChannelRepo,
        UserRepository $userRepo
    ) {
        $this->chatChannelRepo = $chatChannelRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * Register user
     *
     * @param $data
     *
     * @return User
     */
    public function handle(array $data)
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
        $data['password'] = bcrypt($data['password']);
        $data['color'] = $colors[array_rand($colors)];
        $userCreated = $this->userRepo->create($data);


        $users = $this->userRepo->whereByField('id', $userCreated->id, '!=')->all(['id']);

        $chatChannels = [];

        foreach ($users as $user) {
            $chatChannels[] = [
                'sender_id' => $userCreated->id,
                'receiver_id' => $user->id,
                'last_message_at' => now()->format('Y-m-d H:i:s.u'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        $this->chatChannelRepo->insert($chatChannels);

        return $userCreated;
    }
}
