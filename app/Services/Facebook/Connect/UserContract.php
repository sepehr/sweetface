<?php

namespace SweetFace\Services\Facebook\Connect;

use Facebook\FacebookResponse;
use Facebook\Authentication\AccessToken;
use Illuminate\Contracts\Support\Arrayable;

interface UserContract extends Arrayable
{
    /**
     * Static factory method.
     *
     * @param  array  $args
     *
     * @return UserContract
     */
    public static function make(...$args): UserContract;

    /**
     * Static factory method to create an instance from a FacebookResponse and a AccessToken.
     *
     * @param  FacebookResponse  $response
     * @param  AccessToken       $token
     *
     * @return UserContract
     */
    public static function makeFromResponse(FacebookResponse $response, AccessToken $token): UserContract;

    /**
     * ID getter.
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Name getter.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Avatar getter.
     *
     * @return string
     */
    public function getAvatar(): string;

    /**
     * Token getter.
     *
     * @return string
     */
    public function getToken(): string;
}
