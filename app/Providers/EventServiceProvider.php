<?php

namespace App\Providers;

use App\Events\ContactCreated;
use App\Events\ProfileUpdated;
use App\Events\UserCreated;
use App\Listeners\CreateAvatar;
use App\Listeners\CreateEvent;
use App\Listeners\CreateProfile;
use App\Listeners\CreateSearch;
use App\Listeners\UpdateSearch;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserCreated::class => [
            CreateProfile::class,
            CreateAvatar::class,
            CreateSearch::class,
        ],
        ProfileUpdated::class => [
            UpdateSearch::class,
        ],
        ContactCreated::class => [
            CreateEvent::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
