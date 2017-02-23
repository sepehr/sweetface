Feature: Facebook Authentication
  In order to see my Facebook basic info on the homepage
  As a user
  I need to be able to login using my Facebook account and logout as well

  Background:
    Given following user exists:
      | id | name | is_active | fb_id | fb_token | avatar |
      | 1  | John Doe | 1 | 123123123 | token | https://graph.facebook.com/v2.8/125045724683814/picture |

  @javascript
  Scenario: Guest On Homepage
    Given I am not logged in
      And am on the homepage
    Then I should see "Login With Facebook"
      But should not see "Logout"

  @javascript
  Scenario: Authenticated User On Homepage
    Given am logged in with Facebook ID "123123123"
      And am on the homepage
    Then I should see "John Doe"
      And should see "Logout?"
      And should see 1 "img" element

  @javascript
  Scenario: Logging Out
    Given I am logged in with Facebook ID "123123123"
    And am on the homepage
    When I follow "Logout?"
    Then I am not logged in anymore
    And am on the homepage
    And should see "Login With Facebook"
