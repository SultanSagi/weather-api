# Weather API

Built in Symfony. 

## Description

Messages are implemented via CQRS. Handler where weather data is imported: `src/Handler/Command/CreateWeatherHandler.php`
In this code I sent messages to the database, as it was easier to implement than RabbitMQ.


### API Endpoints
Fetch weather data: `GET /api/weather`
Sign up: `POST /register` `{"email": "user@mail.com", "password": "secret"}`
Sign in: `POST /authentication_token` `{"email": "user@mail.com", "password": "secret"}`

## Getting Started

First, clone the repository and cd into it:

```bash
git clone https://github.com/sultansagi/weather-api
cd weather-api
```

Next, update and install with composer:

```bash
composer update --no-scripts
composer install
```

Next, set configs, set Database:

```bash
cp .env.example .env
```

Run the server:

```bash
symfony serve
```

You should now be able to start the server using `php artisan serve`

Also we can check PHPUnit tests, by running:

```bash
vendor/bin/phpunit
```

## Contributing

Feel free to contribute to anything.