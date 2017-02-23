<?php

namespace SweetFace\Http\Controllers;

use Illuminate\Auth\AuthManager;

abstract class AuthAwareController extends Controller
{
    /**
     * AuthManager instance.
     *
     * @var AuthManager
     */
    protected $auth;

    /**
     * AuthController constructor.
     *
     * @param AuthManager $auth
     */
    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }
}
