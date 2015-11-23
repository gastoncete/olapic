@uuid
Feature: Testing rest API GET for sonar service using the UUID
  In order to obtain provider places,
  a request with UUID is sent to sonar
  and data values and source values are returned.

  Scenario Outline: Verify that the place is returned when the UUID exists for valid providers.
    Given a place exists for provider "<provider_name>" with id "<provider_place_id>"
    When the get is perform with the UUID
    Then the place is returned
    And the place name value returned is "<placeName>" for "uuid" response
    And the place url value returned is "<placeUrl>" for "uuid" response
    And the provider_hash value returned is "<providerHash>" for "uuid" response
    And the provider_id value returned is "<provider_place_id>" for "uuid" response
    And the provider_name value returned is "<provider_name>" for "uuid" response
    And the provider_id value returned is a valid UUID

    Examples:
      | provider_name | provider_place_id        | placeName                                | providerHash                     | placeUrl                                                              |
      | facebook      | 238779122798993          | Hyatt Place Dallas-North/by the Galleria | 005998dddf9d21ecb7d0a027262700d7 | https://www.facebook.com/HyattPlaceDallasNorthbytheGalleria/          |
      | foursquare    | 5188db08498e765ce1ba6f66 | Norwegian Breakaway                      | 1a724c0eec818d90118892ee9845b936 | https://foursquare.com/v/norwegian-breakaway/5188db08498e765ce1ba6f66 |

  Scenario: Verify that an error returned when the UUID is not a valid value for some place.
    When the get is perform with an invalid UUID "aaaabbbb-1234-5678-9999-abcdefghijkl"
    Then the place is not returned