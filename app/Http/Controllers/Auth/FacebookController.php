<?php

namespace SweetFace\Http\Controllers\Auth;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\RedirectResponse;
use SweetFace\User as UserRepositoryContract;
use SweetFace\Http\Controllers\AuthAwareController;
use SweetFace\Services\Facebook\UserStorerContract as GraphUserStorerContract;
use SweetFace\Services\Facebook\Connect\ConnectContract as FacebookConnectContract;

class FacebookController extends AuthAwareController
{
    /**
     * Holds an instance of facebook connector service.
     *
     * @var FacebookConnectContract
     */
    private $facebook;

    /**
     * Holds an instance of graph user storer.
     *
     * @var GraphUserStorerContract
     */
    private $storer;

    /**
     * Holds an instance of user repository.
     *
     * @var UserRepositoryContract
     */
    private $repository;

    /**
     * @inheritdoc
     *
     * @param  GraphUserStorerContract  $storer
     * @param  FacebookConnectContract  $connect
     * @param  UserRepositoryContract   $repository
     */
    public function __construct(
        AuthManager $auth,
        GraphUserStorerContract $storer,
        FacebookConnectContract $connect,
        UserRepositoryContract $repository
    ) {
        $this->storer     = $storer;
        $this->facebook   = $connect;
        $this->repository = $repository;

        parent::__construct($auth);
    }

    /**
     * Redirects user to facebook auth dialog.
     *
     * @return RedirectResponse
     */
    public function redirect()
    {
        return $this->redirectToFacebook();
    }

    /**
     * Facebook's response callback.
     *
     * @return RedirectResponse
     */
    public function callback()
    {
        if ($graphUser = $this->facebook->graphUser() and $user = $this->storer->store($graphUser)) {
            $this->auth->login($user, true);

            return redirect(route('home'));
        }

        return redirect(route('home'))->with('message', 'Could not connect with facebook, please try again.');
    }

    /**
     * Facebook's app deauth callback.
     *
     * @return void
     */
    public function deauth()
    {
        $this->repository->deactivateByGraphId(
            $this->facebook->signedRequest()->getUserId()
        );
    }

    /**
     * Redirects user to facebook.
     *
     * @param  string $callbackRoute
     *
     * @return RedirectResponse
     */
    private function redirectToFacebook($callbackRoute = 'auth.fb.callback')
    {
        // TODO: Read the callback route from the config/env file
        return redirect(
            $this->facebook->loginUri(route($callbackRoute))
        );
    }
}
