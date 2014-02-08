<?php

return array(

    'BAD_REQUEST'                      => 'Bad Request',
    'UNAUTHORIZED'                     => 'Unauthorized',
    'FORBIDDEN'                        => 'Forbidden',
    'NOT_FOUND'                        => 'Not Found',
    'INTERNAL_ERROR'                   => 'Internal Error',
    /**
     * Unknown error
     */
    'unknown'                          => array(
        'code'      => 0,
        'http_code' => 500,
        'message'   => 'Unknown error.',
        'details'   => '',
    ),
    /**
     * Validation errors
     * 100-199
     */
    'create_resource_validation_error' => array(
        'code'      => 100,
        'http_code' => 400,
        'message'   => 'Validation failed.',
        'details'   => '',
    ),
    /**
     * Not available errors
     * 200-299
     */
    'list_resource_not_available'      => array(
        'code'      => 200,
        'http_code' => 400,
        'message'   => 'Listing all of this resource isn\'t available.',
        'details'   => 'You can\'t get all of this resource, you need to embed it with another resource. For example: You can\'t get all categories, but you can get all categories embedded with a specific game with /games/3?embed=categories. Or to just get the categories for the game: /games/3/categories',
    ),
    /**
     * Not found errors
     * 300-399
     */
    'single_resource_not_found'        => array(
        'code'      => 300,
        'http_code' => 404,
        'message'   => 'The :resource requested was not found.',
        'details'   => 'Could not find the resource [:resource] with id [:id], either it was deleted or it never existed.',
    ),


);
