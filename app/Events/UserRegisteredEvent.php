<?php

namespace App\Events;

use App\Entity\User;

class UserRegisteredEvent extends Event
{
	public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
