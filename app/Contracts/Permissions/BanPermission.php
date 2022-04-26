<?php

namespace App\Contracts\Permissions;

use App\Helpers\AbstractEnum;

class BanPermission extends AbstractEnum
{
	const CREATE = 'ban.create';
	const DELETE = 'ban.delete';
	const UPDATE = 'ban.update';
	const READ   = 'ban.read';
}