<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Exception extends BaseEntity
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exceptions';	

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
