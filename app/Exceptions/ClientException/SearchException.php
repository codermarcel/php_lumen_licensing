<?php

namespace App\Exceptions\ClientException;

use App\Exceptions\ClientException;

class SearchException extends ClientException
{
	public function __construct($message, $code = 400)
	{
		parent::__construct($message, $code);
	}

    public static function badOperator()
    {
        return new static('You have used an invalid search operator.');
    }

    public static function badFilter()
    {
        return new static('One or more filters may not exist in the database.');
    }

    public static function blacklisted($name)
    {
        return new static("The following search or filter is not allowed : $name");
    }

    public static function blacklistedValueStart($value, $start)
    {
        return new static("The following search or filter : $value can not start with : $start");
    }    
}
