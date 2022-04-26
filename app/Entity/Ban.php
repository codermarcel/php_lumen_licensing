<?php

namespace App\Entity;

use App\Entity\User;

class Ban extends BaseEntity
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'user_id', 'reason'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * getCreateRule
     */
    protected function getCreateRule()
    {
        return [
            'product_id' => 'integer',
            'user_id'    => 'integer',
            'reason'     => 'min:10|max:255',
        ];
    }

    /**
     * getUpdateRule
     */
    protected function getUpdateRule($id = null)
    {
        return [
            'product_id' => 'integer',
            'user_id'    => 'integer',
            'reason'     => 'min:10|max:99'
        ];
    }
}
