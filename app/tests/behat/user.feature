Feature: Users

  Scenario: Listing all users is not possible
    When I request "GET users"
    Then I get a "400" response
    And the "error" property is an object
    And scope into the "error" property
    And the properties exist:
      """
      code
      http_code
      message
      details
      """
    And the "http_code" property is a integer equalling "400"

  Scenario: Finding a specific user
    When I request "GET users/1"
    Then I get a "200" response
    And the "embeds" property is an array
    And the "data" property is an object
    And scope into the "data" property
    And the properties exist:
      """
      id
      email
      name
      created_at
      """
    And the "id" property is an integer
    And the "password" property must not be present
    And the property "embeds" contains:
      """
      games
      """

  Scenario: Finding a specific non-existent user
    When I request "GET users/1000000"
    Then I get a "404" response
    And the "error" property is an object
    And scope into the "error" property
    And the properties exist:
      """
      code
      http_code
      message
      details
      """
    And the "http_code" property is a integer equalling "404"

  Scenario: Finding games for a specific users
    When I request "GET users/1/games"
    Then I get a "200" response
    And the "embeds" property is an array
    And the "data" property is an array
    And scope into the first "data" property
    And the properties exist:
      """
      id
      user_id
      active
      name
      answer_time
      created_at
      """
    And the property "embeds" contains:
    """
      user
      difficulties
      categories
      """

  Scenario: Finding games for a specific users with pagination is right
    When I request "GET users/1/games?pagination=2&page=2"
    Then I get a "200" response
    And the "pagination" property is an object
    And scope into the "pagination" property
    And the properties exist:
      """
      total
      count
      per_page
      current_page
      total_pages
      """
    And the "links" property is an object
    And scope into the "pagination.links" property
    And the properties exist:
      """
      previous
      next
      """

  @databaseModification
  Scenario: Successfully creating a user
    Given I have the payload:
      """
      {"email": "testuser@test.com", "password": "password", "name": "Test User"}
      """
    When I request "POST users"
    Then I get a "201" response
    And the "data" property is an object
    And scope into the "data" property
    And the properties exist:
      """
      id
      email
      name
      created_at
      """
    And the "id" property is an integer
    And the "email" property equals "testuser@test.com"
    And the "name" property equals "Test User"

  @databaseModification
  Scenario: Failing creating a user, email already used
    Given I have the payload:
      """
      {"email": "testuser@test.com", "password": "password", "name": "Test User"}
      """
    When I request "POST users"
    Then I get a "201" response
    And the "data" property is an object
    And I reset response
    Given I have the payload:
      """
      {"email": "testuser@test.com", "password": "password", "name": "Test User"}
      """
    When I request "POST users"
    Then I get a "400" response
    And the "error" property is an object
    And scope into the "error" property
    And the properties exist:
      """
      code
      http_code
      message
      details
      validationerrors
      oldinput
      """
    And the "http_code" property is a integer equalling "400"
    And the "validationerrors" property is an object
    And the "oldinput" property is an object
    And scope into the "error.validationerrors" property
    And the properties exist:
      """
      email
      """
    And scope into the "error.oldinput" property
    And the properties exist:
      """
      email
      name
      """
