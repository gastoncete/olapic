@get
Feature: Testing rest API GET for sonar service.
  In order to obtain provider places,
  a request with provider and placeId is sent to sonar
  and data values are returned.

  Scenario Outline: Verify that a place is returned with all data values when a valid provider and providerId are sent.
    Given a place exists for provider "<provider>" with id "<providerId>"
    When the I ask for the place for provider "<provider>" with id "<providerId>"
    Then the place is returned
    And the provider_hash value returned is "<providerHash>"
    And the provider_id value returned is "<providerId>"
    And the provider_name value returned is "<provider>"
    And the place name value returned is "<placeName>"
    And the place url value returned is "<placeUrl>"

    Examples:
      | provider   | providerId               | placeName                                | providerHash                     | placeUrl                                                              |
      | facebook   | 238779122798993          | Hyatt Place Dallas-North/by the Galleria | 005998dddf9d21ecb7d0a027262700d7 | https://www.facebook.com/HyattPlaceDallasNorthbytheGalleria/          |
      | foursquare | 5188db08498e765ce1ba6f66 | Norwegian Breakaway                      | 1a724c0eec818d90118892ee9845b936 | https://foursquare.com/v/norwegian-breakaway/5188db08498e765ce1ba6f66 |

  Scenario: Verify that an error is returned when a placeId does not exist.
    When the I ask for the place for provider "foursquare" with id "doesNotExist"
    Then the place is not returned