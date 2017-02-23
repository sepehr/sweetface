Feature: Facebook Authentication
  In order to see my Facebook basic info on the homepage
  As a user
  I need to be able to login using my Facebook account and logout as well

  Scenario: Guest On Homepage
    Given I am not logged in
      And am on the homepage
    Then I should see "Login With Facebook"
      But should not see "Logout"

  Scenario: Authenticated User On Homepage
    Given following user exists:
      | id | name | is_active | fb_id | fb_token | avatar |
      | 1  | John Doe | 1 | 123123123 | token | https://graph.facebook.com/v2.8/125045724683814/picture |
      And am logged in with Facebook ID "123123123"
      And am on the homepage
    Then I should see "John Doe"
      And should see "Logout?"
      And should see 1 "img" element
