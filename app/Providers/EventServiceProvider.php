<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UserUpdatedEvent' => [
            'App\Listeners\UserUpdatedListener',
        ],
        'App\Events\UniversityCreatedEvent' => [
            'App\Listeners\UniversityCreatedListener',
        ],
        'App\Events\GameCreatedEvent' => [
            'App\Listeners\GameCreatedListener',
        ],
        'App\Events\GameUniversityCreatedEvent' => [
            'App\Listeners\GameUniversityCreatedListener',
        ],
        'App\Events\ProfileCreatedEvent' => [
            'App\Listeners\ProfileCreatedListener',
        ],
        'App\Events\GroupUserCreatedEvent' => [
            'App\Listeners\GroupUserCreatedListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
