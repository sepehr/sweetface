<?php

namespace SweetFace\Http\Controllers\Auth;

use SweetFace\Http\Controllers\AuthAwareController;

class AuthController extends AuthAwareController
{
    /**
     * Logouts users.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        if ($user = $this->auth->user()) {
            $user->expireToken();

            $this->auth->logout();

            return redirect(route('home'))->with('message', 'OK, See you later!');
        }

        return redirect(route('home'));
    }
}
