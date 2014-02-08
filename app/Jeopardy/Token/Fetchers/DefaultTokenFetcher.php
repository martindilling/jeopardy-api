<?php
namespace Jeopardy\Token\Fetchers;

use Input;
use Request;

class DefaultTokenFetcher implements TokenFetcherInterface
{
    /**
     * Fetch the token
     *
     * @return string
     */
    public function fetchToken()
    {
        $tokenStr = Request::header('Auth-Token');

        // If no token in header check for it as an parameter
        if (empty($tokenStr)) {
            $tokenStr = Input::get('auth_token');
        }

        return $tokenStr;
    }
}
