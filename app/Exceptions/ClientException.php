<?php

namespace App\Exceptions;

use App\Contracts\Exceptions\HttpException;

class ClientException extends \Exception implements HttpException
{
	/**
	 * @param mixed $message
	 * @param int 	$code
	 */
	public function __construct($message, $code = 400)
	{
		parent::__construct($message, $code);
	}

	public static function db()
	{
		return new static('Could not write those changes to the database.');
	}
}
