<?php namespace Jeopardy\Token\Exceptions;


class WrongCredentialsException extends \Exception {
	public function __construct($message = "Wrong Credentials", $code = 401, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}
