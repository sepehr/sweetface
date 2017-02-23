Feature: Facebook Authentication
  In order to see my Facebook basic info on the homepage
  As a user
  I need to be able to login using my Facebook account and logout as well

  Scenario: Guest On Homepage
    Given I am not logged in
    And am on the homepage
    Then I should see "Login With Facebook"
    But should not see "Logout"
