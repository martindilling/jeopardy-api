<?php namespace Jeopardy\Responses\Error;

use Illuminate\Support\ServiceProvider;

class ErrorResponseServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('errorresponse', function()
		{
			return new \Jeopardy\Responses\Error\ErrorResponse;
		});
	}

}
