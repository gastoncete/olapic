@delete
Feature: Testing rest API DELETE for sonar service.
  In order to delete provider places,
  a request with provider and placeId is sent to sonar.

  Scenario Outline: Verify that a existing place is deleted when the provider and providerId values are valid.
    Given a place exists for provider "<provider>" with id "<providerId>"
    When I delete the place for the provider "<provider>" with id "<providerId>"
    Then the place is deleted
    When the I ask for the place for provider "<provider>" with id "<providerId>"
    Then the place is not returned

    Examples:
      | provider   | providerId                  |
      | facebook   | 238779122798993          |
      | foursquare | 5188db08498e765ce1ba6f66 |

  Scenario Outline: Verify that when a place is deleted for second time, an error is returned.
    Given a place exists for provider "<provider>" with id "<providerId>"
    When I delete the place for the provider "<provider>" with id "<providerId>"
    Then the place is deleted
    When I delete the place for the provider "<provider>" with id "<providerId>"
    Then the delete return error

    Examples:
      | provider   | providerId                  |
      | facebook   | 238779122798993          |
      | foursquare | 5188db08498e765ce1ba6f66 |

  Scenario: Verify that a error is returned when the place does not exist.
    When I delete the place for the provider "facebook" with id "doesNotExists"
    Then the delete return error