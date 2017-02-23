<?php

namespace SweetFace\Services\Facebook;

use SweetFace\User as UserRepositoryContract;
use SweetFace\Services\Facebook\Connect\UserContract as GraphUserContract;

class UserStorer implements UserStorerContract
{
    /**
     * User repository.
     *
     * @var UserRepositoryContract
     */
    protected $repository;

    /**
     * GraphUserStorer constructor.
     *
     * @param  UserRepositoryContract  $repository
     */
    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritdoc
     */
    public function store(GraphUserContract $graphUser) : UserRepositoryContract
    {
        return $this->repository->createFromGraphUser($graphUser);
    }
}
