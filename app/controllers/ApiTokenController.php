<?php

use Jeopardy\Token\Exceptions\NotAuthorizedException;
use Jeopardy\Token\Exceptions\WrongCredentialsException;

use Jeopardy\Token\Repositories\TokenRepositoryInterface;
use Jeopardy\Token\Fetchers\TokenFetcherInterface;

use Jeopardy\Transformers\UserTransformer;

class ApiTokenController extends ApiController {

	/**
	 * @var \Tappleby\AuthToken\AuthTokenDriver
	 */
	protected $tokenRepo;
	protected $tokenFetcher;

	/**
	 * @var callable format username and password into hash for Auth::attempt
	 */
	protected $credentialsFormatter;

	function __construct(TokenRepositoryInterface $tokenRepo, TokenFetcherInterface $tokenFetcher)
	{
		parent::__construct(new League\Fractal\Manager, new Jeopardy\Responses\Api\ApiResponse);
		$this->tokenRepo = $tokenRepo;
		$this->tokenFetcher = $tokenFetcher;
	}

	public function index()
	{
		$tokenStr = $this->tokenFetcher->fetchToken();
		// $user = $this->tokenRepo->validate($tokenStr);
		$user = $this->tokenRepo->getUser($tokenStr);

		return $this->respondWithItem($user, new UserTransformer);
	}

	public function store()
	{
		$input = Input::all();

		$token = $this->tokenRepo->attempt($input);

		return Response::json(array('token' => $token->token, 'user' => $token->user->toArray()), 201);
	}

	public function destroy()
	{
		$tokenStr = $this->tokenFetcher->fetchToken();
		$user = $this->tokenRepo->getUser($tokenStr);

		$this->tokenRepo->purge($user);

		return Response::json(null, 204);
	}

}
