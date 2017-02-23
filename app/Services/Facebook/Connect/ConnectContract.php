<?php
namespace SweetFace\Services\Facebook\Connect;

use Facebook\Authentication\AccessToken;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk as Sdk;

interface ConnectContract
{
    /**
     * Static factory method.
     *
     * @param  array  $args
     *
     * @return ConnectContract
     */
    public static function make(...$args): ConnectContract;

    /**
     * Property initializor.
     *
     * @param  Sdk            $sdk
     * @param  SignedRequest  $signed
     * @param  string|null    $uri
     * @param  array|null     $scopes
     *
     * @return ConnectContract
     */
    public function initialize(Sdk $sdk, SignedRequest $signed, ?string $uri, ?array $scopes): ConnectContract;

    /**
     * SDK instance setter.
     *
     * @param  Sdk  $sdk
     *
     * @return ConnectContract
     */
    public function withSdk(Sdk $sdk): ConnectContract;

    /**
     * Callback URI setter.
     *
     * @param  string  $uri
     *
     * @return ConnectContract
     */
    public function withCallbackUri(string $uri): ConnectContract;

    /**
     * Scopes setter.
     *
     * @param  array  $scopes
     *
     * @return ConnectContract
     */
    public function withScopes(array $scopes): ConnectContract;

    /**
     * SDK instance getter.
     *
     * @return Sdk
     */
    public function sdk(): Sdk;

    /**
     * Signed request instance getter.
     *
     * @return SignedRequest
     */
    public function signedRequest(): SignedRequest;

    /**
     * Generates and returns the login URI.
     *
     * @param  string|null  $uri
     *
     * @return string
     *
     * @throws \Exception
     */
    public function loginUri(?string $uri): string;

    /**
     * Returns the login token instance; a short-lived one.
     *
     * @param  bool  $setSdkToken
     *
     * @return AccessToken|null
     */
    public function token(bool $setSdkToken = true): ?AccessToken;

    /**
     * Gets the short-lived token and deals it with a long-lived one.
     *
     * NOTE: Should not be used if token() is already called. Either use
     *       this method or token().
     *
     * @param  bool  $setSdkToken
     *
     * @return AccessToken|null
     */
    public function longLivedToken(bool $setSdkToken = true): ?AccessToken;

    /**
     * Exchanges a short-living access token for a long-living one.
     *
     * @param  AccessToken $token
     *
     * @return AccessToken
     */
    public function exchangeToken(AccessToken $token): AccessToken;

    /**
     * Queries an authorized user data from facebook and creates a User instance out of it.
     *
     * @param  array  $fields
     *
     * @return User|null
     */
    public function graphUser(array $fields = ['id', 'name', 'picture.type(large)']): ?User;

    /**
     * Returns an instance of Error if any error is occured during the login.
     *
     * @return Error|bool
     */
    public function error();
}
