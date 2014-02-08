<?php

use Jeopardy\Transformers\UserTransformer;

class ApiTokenController extends ApiController
{
    /**
     * Get the user associated with the token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Get user from token
        $user = $this->getTokenUser();

        // Return the user item
        return $this->respondWithItem($user, new UserTransformer);
    }

    /**
     * Authenticate a user and return an access token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        // Get input
        $input = Input::all();

        // Attempt to generate token for the user
        $token = $this->tokenRepo->attempt($input);

        // Return the generated token and user item
        return Response::json(array(
            'token' => $token->token,
            'user'  => $token->user->toArray()
        ), 201);
    }

    /**
     * Destroy a token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        // Get user from token
        $user = $this->getTokenUser();

        // Delete the users token
        $this->tokenRepo->purge($user);

        // Return an empty 204
        return Response::json(null, 204);
    }
}
