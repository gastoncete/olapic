@get
Feature: Testing rest API GET for sonar service
  In order to obtain provider places, 
  a request with provider and placeId is sent to sonar 
  and data values are returned.
  
  Scenario: Verify that facebook place is returned with all data values.
      Given a place exists for provider "facebook" with id "238779122798993"
      When the I ask for the place for provider "facebook" with id "238779122798993"
      Then the place is returned
      
  Scenario: Verify that foursquare place is returned with all data values.
      Given a place exists for provider "foursquare" with id "5188db08498e765ce1ba6f66"
      When the I ask for the place for provider "foursquare" with id "5188db08498e765ce1ba6f66"
      Then the place is returned
      
  Scenario: Verify that an error is returned when a placeId does not exist.
      When the I ask for the place for provider "foursquare" with id "doesNotExist"
      Then the place is not returned 