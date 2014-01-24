<?php namespace Jeopardy\Token\Filters;

use Jeopardy\Token\Repositories\TokenRepositoryInterface;
use Jeopardy\Token\Fetchers\TokenFetcherInterface;

use Illuminate\Events\Dispatcher;
use Log, Event;


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

	function __construct(TokenRepositoryInterface $tokenRepo, TokenFetcherInterface $tokenFetcher, Dispatcher $events)
	{
		$this->tokenRepo = $tokenRepo;
		$this->tokenFetcher = $tokenFetcher;
		$this->events = $events;
	}

	function filter($route, $request) {
		Log::info('Running the token filter.');
		$tokenStr = $this->tokenFetcher->fetchToken();
		$user = $this->tokenRepo->validate($tokenStr);
		// dd($this->events->getListeners('auth.token.valid'));
		$this->events->fire('auth.token.valid', $user);
	}
}
