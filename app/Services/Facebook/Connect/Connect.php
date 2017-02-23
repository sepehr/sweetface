<?php

namespace SweetFace\Services\Facebook\Connect;

use Facebook\FacebookResponse;
use Facebook\Authentication\AccessToken;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk as Sdk;

class Connect implements ConnectContract
{
    /**
     * Holds an instance of Sdk.
     *
     * @var Sdk
     */
    protected $sdk;

    /**
     * Local callback URI.
     *
     * @var string
     */
    protected $callbackUri;

    /**
     * Array of scopes.
     *
     * @var array
     */
    protected $scopes = [];

    /**
     * Holds access token instance.
     *
     * @var AccessToken
     */
    private $token;

    /**
     * Holds signed request instance.
     *
     * @var SignedRequest
     */
    private $signed;

    /**
     * Connect constructor.
     *
     * @param  Sdk            $sdk
     * @param  SignedRequest  $signed
     * @param  string|null    $uri
     * @param  array|null     $scopes
     */
    public function __construct(Sdk $sdk, SignedRequest $signed, ?string $uri = null, ?array $scopes = null) {
        $this->initialize($sdk, $signed, $uri, $scopes);
    }

    /**
     * @inheritdoc
     */
    public static function make(...$args): ConnectContract
    {
        return new static(...$args);
    }

    /**
     * @inheritdoc
     */
    public function initialize(Sdk $sdk, SignedRequest $signed, ?string $uri, ?array $scopes): ConnectContract
    {
        $this->withSdk($sdk);

        $this->signed = $signed;

        $scopes and $this->withScopes($scopes);
        $uri    and $this->withCallbackUri($uri);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function withSdk(Sdk $sdk): ConnectContract
    {
        $this->sdk = $sdk;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function withCallbackUri(string $uri): ConnectContract
    {
        $this->callbackUri = $uri;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function withScopes(array $scopes): ConnectContract
    {
        $this->scopes = $scopes;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function sdk(): Sdk
    {
        return $this->sdk;
    }

    /**
     * @inheritdoc
     */
    public function signedRequest(): SignedRequest
    {
        return $this->signed;
    }

    /**
     * @inheritdoc
     */
    public function loginUri(?string $uri): string
    {
        $uri and $this->withCallbackUri($uri);

        if (! $this->callbackUri) {
            // @TODO: Utilize custom service-specific exceptions
            throw new \Exception('Cannot generate a login URI without a callback URI set.');
        }

        return $this->sdk
            ->getRedirectLoginHelper()
            ->getLoginUrl($this->callbackUri, $this->scopes);
    }

    /**
     * @inheritdoc
     */
    public function token(bool $setSdkToken = true): ?AccessToken
    {
        $this->token = $this->redirectHelperAccessToken();

        $setSdkToken and $this->setSdkAccessToken($this->token);

        return $this->token;
    }

    /**
     * @inheritdoc
     */
    public function longLivedToken(bool $setSdkToken = true): ?AccessToken
    {
        if ($token = $this->token(false) and $token = $this->exchangeToken($token)) {
            $setSdkToken and $this->setSdkAccessToken($token);

            return $token;
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function exchangeToken(AccessToken $token): AccessToken
    {
        if ($token->isLongLived()) {
            return $token;
        }

        return ($this->sdk->getOAuth2Client())->getLongLivedAccessToken($token);
    }

    /**
     * @inheritdoc
     */
    public function graphUser(array $fields = ['id', 'name', 'picture.type(large)']): ?User
    {
        $this->hasToken() or $this->longLivedToken();

        return $this->hasToken()
            ? $this->makeUser($this->requestUserData($fields))
            : null;
    }

    /**
     * @inheritdoc
     */
    public function error()
    {
        $helper = $this->sdk->getRedirectLoginHelper();

        if ($helper->getError()) {
            return Error::make([
                'error'       => $helper->getError(),
                'code'        => $helper->getErrorCode(),
                'reason'      => $helper->getErrorReason(),
                'description' => $helper->getErrorDescription(),
            ]);
        }

        return false;
    }

    /**
     * Sets SDK default access token.
     *
     * @param  AccessToken $token
     *
     * @return ConnectContract
     */
    private function setSdkAccessToken(AccessToken $token): ConnectContract
    {
        $this->sdk->setDefaultAccessToken($token);

        return $this;
    }

    /**
     * Returns SDK's redirect login helper access token.
     *
     * @return AccessToken|null
     */
    private function redirectHelperAccessToken(): ?AccessToken
    {
        return $this->sdk->getRedirectLoginHelper()->getAccessToken();
    }

    /**
     * Checks if the access token exists or not.
     *
     * @return bool
     */
    private function hasToken(): bool
    {
        return $this->token instanceof AccessToken;
    }

    /**
     * Reuqests the Graph API for basic user data based on the passed fields param.
     *
     * @param  array  $fields
     *
     * @return FacebookResponse
     *
     * @throws \Exception
     */
    private function requestUserData(array $fields): FacebookResponse
    {
        $fields   = $this->prepareRequestFields($fields);
        $response = $this->sdk->get("/me?fields=$fields");

        if ($response->getHttpStatusCode() === 200) {
            return $response;
        }

        throw new \Exception('Could not fetch user data.');
    }

    /**
     * Creates a User instance out of the decoded body array.
     *
     * @param  FacebookResponse  $response
     *
     * @return User
     */
    private function makeUser(FacebookResponse $response): User
    {
        return User::makeFromResponse($response, $this->token);
    }

    /**
     * Prepares field names for the request.
     *
     * @param  array  $fields
     *
     * @return string
     */
    private function prepareRequestFields(array $fields): string
    {
        return implode(',', $fields);
    }
}
