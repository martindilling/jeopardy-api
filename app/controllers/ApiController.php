<?php

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class ApiController extends Controller
{
    /**
     * @var \Jeopardy\Token\Repositories\TokenRepositoryInterface
     */
    protected $tokenRepo;

    /**
     * @var \Jeopardy\Token\Fetchers\TokenFetcherInterface
     */
    protected $tokenFetcher;

    /**
     * @var \League\Fractal\Manager
     */
    protected $fractal;

    /**
     * @var \Jeopardy\Responses\Api\ApiResponse
     */
    protected $api;

    /**
     * Constructor
     *
     * @internal param \League\Fractal\Manager $fractal
     * @internal param \Jeopardy\Responses\Api\ApiResponse $api
     * @internal param \Jeopardy\Token\Repositories\TokenRepositoryInterface $tokenRepo
     * @internal param \Jeopardy\Token\Fetchers\TokenFetcherInterface $tokenFetcher
     */
    public function __construct()
    {
        $this->fireDebugFilters();

        $this->fractal = App::make('League\Fractal\Manager');

        // Are we going to try and include embedded data?
        $this->fractal->setRequestedScopes(explode(',', Input::get('embed')));

        $this->api          = App::make('apiresponse');
        $this->tokenRepo    = App::make('Jeopardy\Token\Repositories\TokenRepositoryInterface');
        $this->tokenFetcher = App::make('Jeopardy\Token\Fetchers\TokenFetcherInterface');
    }

    /**
     * Set before/after filters that starts/stops Clockwork
     */
    public function fireDebugFilters()
    {
        $this->beforeFilter(function () {
            Event::fire('clockwork.controller.start');
        });

        $this->afterFilter(function () {
            Event::fire('clockwork.controller.end');
        });
    }

    /**
     * Return a json response from the given item
     *
     * @param  mixed $item         The item to return as json
     * @param  object $transformer Implementation of \League\Fractal\TransformerAbstract
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithItem($item, $transformer)
    {
        $resource = new Item($item, $transformer);

        $rootScope = $this->fractal->createData($resource);

        return $this->api->respondWithArray($rootScope->toArray());
    }

    /**
     * Return a json response from the given collection
     *
     * @param  mixed  $collection  The collection of item to return as json
     * @param  object $transformer Implementation of \League\Fractal\TransformerAbstract
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithCollection($collection, $transformer)
    {
        $resource = new Collection($collection, $transformer);

        if ($collection instanceof Illuminate\Pagination\Paginator) {
            $resource->setPaginator(new IlluminatePaginatorAdapter($collection));
        }

        $rootScope = $this->fractal->createData($resource);

        return $this->api->respondWithArray($rootScope->toArray());
    }

    /**
     * Get the http statusCode
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->api->getStatusCode;
    }

    /**
     * Set the http statusCode
     *
     * @param int $statusCode
     *
     * @return self
     */
    public function setStatusCode($statusCode)
    {
        $this->api->setStatusCode($statusCode);

        return $this;
    }

    /**
     * Get the user associated with the token
     *
     * @return User
     */
    public function getTokenUser()
    {
        // Fetch token
        $tokenStr = $this->tokenFetcher->fetchToken();
        // Get user from token
        $user = $this->tokenRepo->getUser($tokenStr);

        return $user;
    }
}
