<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class PostView extends BaseEntity
{
    /**
     * TODO : update the ReadTime when PostView is read.
     */

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_views';    

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