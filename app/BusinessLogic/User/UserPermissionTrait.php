<?php

namespace App\BusinessLogic\User;

use App\Exceptions\ClientException\PermissionException;

trait UserPermissionTrait
{
    public function check($name, $product_id = null)
    {
        return $this->authorize($name, $product_id);
    }

    public function authorize($name, $product_id = null)
    {
        if ( ! $this->hasPermission($name, $product_id))
        {
            throw PermissionException::noPermission($name);
        }
    }

    /**
     * Check if user has permission with name $name AND (product_id === $product_id OR the permission is global)
     * 
     * @param  string  $name       permission name to check for
     * @param  int     $id         product id for the permission
     * @return boolean true|false
     */
    public function hasPermission($name, $product_id = null)
    {
    	$permission = $this->getPermissions();

        foreach ($permission as $index => $perm)
        {
            if (array_get($perm, 'name') === $name)
            {
                if (array_get($perm, 'isGlobal') === true || array_get($perm, 'pivot.product_id') === $product_id)
                {
                    return true;
                }
            }
        }

        return false;
    }
}