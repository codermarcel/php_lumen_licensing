<?php

namespace App\Exceptions\ClientException;

use App\Exceptions\ClientException;

class LimitException extends ClientException
{
	public function __construct($message, $code = 429)
	{
		parent::__construct($message, $code);
	}

    public static function aboveLimit($owner_id, $time_frame, $amount)
    {
    	\Log::info("Owner with id $owner_id has hit the request limit");
    	
        return new static("You have exceeded your limit of [$amount] requests for [$time_frame] minutes.", 429);
    }
}
