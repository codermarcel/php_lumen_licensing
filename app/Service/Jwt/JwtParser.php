<?php

namespace App\Service\Jwt;

use App\Entity\DummyUser;
use App\Exceptions\ClientException\JwtException;
use App\Repository\UserRepository;
use App\Service\Jwt\Jwt;
use App\Service\Time\Time;
use Illuminate\Http\Request;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;

class JwtParser extends Jwt
{
	private $users;

	public function __construct(UserRepository $users = null)
	{
		$this->users = $users ?: app(UserRepository::class);
	}


	/**
	 * Get user from request
	 * 
	 * @param  Request $request [description]
	 * @return DummyUser
	 */
	public function userFromRequest(Request $request)
	{
		$token = $this->getToken($request);
		
		$user_id = $this->getSubject($token);

		return $this->users->getById($user_id);
	}

	/**
	 * Get a verified and valid token from request.
	 */
	public function getToken(Request $request)
	{	
		$token = $this->getTokenFromRequest($request);

		$this->verifyToken($token);
		$this->checkBlackList($token);

		return $token;
	}

	/**
	 * Parse claim from token
	 */
	public function getScope(Token $token)
	{
		$claim = $this->getClaim($token, 'scope');

		return $claim ? (array) $claim : null;
	}

	/**
	 * Parse claim from token
	 */
	public function getSubject(Token $token)
	{
		return $this->getClaim($token, 'sub');
	}

	/**
	 * Parse claim from token
	 */
	public function getAudience(Token $token)
	{
		return $this->getClaim($token, 'aud');
	}

	/**
	 * Parse claim from token
	 */
	public function getOwner(Token $token)
	{
		return $this->getClaim($token, 'owner');
	}

	/**
	 * Get claim
	 */
	private function getClaim(Token $token, $claim)
	{
		try {
			return $token->getClaim($claim);
		} catch (\Exception $e) {
			return null;
		}
	}

	/**
	 * Parse the token from the Authorization header
	 */
	private function getTokenFromRequest(Request $request)
	{
		$token = $request->bearerToken() ?: $request->header('Authorization'); //support authorize header with and without 'Bearer <token>'
		$token = $token ?: $request->input('jwt');   //if they don't send the token as header, they can send it as request parameter (jwt)
		$token = $token ?: $request->input('token'); //if they don't send the token as header, they can send it as request parameter (token)

		if (empty($token))
		{
			throw JwtException::noToken();
		}

		try {
			$token = (new Parser())->parse((string) $token);
		} catch (\Exception $e) {
			throw JwtException::badFormat();
		}

		return $token;
	}

	/**
	 * Here we can invalidate the token based on some criteria
	 * 
	 * This is different from validating the token.
	 * 
	 * @throws JwtException
	 */
	private function checkBlackList($token)
	{
		if ($token->getClaim('jpk') !== $this->getPublic())
		{
			throw JwtException::isInvalid();
		}
	}

	/**
	 * Verifies the token signature and validates the $token data (iat, nbf, exp)
	 * 
	 * @param  Token $jwt [description]
	 * @throws JwtException
	 * @return boolean true
	 */
	private function verifyToken($jwt)
	{
		$token = (new Parser())->parse((string) $jwt);

		$data = new ValidationData(Time::now()); //Use the time now.

		if ( ! $token->verify($this->getSigner(), $this->getSecret()))
		{
			throw JwtException::isForged();
		}

		if ( ! $token->validate($data)) // Validates iat, nbf and exp
		{
			throw JwtException::isInvalid();
		}

		return true;
	}
}
