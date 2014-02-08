<?php
namespace Jeopardy\Token\Filters;

use Event;
use Illuminate\Events\Dispatcher;
use Jeopardy\Token\Fetchers\TokenFetcherInterface;
use Jeopardy\Token\Repositories\TokenRepositoryInterface;
use Log;

class TokenFilter
{
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
    public function __construct(
        TokenRepositoryInterface $tokenRepo,
        TokenFetcherInterface $tokenFetcher,
        Dispatcher $events
    ) {
        $this->tokenRepo    = $tokenRepo;
        $this->tokenFetcher = $tokenFetcher;
        $this->events       = $events;
    }

    /**
     * Filter to check for a valid token
     *
     * @param $route
     * @param $request
     */
    public function filter($route, $request)
    {
        Log::info('Token filter on: ' . $route->getUri());

        // Fetch token
        $tokenStr = $this->tokenFetcher->fetchToken();

        // Get token
        $token = $this->tokenRepo->get($tokenStr);

        // Update lastuse_at
        $token->usedNow();

        // Fire event in case something needs to know
        Event::fire('auth.token.valid', $token);
    }
}
