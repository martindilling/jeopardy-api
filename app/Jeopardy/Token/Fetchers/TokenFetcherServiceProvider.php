<?php
namespace Jeopardy\Token\Fetchers;

use Illuminate\Support\ServiceProvider;

class TokenFetcherServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('tokenfetcher', 'Jeopardy\Token\Fetcher\TokenFetcher');
    }
}
