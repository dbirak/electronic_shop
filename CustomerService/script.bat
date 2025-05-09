%systemDrive%\xampp\mysql\bin\mysql -uroot -e "CREATE DATABASE IF NOT EXISTS customer_service;"

if %errorlevel% neq 0 msg %username% "Nie udalo sie utworzyc bazy danych." && exit /b %errorlevel%

php -r "copy('.env.example', '.env');"

call composer install --no-interaction

call php artisan migrate:fresh --seed

call php artisan key:generate

call php artisan storage:link