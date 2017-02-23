<?php

namespace Tests\Acceptance\Context;

use SweetFace\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use PHPUnit_Framework_Assert as PHPUnit;
use Laracasts\Behat\Context\MigrateRefresh;
use Behat\MinkExtension\Context\MinkContext;
use Sepehr\BehatLaravelJs\Concerns\AuthenticateUsers;
use Sepehr\BehatLaravelJs\Concerns\PreserveBehatEnvironment;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context
{
    use PreserveBehatEnvironment, AuthenticateUsers, MigrateRefresh;

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
}
