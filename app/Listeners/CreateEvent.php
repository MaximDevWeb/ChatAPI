<?php

namespace App\Listeners;

use App\Events\ContactCreated;

class CreateEvent
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
     * @param  \App\Events\ContactCreated  $event
     * @return void
     */
    public function handle(ContactCreated $event)
    {
        //
    }
}
