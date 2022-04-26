<?php

namespace App\Exceptions\ClientException;

use App\Exceptions\ClientException;

class PermissionException extends ClientException
{
	public function __construct($message, $code = 403)
	{
		parent::__construct($message, $code);
	}

    /**
     * The user tried to edit a resource where the owner_id does not match the users owner_id
     */
    public static function badOwner()
    {
        return new static('You have no permission to access this resource.', 401); //TODO : maybe change the http status code?
    }

    public static function badGroupOwner()
    {
        return new static('You can not assign this group to this user.', 400); //TODO : maybe change the http status code?
    }

    public static function noGroup()
    {
        return new static('You are not assigned to any permission groups.', 400); //TODO : maybe change the http status code!?
    }

    public static function noPermissions()
    {
        return new static('You do not have any permissions.', 400); //TODO : maybe change the http status code!?
    }

    public static function bad()
    {
        return new static('You are not authorized to do this.', 401);
    }

    public static function noAuth()
    {
        return new static('You are not authorized to access this api endpoint.', 401);
    }

    public static function noPermission($permission_name)
    {
        return new static("You do not have the permissions for : $permission_name");
    }

    public static function notAllowed($reason = null)
    {
        return new static('You are not allowed to perform this action.');
    }
}
