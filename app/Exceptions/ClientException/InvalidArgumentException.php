<?php

namespace App\Exceptions\ClientException;

use App\Exceptions\ClientException;

class InvalidArgumentException extends ClientException
{
	public function __construct($message, $code = 400)
	{
		parent::__construct($message, $code);
	}

    public static function methodNotAllowed($method)
    {
        return new static("Cannot process rules for HTTP method: $method", 405);
    }
}
