<?php

namespace App\Exceptions\ClientException;

use App\Exceptions\ClientException;

class NotFoundException extends ClientException
{
	public function __construct($message, $code = 404)
	{
		parent::__construct($message, $code);
	}

    public static function noRecord()
    {
        return new static('No records could be found');
    }

    public static function noRoute()
    {
        return new static('No api endpoint could be found for your request.');
    }
}
