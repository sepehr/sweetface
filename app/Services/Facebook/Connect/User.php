<?php

namespace SweetFace\Services\Facebook\Connect;

use Facebook\FacebookResponse;
use Illuminate\Support\Fluent;
use Facebook\Authentication\AccessToken;

/**
 * Represents a facebook user data.
 *
 *
 * @property  string  $token
 * @property  string  $id
 * @property  string  $name
 * @property  string  $avatar
 */
class User extends Fluent implements UserContract
{
    /**
     * @inheritdoc
     */
    public static function make(...$args): UserContract
    {
        return new static(...$args);
    }

    /**
     * @inheritdoc
     */
    public static function makeFromResponse(FacebookResponse $response, AccessToken $token): UserContract
    {
        $response = $response->getDecodedBody();

        return new static([
            'id'     => $response['id'],
            'name'   => $response['name'],
            'token'  => $token->getValue(),
            'avatar' => $response['picture']['data']['url'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    /**
     * @inheritdoc
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
