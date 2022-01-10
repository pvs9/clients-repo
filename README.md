## Test project

A PSR12 and PHPStan level 7 compliant test project

#### Запуск проекта

**Если у тебя не поднят Docker - Почему ты еще в разработке**
**Если у тебя стоит Laravel Sail - начинай со второго пункта**

1. Установи зависимости `composer install`
2. Подготовь `.env` файл
3. Запусти контейнеры `sail up -d / ./vendor/bin/sail up -d`
4. `sail artisan migrate:fresh / ./vendor/bin/sail artisan migrate:fresh`
