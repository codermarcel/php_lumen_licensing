<?php

namespace App\Exceptions\ClientException;

use App\Exceptions\ClientException;

class GenericException extends ClientException
{
	public function __construct($message, $code = 400)
	{
		parent::__construct($message, $code);
	}

    public static function password($length)
    {
        return new static("Your password has to have at least $length characters.");
    }
}
