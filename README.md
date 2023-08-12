## Story Book Backend

Install

- Copy .env from .env.example.
- Update the database information from the .env file.
    <div>
    
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=
        DB_USERNAME=
        DB_PASSWORD=
    </div>
- Open your terminal and run commands.
    - `composer install`
    - `composer dump-autoload`
    - `php artisan key:generate`
    - `php artisan migrate`
    - `php artisan db:seed` (optional)
    - `php artisan serve`
