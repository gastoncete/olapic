Feature: Testing rest API PUT for sonar service
  In order to create provider places, 
  a request with provider and placeId is sent to sonar 

  Scenario: Verify that a place for facebook is created.
      When a place is created for provider "facebook" with id "238779122798993"
      Then the place was created
    
  Scenario: Verify that a place for foursquare is created.
      When a place is created for provider "foursquare" with id "5188db08498e765ce1ba6f66"
      Then the place was created
    
  Scenario: Verify that for an invalid provider, no place is created. 
      When a place is created for provider "invalidProvider" with id "123456"
      Then the place is not created
    
  Scenario: Verify that for an already place created, the second time is returned the same
      When a place exists for provider "facebook" with id "238779122798993"
      Then the place returned already exists