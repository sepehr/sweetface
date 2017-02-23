<?php

namespace SweetFace\Services\Facebook\Connect;

use Illuminate\Support\Fluent;

/**
 * Represents facebook login error data.
 *
 *
 * @property  string  $code
 * @property  string  $error
 * @property  string  $reason
 * @property  string  $description
 */
class Error extends Fluent
{
    /**
     * Static factory method.
     *
     * @param  array $args
     *
     * @return $this
     */
    public static function make(...$args)
    {
        return new static(...$args);
    }
}
