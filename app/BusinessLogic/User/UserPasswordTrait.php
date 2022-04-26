<?php

namespace App\BusinessLogic\User;

use App\Contracts\Services\Password\PasswordServiceInterface;
use App\Exceptions\ClientException\GenericException;
use App\Service\RandomService;

trait UserPasswordTrait
{
    /**
     * This is a needed function because wen can't auto-validate the user using the getUpdateRule or getCreateRule
     * because $password will always be valid since we hash it. So we have to check if the password is valid
     * when setting the password attribute.
     */
    public function setPasswordAttribute($input)
    {
        $this->isValidPassword($input);

        $salt = app(RandomService::class)->generateSalt();
        $pw = app(PasswordServiceInterface::class)->password_hash($input, $salt);

        $this->attributes['password'] = $pw;
        $this->attributes['salt']     = $salt;
    }

    private function isValidPassword($password)
    {
        $min = $this->getMinPasswordLength();

        if (mb_strlen($password) < $min)
        {
            throw GenericException::password($min);
        }
    }

    private function getMinPasswordLength()
    {
        return 6;
    }
}