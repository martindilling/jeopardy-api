<?php namespace Jeopardy\Token\Repositories;

use User;

interface TokenRepositoryInterface
{
	public function validate($tokenStr);
	public function attempt(array $credentials);
	public function create(User $user);
	public function purge(User $user);
	public function getUser($tokenStr);
}
