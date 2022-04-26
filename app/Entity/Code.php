<?php

namespace App\Entity;

class Code extends BaseEntity
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'register_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id'];

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
            'duration' => 'integer|min:1|max:20', //NOTE : duration in seconds?
        ];
    }

    /**
     * getUpdateRule
     */
    protected function getUpdateRule($id = null)
    {
        $id = $id ?: $this->id;

        return [
            'duration' => 'integer|min:1|max:20', //NOTE : duration in seconds?
        ];
    }
}
