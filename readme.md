# AuthMicroservice Boilerplate Project
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

AuthMicroservice is boilerplate code for REST service that handles authentication and authorization for users. The service provides the following functionality, provided as API endpoints:

Authentication:
* Authenticate a user (with a password), create a session and return a session token (should be a JWT token)
* Validate a session token 
* Close a session

Authorization:
* Retrieve permissions for a user + session combination
* Grant and revoke permissions for users
* Authorize endpoint that responds to "can user X execute action Y"


## Implementation

* PHP framework Lumen
* MySQL with Eloquent as a ORM
* Each distinct functionality as a separate API endpoint
* Sessions (and their tokens) as well as granted permissions are be saved in a database


## Additional features

* Scripts for creating database
* Scripts for quick database seeding


## License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
JWT for Lumen implementation from [tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth)

## Examples

For now, all endpoint test are stored within [AuthMicroservice Postman collection](https://www.getpostman.com/collections/9d5747ce1fa075c2b0d7). These examples are mapped to local environment setup at localhost:8000 with api prefix "api/v1".

## Installation

1. Clone this repository to your development/server machine
2. Update /vendor directory with "composer update -vvv"
3. Create .env file (from .env.example)
4. Update .env file with APP_KEY
5. Update .env file with DB_DATABASE, DB_USERNAME, DB_PASSWORD 
6. Generate JWT_SECRET with "php artisan jwt:secret"
7. Generate required databases with "php artisan migrate"
8. Generate example data with "php artisan db:seed"
9. Run application with "php -S localhost:8000 -t public" or other IP:PORT combination.

