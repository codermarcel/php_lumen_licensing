<?php

namespace App\Exceptions\ClientException;

class ApiException extends \Exception
{
	/**
	 * @param mixed $message
	 * @param int 	$code
	 */
	public function __construct($message, $code)
	{
		parent::__construct($message, $code);
	}
}
