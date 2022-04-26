<?php

namespace App\Entity;


use App\BusinessLogic\User\UserOwnerTrait;
use App\BusinessLogic\User\UserPasswordTrait;
use App\BusinessLogic\User\UserPermissionTrait;
use App\Entity\ApiKey;
use App\Entity\Group;
use App\Entity\Permission;
use App\Entity\Product;
use App\Entity\Role;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Cache\Repository as Cache;
use Laravel\Lumen\Auth\Authorizable;

class User extends BaseEntity implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, UserPermissionTrait, UserPasswordTrait, UserOwnerTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'salt', 'email',];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'username', 'password',];
    
    /**
     * Create rule
     */
    protected function getCreateRule()
    {
        return [
            'email'     => 'required|min:8|max:99|email|unique:users',
            'username'  => 'required|min:4|max:99|unique:users',
        ];
    }

    /**
     * Update rule.
     */
    public function getUpdateRule($id = null)
    {
        $id = $id ?: $this->id;

        return [
            'email'     => 'min:8|max:99|email|unique:users,email,' . $id,
            'username'  => 'min:4|max:99|unique:users,username,' . $id,
        ];
    }

    /**
     * Convenient method to get user permissions.
     * 
     * @return null|Illuminate\Database\Eloquent\Collection
     */
    public function getPermissions(Cache $cache = null)
    {
        $cache = $cache ?: app(Cache::class);
        $minutes = 10;
        $role = $this->role;

        return $cache->remember('user.permissions.' . $this->id, $minutes, function() use($role) {
            $notOk = empty($role) ?: is_null($role->group); //use is_null instead of empty.

            if ($notOk)
            {
                return null;
            }

            return $role->group->permissions->toArray();
        });
    }

    /**
     * Relationships
     */
    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function api_keys()
    {
        return $this->hasMany(ApiKey::class);
    }

    public function role()
    {
        return $this->hasOne(Role::class);
    }
}