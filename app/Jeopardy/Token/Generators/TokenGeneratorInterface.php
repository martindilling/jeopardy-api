<?php namespace Jeopardy\Token\Generators;

interface TokenGeneratorInterface
{
	public function generate($size = 32);
}
