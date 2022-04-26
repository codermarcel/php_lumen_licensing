<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class License extends BaseEntity
{
    /**
     * TODO : update the AccessTime on last product access.
     */

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'licenses';    

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
        $id = $id ?: $this->id;

        return [];
    }
}
