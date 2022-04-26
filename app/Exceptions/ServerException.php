<?php

namespace App\Exceptions;

use App\Contracts\Exceptions\HttpException;

class ServerException extends \Exception implements HttpException
{
	/**
	 * @param mixed $message
	 * @param int 	$code
	 */
	public function __construct($message, $code = 500)
	{
		parent::__construct($message, $code);
	}
}
