<?php
namespace Jeopardy\Token\Repositories;

use User;

interface TokenRepositoryInterface
{
    /**
     * Get token instance from given token
     *
     * @param  string  $tokenStr
     * @param  boolean $forceDB
     *
     * @throws \Jeopardy\Token\Exceptions\TokenException
     * @return \Jeopardy\Token\Token
     */
    public function get($tokenStr, $forceDB = false);

    /**
     * Attempt to create a token for a user
     *
     * @param  array $credentials Must contain 'email' and 'password'
     *
     * @throws \Jeopardy\Token\Exceptions\TokenException
     * @return \Jeopardy\Token\Token
     */
    public function attempt(array $credentials);

    /**
     * Create a token for given user
     *
     * @param  User $user
     *
     * @return \Jeopardy\Token\Token
     */
    public function create(User $user);

    /**
     * Delete given users existing token
     *
     * @param  User $user
     *
     * @return bool|null
     */
    public function purge(User $user);

    /**
     * Get user from given token
     *
     * @param  string $tokenStr
     * @param bool    $forceDB
     *
     * @return User
     */
    public function getUser($tokenStr, $forceDB = false);
}
