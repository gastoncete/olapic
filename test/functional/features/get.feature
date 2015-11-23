@get
Feature: Testing rest API GET for sonar service.
  In order to obtain the provider place,
  a request with provider_name and provider_place_id is sent to sonar
  and data values are returned.

  Scenario Outline: Verify that a place is returned with all data values when a valid provider and providerId are sent.
    Given a place exists for provider "<provider>" with id "<providerId>"
    When the place for provider "<provider>" with id "<providerId>" is asked
    Then the place is returned
    And the provider_hash value returned is "<providerHash>" for "get" response
    And the provider_id value returned is "<providerId>" for "get" response
    And the provider_name value returned is "<provider>" for "get" response
    And the place name value returned is "<placeName>" for "get" response
    And the place url value returned is "<placeUrl>" for "get" response

    Examples:
      | provider   | providerId               | placeName                                | providerHash                     | placeUrl                                                              |
      | facebook   | 238779122798993          | Hyatt Place Dallas-North/by the Galleria | 005998dddf9d21ecb7d0a027262700d7 | https://www.facebook.com/HyattPlaceDallasNorthbytheGalleria/          |
      | foursquare | 5188db08498e765ce1ba6f66 | Norwegian Breakaway                      | 1a724c0eec818d90118892ee9845b936 | https://foursquare.com/v/norwegian-breakaway/5188db08498e765ce1ba6f66 |

  Scenario Outline: Verify that an error is returned when the provider_place_id value does not exist.
    When the place for provider "<provider_name>" with id "doesNotExist" is asked
    Then the place is not returned

    Examples:
      | provider_name |
      | facebook      |
      | foursquare    |

  Scenario Outline: Verify that an error is returned when the provider_name value does not exist.
    When the place for provider "doesNotExist" with id "<provider_place_id>" is asked
    Then the place is not returned

    Examples:
      | provider_place_id        |
      | 238779122798993          |
      | 5188db08498e765ce1ba6f66 |

  Scenario: Verify that an error is returned when invalid provider values are in the request.
    When the place for provider "invalidProvider" with id "invalidProviderPlaceId" is asked
    Then the place is not returned