@put
Feature: Testing rest API PUT for sonar service
  In order to create a provider place,
  a request with provider_name and provider_place_id is sent to sonar
  and data values and source values are returned.

  Scenario Outline: Verify that a provider place is created sending the provider_name and provider_place_id values when the place does not exist.
    When a place is created for provider "<provider_name>" with id "<provider_place_id>"
    Then the place is created
    And the place name value returned is "<placeName>" for "put" response
    And the place url value returned is "<placeUrl>" for "put" response
    And the provider_hash value returned is "<providerHash>" for "put" response
    And the provider_id value returned is "<provider_place_id>" for "put" response
    And the provider_name value returned is "<provider_name>" for "put" response
    And the provider_id value returned is a valid UUID

    Examples:
      | provider_name | provider_place_id        | placeName                                | providerHash                     | placeUrl                                                              |
      | facebook      | 238779122798993          | Hyatt Place Dallas-North/by the Galleria | 005998dddf9d21ecb7d0a027262700d7 | https://www.facebook.com/HyattPlaceDallasNorthbytheGalleria/          |
      | foursquare    | 5188db08498e765ce1ba6f66 | Norwegian Breakaway                      | 1a724c0eec818d90118892ee9845b936 | https://foursquare.com/v/norwegian-breakaway/5188db08498e765ce1ba6f66 |

  Scenario Outline: Verify that for an invalid provider_name in the request, no place is created.
    When a place is created for provider "invalidProviderName" with id "<provider_place_id>"
    Then the place is not created

    Examples:
      | provider_place_id        |
      | 238779122798993          |
      | 5188db08498e765ce1ba6f66 |

  Scenario Outline: Verify that for an invalid provider_place_id in the request, no place is created.
    When a place is created for provider "<provider_name>" with id "invalidProviderPlaceId"
    Then the place is not created

  Examples:
  | provider_name|
  |facebook|
  |foursquare|

  Scenario: Verify that for invalid provider values in the request, no place is created.
    When a place is created for provider "invalidProvider" with id "123456"
    Then the place is not created

  Scenario Outline: Verify that for an already place created, the second time that an request is sent, the same place is returned.
    When a place exists for provider "<provider>" with id "<providerId>"
    Then the place returned already exists
    And the place name value returned is "<placeName>" for "put" response
    And the place url value returned is "<placeUrl>" for "put" response
    And the provider_hash value returned is "<providerHash>" for "put" response
    And the provider_id value returned is "<providerId>" for "put" response
    And the provider_name value returned is "<provider>" for "put" response
    And the provider_id value returned is a valid UUID

    Examples:
      | provider   | providerId               | placeName                                | providerHash                     | placeUrl                                                              |
      | facebook   | 238779122798993          | Hyatt Place Dallas-North/by the Galleria | 005998dddf9d21ecb7d0a027262700d7 | https://www.facebook.com/HyattPlaceDallasNorthbytheGalleria/          |
      | foursquare | 5188db08498e765ce1ba6f66 | Norwegian Breakaway                      | 1a724c0eec818d90118892ee9845b936 | https://foursquare.com/v/norwegian-breakaway/5188db08498e765ce1ba6f66 |
