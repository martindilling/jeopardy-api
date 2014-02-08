<?php

/**
 * An Eloquent Model: 'BaseModel'
 *
 */
class BaseModel extends Eloquent
{
    /**
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
    }
}
