<?php

namespace App\Exceptions\ClientException;

use App\Exceptions\ClientException;

class LoginException extends ClientException
{
	public function __construct($message, $code = 401)
	{
		parent::__construct($message, $code);
	}

    public static function banned(User $user = null, $reason = null) //TODO : maybe edit?
    {
        return new static('You are currently banned.');
    }

    public static function badCredentials($email = null, $username = null)
    {
        return new static('Your login credentials do not match our records');
    }

    public static function noCredentials()
    {
        return new static('You did not specify a username or email address.');
    }
}
