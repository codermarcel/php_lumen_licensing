<?php

namespace App\Service;

use App\Entity\Log;
use App\Entity\User;

class Log 
{
	const RECOVER_REQUEST = 'recover.request';
	
	public static function log(User $user, $action, $params = null)
	{
		if ( ! is_null($params) && is_array($params))
		{
			$params = json_encode($params);
		}

		$log = new Log;
		$log->action = $action;
		$log->params = $params;
		$log->user_id = $user->id;

		return $log->save();
	}
}
