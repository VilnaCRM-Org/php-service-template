Feature: Health Check Operations
  In order to ensure system components are functioning
  As an administrator
  I want to verify the health of various subsystems

  Scenario: Checking the health of the entire system
    When GET request is send to "/api/health"
    Then the response status code should be 204
