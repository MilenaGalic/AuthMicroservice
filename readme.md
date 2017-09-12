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