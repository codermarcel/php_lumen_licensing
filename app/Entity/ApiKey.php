<?php

namespace App\Entity;

use App\Entity\User;
use App\Service\RandomService;

class ApiKey extends BaseEntity
{
    private $random;

    public function __construct(array $attributes = [], $random = null)
    {
        parent::__construct($attributes);

        $random = $random ?: app(RandomService::class);

        $this->attributes['token'] = $random->generateToken();
    }
    
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'api_keys';

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
     * Relationships
     */
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
