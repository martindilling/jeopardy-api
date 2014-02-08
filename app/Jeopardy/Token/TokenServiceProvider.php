<?php
namespace Jeopardy\Token;

use Illuminate\Support\ServiceProvider;

class TokenServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Jeopardy\Token\Repositories\TokenRepositoryInterface', 'Jeopardy\Token\Repositories\EloquentTokenRepository');

        $this->app->bind('Jeopardy\Token\Generators\TokenGeneratorInterface', 'Jeopardy\Token\Generators\LaravelTokenGenerator');

        $this->app->bind('Jeopardy\Token\Fetchers\TokenFetcherInterface', 'Jeopardy\Token\Fetchers\DefaultTokenFetcher');
    }
}
