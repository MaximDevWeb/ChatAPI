<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Avatar;
use Illuminate\Support\Facades\Storage;

class CreateAvatar
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $num_avatar = rand(1, 14);
        $path = "/avatars/default/avatar_$num_avatar.svg";
        $link = Storage::url($path);

        $avatar = [
            'user_id' => $event->user->id,
            'type' => Avatar::$DEFAULT_TYPE,
            'path' => $path,
            'link' => $link,
        ];

        Avatar::create($avatar);
    }
}
