<?php

namespace App\Entity;

use App\Entity\Group;
use App\Entity\GroupPermission;
use App\Entity\Permission;
use App\Entity\Product;
use Illuminate\Database\Eloquent\Model;

class Permission extends BaseEntity
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permissions';    

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
    protected $hidden = ['updated_at', 'created_at', 'display_name'];

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
        $id = $id ?: $this->id;

        return [];
    }

    /**
     * [groups description]
     * @return [type] [description]
     */
    public function groups()
    { 
        return $this->belongsToMany(Group::class);
    }

    // public function product_id()
    // { 
    //     dd($this->hasManyThrough(Product::class, GroupPermission::class));
    // }
}
