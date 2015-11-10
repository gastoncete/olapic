Feature: Testing rest API GET for sonar service using the UUID
  In order to obtain provider places, 
  a request with UUID is sent to sonar 
  and data values and source values are returned.
  
  Scenario: Verify that facebook place is returned when the UUID exists.
      Given a place exists for provider "facebook" with id "238779122798993"
      When the get is perform with the UUID 
      Then the place is returned
      
  Scenario: Verify that foursquare place is returned when the UUID exists.
      Given a place exists for provider "foursquare" with id "5188db08498e765ce1ba6f66"
      When the get is perform with the UUID 
      Then the place is returned
      
  Scenario: Verify that an error returned when the UUID is not a valid value for some place.
      When the get is perform with an invalid UUID "aaaabbbb-1234-5678-9999-abcdefghijkl"
      Then the place is not returned 