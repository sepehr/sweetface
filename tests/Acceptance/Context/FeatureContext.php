<?php

namespace Tests\Acceptance\Context;

use Behat\Behat\Context\Context;
use Illuminate\Support\Facades\Auth;
use PHPUnit_Framework_Assert as PHPUnit;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context
{
    /**
     * @Given /^(?:|I?\s?am)?\s?not logged in\s?(?:|anymore)?$/
     */
    public function notLoggedIn()
    {
        PHPUnit::assertTrue(Auth::guest());
    }
}
