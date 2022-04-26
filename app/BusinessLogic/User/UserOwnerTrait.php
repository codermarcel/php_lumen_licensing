<?php

namespace App\BusinessLogic\User;

trait UserOwnerTrait
{
    /**
     * Get the owner_id attribute
     * 
     * If the owner_id is null, then this user is the owner (so return his id)
     * 
     * @return int
     */
    public function getOwnerIdAttribute($value)
    {
        return $value ?: $this->id;
    }
    
    public function isOwner()
    {
        return $this->owner_id === $this->id;
    }
}
