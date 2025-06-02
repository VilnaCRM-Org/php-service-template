Feature:
    In order to prove that the Behat Symfony extension is correctly installed
    As a user
    I want to have a demo scenario

    Scenario: It receives a response from Symfony's kernel
        When I send a "GET" request to "/api/docs"
        Then the response status code should be equal to 200