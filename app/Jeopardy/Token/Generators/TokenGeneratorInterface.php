<?php
namespace Jeopardy\Token\Generators;

interface TokenGeneratorInterface
{
    /**
     * Generate a token
     *
     * @param  integer $size
     * @return string
     */
    public function generate($size = 32);
}
