<?php

namespace App\Http\Controllers;

use App\Contracts\Jwt\Audience;
use App\Entity\User;
use App\Events\UserRegisteredEvent;
use App\Exceptions\ClientException\LoginException;
use App\Jobs\SendRecoveryEmail;
use App\Repository\ApiKeyRepository;
use App\Repository\UserRepository;
use App\Service\Api\Api;
use App\Service\AuthService;
use App\Service\EntityService;
use App\Service\Jwt\JwtBuilder;
use App\Service\Jwt\JwtParser;
use App\Service\RegisterService;
use App\Service\UserService;
use App\Validation\AuthValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class AuthController extends AbstractController
{
	private $authService;
	private $users;

	public function __construct(AuthService $authService, UserRepository $users)
	{
		$this->authService = $authService;
		$this->users = $users;
	}

	/**
	 * Register new account
	 * @param  Request         $request         [description]
	 * @param  RegisterService $registerService [description]
	 * @return [type]                           [description]
	 */
	public function register(Request $request)
	{
		$user = User::create($request->all());

		event(new UserRegisteredEvent($user));

		return (new Api($request))
			->set('id', $user)
			->build();
	}

	/**
	 * Send recovery JWT
	 */
	public function recover(Request $request)
	{
		$user = $this->users->getByEmail($request->input('email'));

		dispatch(new SendRecoveryEmail($user));

		return (new Api($request))
			->setMessage('Email will be sent.')
			->build();
	}

	/**
	 * Do the recover
	 * 
	 * REMARK : user can update everything (password, email, username) because we assume that he is a legit user
	 * since he knew the email address for the user and also had access to the email address.
	 */
	public function update(Request $request, EntityService $service) 
	{
		$parser = new JwtParser();

		$token = $parser->getToken($request);

		$user = $this->users->getById($parser->getSubject($token));

		$service->updateEntity($user, $request->all()); //Maybe only allow updating the password? $request->only('password') 

		return (new Api($request))
			->build();
	}

	/**
	 * Refreshes a valid authentication.
	 * @param  equest $request [description]
	 * @return [type]          [description]
	 */
	public function refreshJwt(Request $request, JwtParser $parser)
	{	
		$token    = $parser->getToken($request);
		$audience = $parser->getAudience($token);
		$subject  = $parser->getSubject($token);

		if ($audience !== Audience::USER)
		{
			throw JwtException::badAudience($audience);
		}

		return $this->authenticateUser($this->users->getById($subject), $request);
	}

	/**
	 * Authenticate User with his credentials.
	 * 
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function authenticateCredentials(Request $request)
	{
		$this->validate($request, AuthValidation::$credentialRules);

		$user = $this->authService->authenticateWithCredentials($request->input('email'), $request->input('password'));

		return $this->authenticateUser($user, $request);
	}

	/**
	 * Authenticate user via api token.
	 * 
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function authenticateKeyInput(Request $request, ApiKeyRepository $apikeys)
	{
		$this->validate($request, AuthValidation::$tokenRules);

		$apikey = $apikeys->getByToken($request->input('apikey'));

		$user = $this->users->getById($apikey->user_id);
		
		return $this->authenticateUser($user, $request);
	}

	/**
	 * Authenticate user
	 */
	private function authenticateUser(User $user, $request)
	{
		$token = (new JwtBuilder())
			->setSubject($user->id)
			->setAudience(Audience::USER)
			->getToken();

		return (new Api($request))
			->setToken($token)
			->build();
	}
}
