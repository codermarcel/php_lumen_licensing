<?php

namespace App\Listeners;

use App\Events\ExampleEvent;
use App\Events\UserRegisteredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserRegistered
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
    	try {
        	\Log::info(sprintf('User with id : %s has registered.', $event->user->id));
    	} catch (\Exception $e) {
    		\Log::info('there was an ex');
    	}

    }
}
