<?php namespace Jeopardy\Token\Fetchers;

use Illuminate\Support\ServiceProvider;

class TokenFetcherServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('tokenfetcher', 'Jeopardy\Token\Fetcher\TokenFetcher');
	}
}
