<?php

namespace Tests\Acceptance\Context;

use SweetFace\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Illuminate\Support\Facades\Auth;
use Laracasts\Behat\Context\Migrator;
use PHPUnit_Framework_Assert as PHPUnit;
use Behat\MinkExtension\Context\MinkContext;
use Laracasts\Behat\Context\DatabaseTransactions;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context
{
    use Migrator, DatabaseTransactions;

    /**
     * Holds user's facebook ID.
     *
     * @var string
     */
    private $fbId;

    /**
     * @Given /^(?:|I?\s?am)?\s?not logged in\s?(?:|anymore)?$/
     */
    public function notLoggedIn()
    {
        $this->assertGuest();
    }

    /**
     * @Given /^(?:|I?\s?am)?\s?logged in with Facebook ID "([^"]*)"$/
     *
     * Logins the user with the given Facebook ID.
     *
     * @param  string $fbId
     */
    public function loginWithFacebookId($fbId)
    {
        $this->withFacebookId($fbId);

        $this->loginAs(User::whereFbId($fbId)->first());

        $this->assertAuthenticated();
    }

    /**
     * @Given /^following users? exists?:$/
     *
     * @param  TableNode $table
     */
    public function followingUsersExist(TableNode $table)
    {
        foreach ($table as $row) {
            User::create($row);
        }

        PHPUnit::assertCount(User::count(), $table);
    }

    /**
     * Assert that the user is logged in.
     */
    private function assertAuthenticated()
    {
        PHPUnit::assertTrue(Auth::check());
    }

    /**
     * Assert that the user is not authenticated.
     */
    private function assertGuest()
    {
        PHPUnit::assertTrue(Auth::guest());
    }

    private function withFacebookId($fbId)
    {
        $this->fbId = $fbId;
    }

    /**
     * Logs the user object in.
     *
     * @param  User $user
     */
    private function loginAs($user)
    {
        Auth::login($user, true);
    }
}
