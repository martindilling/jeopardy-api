<?php namespace Jeopardy\Token\Filters;

use Jeopardy\Token\Repositories\TokenRepositoryInterface;
use Jeopardy\Token\Fetchers\TokenFetcherInterface;

use Illuminate\Events\Dispatcher;
use Log, Event, DateTime;


class TokenFilter {

	/**
	 * The event dispatcher instance.
	 *
	 * @var \Illuminate\Events\Dispatcher
	 */
	protected $events;

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
	 * @param Dispatcher               $events
	 */
	function __construct(TokenRepositoryInterface $tokenRepo, TokenFetcherInterface $tokenFetcher, Dispatcher $events)
	{
		$this->tokenRepo = $tokenRepo;
		$this->tokenFetcher = $tokenFetcher;
		$this->events = $events;
	}

	/**
	 * Filter to check for a valid token
	 *
	 * @param  [type] $route
	 * @param  [type] $request
	 */
	function filter($route, $request) {
		Log::info('Token filter on: ' . $route->getUri());

		// Fetch token
		$tokenStr = $this->tokenFetcher->fetchToken();

		// Validate token
		$user = $this->tokenRepo->validate($tokenStr);

		// Update lastuse_at
		$token = $user->getToken();
		$token->usedNow();

		// Fire event in case something needs to know
		Event::fire('auth.token.valid', $user->getToken());
	}
}
