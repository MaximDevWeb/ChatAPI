<?php

namespace App\Listeners;

use App\Events\ProfileUpdated;
use App\Models\Search;

class UpdateSearch
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
     * @param  \App\Events\ProfileUpdated  $event
     * @return void
     */
    public function handle(ProfileUpdated $event)
    {
        $search = [
            'full_name' => $event->profile->first_name.' '.$event->profile->last_name,
        ];

        Search::where('user_id', $event->profile->user_id)->update($search);
    }
}
