<?php namespace Jeopardy\Token\Exceptions;


class TokenMissingException extends \Exception {
	public function __construct($message = "Token Missing", $code = 401, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}
