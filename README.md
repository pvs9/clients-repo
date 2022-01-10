## Test project

A PSR12 and PHPStan level 7 compliant test project

#### Запуск проекта

**Если у тебя не поднят Docker - Почему ты еще в разработке**
**Если у тебя стоит Laravel Sail - начинай со второго пункта**

1. Установи зависимости `composer install`
2. Подготовь `.env` файл
3. Запусти контейнеры `sail up -d` или `./vendor/bin/sail up -d`
4. `sail artisan migrate:fresh` или `./vendor/bin/sail artisan migrate:fresh`

#### Тесты

Для тестов используется свежая оболочка над PHPUnit - Pest.
В качестве примера покрыл тестами список клиентов

Для запуска тестов:
`sail artisan test` или `./vendor/bin/sail artisan test`

Для запуска Coverage:
`sail artisan test --coverage` или `./vendor/bin/sail artisan test --coverage`
