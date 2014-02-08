<?php

/**
 * An Eloquent Model: 'BaseModel'
 *
 */
class BaseModel extends Eloquent
{
    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
    }
}
