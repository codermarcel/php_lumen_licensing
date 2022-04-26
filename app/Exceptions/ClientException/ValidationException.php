<?php

namespace App\Exceptions\ClientException;

use App\Exceptions\ClientException;

class ValidationException extends ClientException
{
	public function __construct($message, $code = 400)
	{
		parent::__construct($message, $code);
	}
}
