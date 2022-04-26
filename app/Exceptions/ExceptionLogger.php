<?php

namespace App\Exceptions;

use App\Exceptions\ClientException;
use App\Exceptions\ServerException;
use Exception;

class ExceptionLogger
{
	/**
	 * Log exception
	 *
	 * @param  Exception $exception the exception to log
	 * @return void
	 */
    public function log(Exception $exception)
    {
    	$code 	 = $exception->getCode();
    	$message = $exception->getMessage() ?: 'Unknown exception message';

		switch (true) {
			case $exception instanceof ClientException:
				\Log::notice(sprintf('ClientException with code: "%s" and message: "%s"', $code, $message));
				break;

			case $exception instanceof ServerException:
        		\Log::warning(sprintf('ServerException with code: "%s" and message: "%s"', $code, $message));
				break;
			
			default:
        		\Log::error(sprintf('Exception with code: "%s" and message: "%s"', $code, $message));
				break;
		}
    }
}