# Customer Connect API

laravel 5.2

## Installation / Usage


1. Download and install Composer by following the [official instructions](https://getcomposer.org/download/).

2. Run Composer: `php composer.phar install`

3. Setup Database in config/database.php

    ```
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', 'localhost'),
            'database'  => env('DB_DATABASE', 'Database Name'),
            'username'  => env('DB_USERNAME', 'User name'),
            'password'  => env('DB_PASSWORD', 'User Password'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
            'engine'    => null,
        ],	
    ```

4.Run Laravel migrate data: `php artisan migrate`

5.Run PHPUnit in command : `vendor/bin/phpunit` 

5.Run : `php artisan serve` 