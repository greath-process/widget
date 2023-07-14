# Widget-backend

## Technologies
* PHP 8.1
* [Laravel 9](https://laravel.com)
* [REST API](https://ru.wikipedia.org/wiki/REST)
* [CORS](https://developer.mozilla.org/ru/docs/Web/HTTP/CORS)

## Getting started

Set the .env:
```bash
cp .env.example .env
```

Emails processing .env settings (you can use [mailtrap](https://mailtrap.io/) or your smtp credentials like user@gmail.com). If there are several emails, they must be separated by a comma:
```dotenv
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_USERNAME=<mailtrap_key>
MAIL_PASSWORD=<mailtrap_password>
MAIL_PORT=587
MAIL_FROM_ADDRESS=admin@thread.com
MAIL_FROM_NAME="BSA Thread Admin"
MAIL_TO_ADDRESS=office@runbyit.com,pawel@runbyit.com
MAIL_TO_NAME=Example
```
Install composer dependencies and generate app key:
```bash
composer install
php artisan key:generate
php artisan jwt:secret
```
