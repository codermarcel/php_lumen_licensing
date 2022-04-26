<?php

namespace App\Service;

use App\Contracts\Services\Password\PasswordServiceInterface as PasswordService;
use App\Entity\User;
use App\Exceptions\ClientException\LoginException;
use App\Repository\ApiKeyRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService 
{
	private $users;
	private $pws;
	private $api_keys;
	
	public function __construct(UserRepository $users, PasswordService $pws, ApiKeyRepository $api_keys)
	{
		$this->users = $users;
		$this->pws = $pws;
		$this->api_keys = $api_keys;
	}

	public function authenticateWithCredentials($email, $password)
	{
		$user = $this->users->findByEmail($email);

		if ( ! $user)
		{
			throw LoginException::badCredentials($email);
		}

		if ($this->isBanned($user))
		{
			throw LoginException::banned($user);
		}

		if ( ! $this->pws->password_verify($password, $user->password, $user->salt))
		{
			throw LoginException::badCredentials($email);
		}

		return $user;
	}

	public function authenticateWithToken($token)
	{
		$apikey = $this->api_keys->getByToken($token);

		return $apikey;
	}

	public function isBanned(User $user)
	{
		return false; //TODO : edit this?
	}
}
