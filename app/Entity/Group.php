<?php

namespace App\Entity;

use App\Entity\ApiKey;
use App\Entity\Permission;
use App\Entity\User;

class Group extends BaseEntity
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'groups';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

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
        return [
            'name'         => 'required|min:4|max:99',
            'description'  => 'min:10|max:255',
        ];
    }

    /**
     * getUpdateRule
     */
    protected function getUpdateRule($id = null)
    {
        return [
            'name'         => 'min:4|max:99',
            'description'  => 'min:10|max:255',
        ];
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
    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withPivot('product_id');
    }
}
