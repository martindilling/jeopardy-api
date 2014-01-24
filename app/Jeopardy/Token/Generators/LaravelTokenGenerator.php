<?php namespace Jeopardy\Token\Generators;

use Illuminate\Support\Str;

class LaravelTokenGenerator implements TokenGeneratorInterface
{
	protected $str;

	public function __construct(Str $str)
	{
		$this->str = $str;
	}

	public function generate($size = 32)
	{
		return $this->str->random($size);
	}
}
