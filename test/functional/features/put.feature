@put
Feature: Testing rest API PUT for sonar service
  In order to create provider places, 
  a request with provider and placeId is sent to sonar 
  and data values and source values are returned.

  Scenario: Verify that a place for facebook is created when the provider and placeId are the expected in the request.
      When a place is created for provider "facebook" with id "238779122798993"
      Then the place is created
    
  Scenario: Verify that a place for foursquare is created when the provider and placeId are the expected in the request.
      When a place is created for provider "foursquare" with id "5188db08498e765ce1ba6f66"
      Then the place is created
    
  Scenario: Verify that for an invalid provider in the request, no place is created. 
      When a place is created for provider "invalidProvider" with id "123456"
      Then the place is not created 
    
  Scenario: Verify that for an already place created, the second time that an request is sent, the same is returned. 
      When a place exists for provider "facebook" with id "238779122798993"
      Then the place returned already exists