<?php
namespace Jeopardy\Token\Errors;

class TokenErrors
{
    const MISSING               = 10001;
    const WRONG                 = 10002;
    const EXPIRED               = 10003;
    const CREDENTIALSVALIDATION = 10004;
    const WRONGCREDENTIALS      = 10005;
    const UNEXPECTED            = 10006;

    /**
     * Get error message from errorcode
     *
     * @param  integer $code
     * @return string
     */
    public static function getErrorMessage($code)
    {
        switch ($code) {
            case self::MISSING:
                return 'Token missing!';
                break;

            case self::WRONG:
                return 'Wrong token!';
                break;

            case self::EXPIRED:
                return 'Token expired!';
                break;

            case self::CREDENTIALSVALIDATION:
                return 'Credentials failed to validate!';
                break;

            case self::WRONGCREDENTIALS:
                return 'Wrong credentials!';
                break;

            case self::UNEXPECTED:
            default:
                return 'An unexpected token error has occurred';
                break;
        }
    }
}
