<?php
namespace Jeopardy\Token\Fetchers;

interface TokenFetcherInterface
{
    /**
     * Fetch the token
     *
     * @return string
     */
    public function fetchToken();
}
