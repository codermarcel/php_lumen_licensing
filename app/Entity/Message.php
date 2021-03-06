<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Message extends BaseEntity
{
    /**
     * TODO : Update ReadTime when the user read the message.
     */

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';    

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
