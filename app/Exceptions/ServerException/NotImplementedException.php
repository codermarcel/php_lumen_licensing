<?php

namespace App\Exceptions\ServerException;

use App\Exceptions\ServerException;

class NotImplementedException extends ServerException
{
	/**
	 * @param mixed $message
	 * @param int 	$code
	 */
	public function __construct($message = 'This feature is not yet implemented.', $code = 501)
	{
		parent::__construct($message, $code);
	}

	public static function updateRule($function, $className)
	{
		return new static("The $function method has not been overridden for this entity ($className)");
	}

	public static function createRule($function, $className)
	{
		return new static("The $function method has not been overridden for this entity ($className)");
	}
}
