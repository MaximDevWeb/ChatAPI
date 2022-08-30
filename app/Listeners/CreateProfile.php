<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Profile;

class CreateProfile
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
        $profile = [
            'user_id' => $event->user->id,
        ];

        Profile::create($profile);
    }
}
