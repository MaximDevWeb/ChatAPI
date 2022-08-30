<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Search;

class CreateSearch
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
        $search = [
            'user_id' => $event->user->id,
            'login' => $event->user->login,
        ];

        Search::create($search);
    }
}
