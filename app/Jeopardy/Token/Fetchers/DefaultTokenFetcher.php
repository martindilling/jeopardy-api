<?php namespace Jeopardy\Token\Fetchers;

use Jeopardy\Token\Fetchers\TokenFetcherInterface;

use Request;
use Input;

class DefaultTokenFetcher implements TokenFetcherInterface {

	public function fetchToken()
	{
		$tokenStr = Request::header('Auth-Token');

		if ( empty($tokenStr) ) {
			$tokenStr = Input::get('auth_token');
		}

		return $tokenStr;
	}
}
