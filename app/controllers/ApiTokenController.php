<?php

use Jeopardy\Token\Repositories\TokenRepositoryInterface;
use Jeopardy\Token\Fetchers\TokenFetcherInterface;

use Jeopardy\Transformers\UserTransformer;

class ApiTokenController extends ApiController {

	/**
	 * @var \Jeopardy\Token\Repositories\TokenRepositoryInterface
	 */
	protected $tokenRepo;

	/**
	 * @var \Jeopardy\Token\Fetchers\TokenFetcherInterface
	 */
	protected $tokenFetcher;

	/**
	 * Constructor
	 *
	 * @param TokenRepositoryInterface $tokenRepo
	 * @param TokenFetcherInterface    $tokenFetcher
	 */
	function __construct(TokenRepositoryInterface $tokenRepo, TokenFetcherInterface $tokenFetcher)
	{
		parent::__construct(new League\Fractal\Manager, new Jeopardy\Responses\Api\ApiResponse);
		$this->tokenRepo = $tokenRepo;
		$this->tokenFetcher = $tokenFetcher;
	}

	public function index()
	{
		// Fetch token
		$tokenStr = $this->tokenFetcher->fetchToken();
		// Get user from token
		$user = $this->tokenRepo->getUser($tokenStr);

		// Return the user item
		return $this->respondWithItem($user, new UserTransformer);
	}

	public function store()
	{
		// Get input
		$input = Input::all();

		// Attempt to generate token for the user
		$token = $this->tokenRepo->attempt($input);

		// Return the generated token and user item
		return Response::json(array('token' => $token->token, 'user' => $token->user->toArray()), 201);
	}

	public function destroy()
	{
		// Fetch token
		$tokenStr = $this->tokenFetcher->fetchToken();
		// Get user from token
		$user = $this->tokenRepo->getUser($tokenStr);

		// Delete the users token
		$this->tokenRepo->purge($user);

		// Return an empty 204
		return Response::json(null, 204);
	}

}
