# Books Recommender Laravel

## Table of Contents
- [Installation](#installation)
    - [Normal Installation](#normal-installation)
    - [With Docker](#with-docker)
- [API Documentation](#api-documentation)

## Installation

### Normal Installation
To install the Books Recommender Laravel project, follow these steps:

1. Clone the repository:
   ```bash
   git clone https://github.com/mostafahassan1/books-recommender-laravel.git
2. Navigate to the project directory:
    ```bash
    cd books-recommender-laravel
    ```
3. Install composer dependencies:
    ```bash
    composer install
    ```
4. Create a copy of the .env.example file and rename it to .env:
    ```bash
    cp .env.example .env
    ```
5. Generate the application key:
    ```bash
    php artisan key:generate
    ```
6. Configure your database settings in the .env file.
7. Run database migrations:
    ```bash
    php artisan migrate
    ```
7. Add your SMS Service provider Urls
8. Start the Laravel development server:
    ```bash
    php artisan serve
    ```
### With Docker
To run the Books Recommender Laravel project using Docker, follow these steps:
We are using [Laravel Sail](https://laravel.com/docs/11.x/sail)
1. Clone the repository:
    ```bash
    git clone https://github.com/mostafahassan1/books-recommender-laravel.git
    ```
2. Navigate to the project directory:
    ```bash
    cd books-recommender-laravel
    ```
3. Build the Docker containers:
    ```bash
    ./vendor/bin/sail build
    ```
4. Start the Docker containers:
    ```bash
    ./vendor/bin/sail up -d
    ```
5. Run database migrations:
    ```bash
    ./vendor/bin/sail artisan migrate
    ```
6. The application should now be accessible at http://localhost:8000.

## API Documentation
All The APIs are documented in [Postman](https://documenter.getpostman.com/view/9641409/2sA3JGf4FS)



