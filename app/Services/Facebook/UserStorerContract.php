<?php
namespace SweetFace\Services\Facebook;

use SweetFace\User as UserRepositoryContract;
use SweetFace\Services\Facebook\Connect\UserContract as GraphUserContract;

interface UserStorerContract
{
    /**
     * Stores a graph user data only if not already exists. If exists, activates her.
     *
     * @param  GraphUserContract $graphUser
     *
     * @return UserRepositoryContract
     */
    public function store(GraphUserContract $graphUser): UserRepositoryContract;
}
