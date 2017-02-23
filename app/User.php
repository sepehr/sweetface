<?php

namespace SweetFace;

use Illuminate\Foundation\Auth\User as Authenticatable;
use SweetFace\Services\Facebook\Connect\UserContract as GraphUserContract;

class User extends Authenticatable
{
    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name', 'avatar', 'is_active', 'fb_id', 'fb_token'
    ];

    /**
     * @inheritdoc
     */
    protected $hidden = [
        'fb_token', 'remember_token',
    ];

    /**
     * Wipes user's facebook token.
     *
     * @return bool
     */
    public function expireToken()
    {
        return $this->fill(['fb_token' => null])->save();
    }

    /**
     * Creates or updates the user data based on the passed graph user instance.
     *
     * @param  GraphUserContract  $graphUser
     *
     * @return User
     */
    public function createFromGraphUser(GraphUserContract $graphUser)
    {
        return $this->updateOrCreate(
            ['fb_id' => $graphUser->getId()],
            $this->prepareGraphUser($graphUser)
        );
    }

    /**
     * Deactivates a user by her graph ID.
     *
     * @param  string  $graphId
     *
     * @return bool
     */
    public function deactivateByGraphId(string $graphId)
    {
        return $this->whereFbId($graphId)
            ->first()
            ->fill(['is_active' => false, 'fb_token' => null])
            ->save();
    }

    /**
     * Prepares graph user data into an array for insertion.
     *
     * @param  GraphUserContract  $graphUser
     *
     * @return array
     */
    private function prepareGraphUser(GraphUserContract $graphUser) : array
    {
        return [
            'is_active' => true,
            'fb_id'     => $graphUser->getId(),
            'name'      => $graphUser->getName(),
            'fb_token'  => $graphUser->getToken(),
            'avatar'    => $graphUser->getAvatar(),
        ];
    }
}
