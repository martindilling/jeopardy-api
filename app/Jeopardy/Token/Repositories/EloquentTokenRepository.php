<?php namespace Jeopardy\Token\Repositories;

use Jeopardy\Token\Exceptions\NotAuthorizedException;
use Jeopardy\Token\Exceptions\TokenExpiredException;
use Jeopardy\Token\Exceptions\TokenMissingException;
use Jeopardy\Token\Exceptions\WrongCredentialsException;

use Jeopardy\Token\Token;
use Jeopardy\Token\Repositories\TokenRepositoryInterface;
use Jeopardy\Token\Generators\TokenGeneratorInterface;

use Carbon\Carbon;
use User;
use Auth;
use Validator;
use DateTime;

class EloquentTokenRepository implements TokenRepositoryInterface
{
	protected $tokenModel;
	protected $generator;
	protected $userModel;

	public function __construct(Token $tokenModel, TokenGeneratorInterface $generator, User $userModel)
	{
		$this->tokenModel = $tokenModel;
		$this->generator = $generator;
		$this->userModel = $userModel;
	}

	public function isTokenUnique($token)
	{
		return !count($this->tokenModel->where('token', $token)->first());
	}

	public function generateToken()
	{
		$tokenStr = $this->generator->generate();

		// As long as the generated token already exist, generate a new one to check
		while ( !$this->isTokenUnique($tokenStr) ) {
			$tokenStr = $this->generator->generate();
		}

		return $tokenStr;
	}

	public function validate($tokenStr)
	{
		if ( $tokenStr == null ) {
			throw new TokenMissingException();
		}

		$token = $this->tokenModel->where('token', $tokenStr)->first();

		if ( $token == null ) {
			throw new NotAuthorizedException();
		}

		if ( Carbon::parse($token->lastuse_at)->diffInDays() >= 1 ) {
			throw new TokenExpiredException();
		}

		return $token->user;
	}

	public function attempt(array $credentials)
	{
		$validator = Validator::make(
			$credentials,
			array(
				'email' => array('required'),
				'password' => array('required')
			)
		);

		if( $validator->fails() ) {
			throw new NotAuthorizedException();
		}

		if ( !Auth::validate($credentials) ) {
			throw new WrongCredentialsException();
		}

		$user = $this->userModel->where('email', $credentials['email'])->first();

		return $this->create($user);
	}

	public function create(User $user)
	{
		$this->tokenModel->where('user_id', $user->id)->delete();

		$token = array(
			'user_id'    => $user->id,
			'token'      => $this->generateToken(),
			'lastuse_at' => new DateTime,
		);

		return $this->tokenModel->create($token);
	}

	public function purge(User $user)
	{
		return $user->getTokens()->delete();
	}

	public function getToken($token)
	{
		return $this->token;
	}

	public function getUser($tokenStr)
	{
		$token = $this->tokenModel->where('token', $tokenStr)->first();
		return $token->user;
	}

	public function lastUsed()
	{
		return $this->lastuse_at;
	}
}
