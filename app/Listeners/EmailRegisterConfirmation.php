<?php

namespace App\Listeners;

use App\Events\ExampleEvent;
use App\Events\UserRegisteredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmailRegisterConfirmation implements ShouldQueue
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
     * @param  ExampleEvent  $event
     * @return void
     */
    public function handle(UserRegisteredEvent $event)
    {
        \Log::info('Email register confirmation to email : ' . $event->user->email);
    }
}
