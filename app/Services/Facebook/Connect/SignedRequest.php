<?php

namespace SweetFace\Services\Facebook\Connect;

use Facebook\FacebookApp;
use Facebook\FacebookClient;
use Illuminate\Http\Request;
use Facebook\Helpers\FacebookSignedRequestFromInputHelper;

class SignedRequest extends FacebookSignedRequestFromInputHelper
{
    /**
     * Holds request instance.
     *
     * @var Request
     */
    protected $request;

    /**
     * @inheritdoc
     *
     * @param  Request  $request
     */
    public function __construct(Request $request, FacebookApp $app, FacebookClient $client, $graphVersion = null)
    {
        $this->request = $request;

        parent::__construct($app, $client, $graphVersion);
    }

    /**
     * Get raw signed request from input.
     *
     * @return string|null
     */
    public function getRawSignedRequest()
    {
        return $this->request->input('signed_request');
    }
}
