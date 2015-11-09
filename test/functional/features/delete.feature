@delete
Feature: Testing rest API DELETE for sonar service
  In order to delete provider places, 
  a request with provider and placeId is sent to sonar 
  
  Scenario: Verify that a existing place is deleted for facebook.
      Given a place exists for provider "facebook" with id "238779122798993"
      When I delete the place for the provider "facebook" with id "238779122798993"
      Then the place is deleted
      
  Scenario: Verify that a existing place is deleted for foursquare.
      Given a place exists for provider "foursquare" with id "5188db08498e765ce1ba6f66"
      When I delete the place for the provider "foursquare" with id "5188db08498e765ce1ba6f66"
      Then the place is deleted
    
  Scenario: Verify that a error is returned when the place does not exist.
      When I delete the place for the provider "facebook" with id "doesNotExists"
      Then the delete return error