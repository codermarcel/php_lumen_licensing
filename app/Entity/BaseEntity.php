<?php

namespace App\Entity;

use App\Exceptions\ClientException\ValidationException;
use App\Service\Time\Time;
use Illuminate\Database\Eloquent\Model;

class BaseEntity extends Model
{
    /**
     * Indicates if the model has update and creation timestamps.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The storage format of the model's date columns.
     * 
     * Unix format.
     *
     * @var string
     */
    public $dateFormat = 'U';

    /**
     * Construct
     */
    private $validator;
	public function __construct(array $attributes = array(), Validator $validator = null)
	{
		parent::__construct($attributes);

		$this->validator = $validator ?: app('validator');
	}
 
	/**
	 * Boot validaton rules
	 */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function($model)
        {
            if($model->autoValidate)
            {
                return $model->validateCreate();
            }
        });     

        static::updating(function($model)
        {
            if($model->autoValidate)
            {
                return $model->validateUpdate();
            }
        });
    }

    /**
     * Auto Validation
     * @var boolean
     */
    protected $autoValidate = true;

    /**
     * Set
     */
    public function setAutoValidate($boolean = true)
    {
        $this->autoValidate = $boolean;
    }

    /**
     * Get
     */
    public function getAutoValidate()
    {
        return $this->autoValidate;
    }
    
    /**
     * Create rule
     */
    public function validateCreate()
    {
        $v = $this->validator->make($this->attributes, $this->getCreateRule());

        if ($v->fails()) 
        {
            throw new ValidationException($v->errors()->first());
        }
    }    

    /**
     * Update rule
     */
    public function validateUpdate()
    {
        $v = $this->validator->make($this->attributes, $this->getUpdateRule());

        if ($v->fails()) 
        {
            throw new ValidationException($v->errors()->first());
        }
    }

    /**
     * The child class should override this method.
     */
    protected function getUpdateRule($id = null)
    {
        throw NotImplementedException::updateRule(__FUNCTION__, get_called_class());
    }

    /**
     * The child class should override this method.
     */
    protected function getCreateRule()
    {
        throw NotImplementedException::createRule(__FUNCTION__, get_called_class());
    }
}