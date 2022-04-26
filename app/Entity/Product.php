<?php

namespace App\Entity;

class Product extends BaseEntity
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';    

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * getCreateRule
     */
    protected function getCreateRule()
    {   
        return [];
        
        return [
            'name'         => 'required|min:4|max:99|unique:products',
            'description'  => 'min:10|max:255',
        ];
    }

    /**
     * getUpdateRule
     */
    protected function getUpdateRule($id = null)
    {
        $id = $id ?: $this->id;

        return [
            'name'        => 'min:10|max:99|unique:products,name,' . $id,
            'description' => 'min:10|max:255'
        ];
    }
}