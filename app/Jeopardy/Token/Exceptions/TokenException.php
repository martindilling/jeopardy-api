<?php
namespace Jeopardy\Token\Exceptions;

use Jeopardy\Token\Errors\TokenErrors;
use Log;

class TokenException extends \Exception
{
    public function __construct($error_code)
    {
        parent::__construct(TokenErrors::getErrorMessage($error_code), $error_code);
        Log::error('TokenException [' . $error_code . ']: ' . TokenErrors::getErrorMessage($error_code));
    }
}
