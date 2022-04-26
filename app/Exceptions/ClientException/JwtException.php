<?php

namespace App\Exceptions\ClientException;

use App\Exceptions\ClientException;

class JwtException extends ClientException
{
	public function __construct($message, $code = 400)
	{
		parent::__construct($message, $code);
	}
    
    public static function badAudience($audience)
    {
        return new static('You were not specified to execute this action.', 401);
    }   

    public static function badRefresh()
    {
        return new static('The jwt could not be refreshed.');
    }

    public static function badFormat()
    {
        return new static('The jwt format is invalid.');
    }

    public static function noToken()
    {
        return new static('No jwt token has been submitted.');
    }

    public static function isForged()
    {
        return new static('The jwt content does not match its signature');
    }

    public static function isInvalid()
    {
        return new static('The jwt has expiered or access has been revoked.');
    }

    /**
     * TODO : this is NOT a ClientException, this is a server exception, change this.
     */
    public static function requiredFields()
    {
        $msg = 'The jwt required fields subject (sub) or owner (owner) have not been set.';

        return new static($msg);
    }
}
