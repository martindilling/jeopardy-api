<?php namespace Jeopardy\Responses\Api;

use Illuminate\Support\ServiceProvider;

class ApiResponseServiceProvider extends ServiceProvider
{

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('apiresponse', 'Jeopardy\Responses\Api\ApiResponse');
	}
}
