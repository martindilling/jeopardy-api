<?php

use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Manager;
use Jeopardy\Responses\Api\ApiResponse;

class ApiController extends Controller
{
	protected $fractal;
	protected $api;

	/**
	 * Constructor
	 *
	 * @param Manager     $fractal
	 * @param ApiResponse $api
	 */
	public function __construct(Manager $fractal, ApiResponse $api)
	{
		$this->fireDebugFilters();

		$this->fractal = $fractal;

		// Are we going to try and include embedded data?
		$this->fractal->setRequestedScopes(explode(',', Input::get('embed')));

		$this->api = $api;
	}

	public function fireDebugFilters()
	{
		$this->beforeFilter(function() {
			Event::fire('clockwork.controller.start');
		});

		$this->afterFilter(function() {
			Event::fire('clockwork.controller.end');
		});
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
	 * @return self
	 */
	public function setStatusCode($statusCode)
	{
		$this->api->setStatusCode($statusCode);
		return $this;
	}

	/**
	 * Return a json response from the given item
	 *
	 * @param  mixed  $item        The item to return as json
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

}
