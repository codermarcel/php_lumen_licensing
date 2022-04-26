<?php

namespace App\Exceptions\ClientException;

use App\Exceptions\ClientException;

class DatabaseException
{
	public function __construct($message, $code = 406) //TODO : find better http status code.
	{
		parent::__construct($message, $code);
	}

    public static function update()
    {
        return new static('Could not update the record(s)');
    }

    public static function create()
    {
        return new static('Could not create the record(s)');
    }

    public static function delete()
    {
        return new static('Could not delete the record(s)');
    }
}
