<?php
namespace Jeopardy\Responses\Error;

use Illuminate\Support\Facades\Facade;

class ErrorResponseFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'errorresponse';
    }
}
