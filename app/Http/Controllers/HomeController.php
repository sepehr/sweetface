<?php

namespace SweetFace\Http\Controllers;

class HomeController extends AuthAwareController
{
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
