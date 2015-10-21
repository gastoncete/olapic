Feature: Testing rest API GET for sonar service
  In order to obtain provider places, 
  a request with provider and placeId is sent to sonar 
  
  Scenario: Verify that facebook place is returned.
      Given a place exists for provider "facebook" with id "238779122798993"
      When the I ask for the place for provider "facebook" with id "238779122798993"
      Then the place is returned
      
    Scenario: Verify that foursquare place is returned.
      Given a place exists for provider "foursquare" with id "5188db08498e765ce1ba6f66"
      When the I ask for the place for provider "foursquare" with id "5188db08498e765ce1ba6f66"
      Then the place is returned
      
    Scenario: Verify that an error returned when a place does not exist.
      When the I ask for the place for provider "foursquare" with id "doesNotExist"
      Then the place is not returned 