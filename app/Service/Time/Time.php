<?php

namespace App\Service\Time;

use Carbon\Carbon;

class Time
{
	public static function now()
	{
		//TODO : ensure the time is always the same, otherwise jwt verification might fail.
		
		return time();
	}

	public static function unixToDate($time = null)
	{
		$time = $time ?: static::now();

		return Carbon::createFromTimestamp($time);
	}

	public static function unixToReadable($time)
	{
		$carbon = Carbon::createFromTimestamp($time);

		return $carbon->diffForHumans();
	}
}
