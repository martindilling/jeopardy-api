<?php
namespace Jeopardy\Responses\Error;

use Config;
use Jeopardy\Responses\Api\ApiResponse;
use Response;

class ErrorResponse extends ApiResponse
{
    /**
     * HTTP status code
     *
     * @var int
     */
    protected $statusCode = 500;

    /**
     * Return a json response from the given error
     *
     * @param  int    $errorCode Http error status code
     * @param  string $message   Short error message
     * @param  string $details   More detailed description of the error
     * @param  array  $valErrors Validation errors as array
     * @param  array  $oldInput  Old input when validating
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($errorCode, $message, $details, $valErrors = null, $oldInput = null)
    {
        if ($this->statusCode >= 200 && $this->statusCode < 300) {
            trigger_error(
                "You proberbly shouldn't respond with an error with a successful status " .
                "code[200-300]. Current code is [" .
                $this->statusCode .
                "]",
                E_USER_WARNING
            );
        }

        $data = array(
            'error' => array(
                'code'      => $errorCode,
                'http_code' => $this->statusCode,
                'message'   => $message,
                'details'   => ($details ? : 'none'),
            )
        );

        if ($valErrors) {
            $data['error']['validationerrors'] = $valErrors;
        }

        if ($oldInput) {
            $data['error']['oldinput'] = $oldInput;
        }

        return $this->respondWithArray($data);
    }

    /**
     * Replace in error messages/details
     *
     * @param $error
     * @param $replace
     * @param $with
     * @return mixed
     */
    private function doReplacements($error, $replace, $with)
    {
        $error['message'] = str_replace($replace, $with, $error['message']);
        $error['details'] = str_replace($replace, $with, $error['details']);

        return $error;
    }



    /**
     * ERRORS
     */

    /**
     * Generates a Response with a 400 HTTP header and a given message.
     *
     * @return  Response
     */
    public function fromErrorCode($code)
    {
        $error = Config::get('errors.' . $code);

        return $this
            ->setStatusCode($error['http_code'])
            ->respondWithError($error['code'], $error['message'], $error['details']);
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message.
     *
     * @return  Response
     */
    public function noResourceListing()
    {
        $error = Config::get('errors.list_resource_not_available');

        return $this
            ->setStatusCode($error['http_code'])
            ->respondWithError($error['code'], $error['message'], $error['details']);
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message.
     *
     * @param $resourcename
     * @param $id
     * @return  Response
     */
    public function singleResourceNotFound($resourcename, $id)
    {
        $error = Config::get('errors.single_resource_not_found');
        $error = $this->doReplacements($error, ':resource', $resourcename);
        $error = $this->doReplacements($error, ':id', $id);

        return $this
            ->setStatusCode($error['http_code'])
            ->respondWithError($error['code'], $error['message'], $error['details']);
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message.
     *
     * @param $validationErrors
     * @param $oldInput
     * @return  Response
     */
    public function createResourceValidationError($validationErrors, $oldInput)
    {
        $error = Config::get('errors.create_resource_validation_error');

        return $this
            ->setStatusCode($error['http_code'])
            ->respondWithError($error['code'], $error['message'], $error['details'], $validationErrors, $oldInput);
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message.
     *
     * @param string $message
     * @return  Response
     */
    public function errorBadRequest($message = 'Bad Request')
    {
        return $this->setStatusCode(400)->respondWithError(Config::get('errors.CODE_BAD_REQUEST'), $message);
    }

    /**
     * Generates a Response with a 401 HTTP header and a given message.
     *
     * @param string $message
     * @return  Response
     */
    public function errorUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(401)->respondWithError(Config::get('errors.CODE_UNAUTHORIZED'), $message);
    }

    /**
     * Generates a Response with a 403 HTTP header and a given message.
     *
     * @param string $message
     * @return  Response
     */
    public function errorForbidden($message = 'Forbidden')
    {
        return $this->setStatusCode(403)->respondWithError(Config::get('errors.CODE_FORBIDDEN'), $message);
    }

    /**
     * Generates a Response with a 404 HTTP header and a given message.
     *
     * @param string $message
     * @return  Response
     */
    public function errorNotFound($message = 'Resource Not Found')
    {
        return $this->setStatusCode(404)->respondWithError(Config::get('errors.CODE_NOT_FOUND'), $message);
    }

    /**
     * Generates a Response with a 500 HTTP header and a given message.
     *
     * @param string $message
     * @return  Response
     */
    public function errorInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(500)->respondWithError(Config::get('errors.CODE_INTERNAL_ERROR'), $message);
    }
}
