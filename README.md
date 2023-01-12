Hello, guest.

1. git clone https://github.com/nedicom/parser.git
2. composer require 
3. run Mysql, config .env if you need it
4. php artisan migrate
5. php artisan parse:cars
7. check your phpMyAdmin db - laravel/auto
6. optionally - php artisan parse:cars - test.xml/test2.xml

code is here - "parser\app\Console\Commands\parseIt.php"