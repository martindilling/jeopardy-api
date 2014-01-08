# Database

* users
    * id
    * email
    * password
    * name

* games
    * id
    * user_id
    * active
    * name
    * answer_time

* categories
    * id
    * game_id
    * active
    * order
    * name

* difficulties
    * id
    * game_id
    * order
    * name
    * points

* questions
    * id
    * category_id
    * difficulty_id
    * question
    * answer


# API

## Endpoints

* Users
    * Create
    * Read
    * Update
    * Delete

* Games
    * Create
    * Read
    * Update
    * Delete
    * List (active)
    * Categories
        * Questions

* Categories
    * Create
    * Read
    * Update
    * Delete
    * List (active)

* Difficulties
    * Create
    * Read
    * Update
    * Delete
    * List (active)

* Questions
    * Create
    * Read
    * Update
    * Delete
    * List
