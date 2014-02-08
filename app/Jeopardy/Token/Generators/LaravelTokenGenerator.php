<?php
namespace Jeopardy\Token\Generators;

use Illuminate\Support\Str;

class LaravelTokenGenerator implements TokenGeneratorInterface
{
    /**
     * @var \Illuminate\Support\Str
     */
    protected $str;

    /**
     * Constructor
     *
     * @param Str $str
     */
    public function __construct(Str $str)
    {
        $this->str = $str;
    }

    /**
     * Generate a token
     *
     * @param  integer $size
     * @return string
     */
    public function generate($size = 32)
    {
        return $this->str->random($size);
    }
}
