<?php

namespace App\Entity;

use App\Entity\Group;
use App\Entity\User;

/**
 * Group that is associated with a user and therefore gives that user all the group permissions
 * this is different from the normal Group.
 */
class Role extends BaseEntity
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * getCreateRule
     */
    protected function getCreateRule()
    {
        return [];
    }

    /**
     * getUpdateRule
     */
    protected function getUpdateRule($id = null)
    {
        return [];
    }

    /**
     * Relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
