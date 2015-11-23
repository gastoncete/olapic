@delete
Feature: Testing rest API DELETE for sonar service.
  In order to delete the provider place,
  a request with provider_name and provider_place_id is sent to sonar.

  Scenario Outline: Verify that a existing place is deleted sending the provider_name and provider_place_id values and this place is not returned after.
    Given a place exists for provider "<provider_name>" with id "<provider_place_id>"
    When I delete the place for the provider "<provider_name>" with id "<provider_place_id>"
    Then the place is deleted
    When the place for provider "<provider_name>" with id "<provider_place_id>" is asked
    Then the place is not returned

    Examples:
      | provider_name | provider_place_id        |
      | facebook      | 238779122798993          |
      | foursquare    | 5188db08498e765ce1ba6f66 |

  Scenario Outline: Verify that when a place is deleted for second time, an error is returned.
    Given a place exists for provider "<provider_name>" with id "<provider_place_id>"
    When I delete the place for the provider "<provider_name>" with id "<provider_place_id>"
    Then the place is deleted
    When I delete the place for the provider "<provider_name>" with id "<provider_place_id>"
    Then the delete return error

    Examples:
      | provider_name | provider_place_id        |
      | facebook      | 238779122798993          |
      | foursquare    | 5188db08498e765ce1ba6f66 |

  Scenario Outline: Verify that a error is returned when the provider_place_id value is invalid.
    When I delete the place for the provider "<provider_name>" with id "doesNotExists"
    Then the delete return error

    Examples:
      | provider_name |
      | facebook      |
      | foursquare    |

  Scenario Outline: Verify that a error is returned when the provider_name value is invalid.
    When I delete the place for the provider "doesNotExists" with id "<provider_place_id>"
    Then the delete return error

    Examples:
      | provider_place_id        |
      | 238779122798993          |
      | 5188db08498e765ce1ba6f66 |

  Scenario: Verify that a error is returned when the provider_name and provider_place_id values are invalid.
    When I delete the place for the provider "doesNotExists" with id "doesNotExist"
    Then the delete return error