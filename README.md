## php-test-task

A PSR12 and PHPStan level 7 compliant test project with PHP 8 and Laravel 8
providing functionality:

* Full JWT token auth lifecycle via REST API
* Full CRUD (except create) for `Client` model
* `Client` list search, filters and sorting
* Test coverage using `Pest` for clients list
* Postman collection is applied in project root

#### Project setup

**Docker and Laravel Sail are required to start**

1. Install dependencies via `composer install`
2. Prepare a valid `.env` file
3. Run containers via `sail up -d` or `./vendor/bin/sail up -d`
4. `sail artisan migrate:fresh` or `./vendor/bin/sail artisan migrate:fresh` to run needed migrations

#### Tests

For writing tests I used Pest - a new extension library for PHPunit
Just as an example I covered clients list feature with tests.

To run tests use:
`sail artisan test` or `./vendor/bin/sail artisan test`

To run tests in coverage mode use:
`sail artisan test --coverage` or `./vendor/bin/sail artisan test --coverage`
