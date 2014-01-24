<?php namespace Jeopardy\Token\Exceptions;


class TokenExpiredException extends \Exception {
	public function __construct($message = "Token Expired", $code = 401, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}
