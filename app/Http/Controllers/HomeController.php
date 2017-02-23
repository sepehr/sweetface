<?php

namespace SweetFace\Http\Controllers;

use Illuminate\Auth\AuthManager;

class HomeController extends Controller
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

    /**
     * Homepage.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('home')->with('user', $this->auth->user());
    }
}
