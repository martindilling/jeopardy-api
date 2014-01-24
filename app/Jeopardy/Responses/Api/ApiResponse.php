<?php namespace Jeopardy\Responses\Api;

use Response;

class ApiResponse
{
	protected $statusCode = 200;

	/**
	 * Get the http statusCode
	 *
	 * @return int
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	 * Set the http statusCode
	 *
	 * @param int $statusCode
	 * @return self
	 */
	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode = (int) $statusCode;
		return $this;
	}

	/**
	 * Return a json response from an array
	 *
	 * @param  mixed $array   The response data
	 * @param  array $headers An array of response headers
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function respondWithArray(array $array, array $headers = array())
	{
		$response = Response::json($array, $this->statusCode, $headers);

		// $response->header('Content-Type', 'application/json');

		return $response;
	}

}
