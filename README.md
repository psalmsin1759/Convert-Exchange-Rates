# Laravel Currency Converter

provides an API for converting currency from a base currency to another currency using real-time exchange rates.

## Features

-   Convert currency from a base currency to a target currency
-   Fetch real-time exchange rates
-   Simple API endpoints
-   Customizable base currency

## Requirements

-   PHP >= 8.3
-   Composer
-   Laravel >= 10.x
-   An API key from a currency exchange rate providers [Exchange Rates API](https://exchangeratesapi.io/) and [Open Exchange Rates](https://openexchangerates.org/)

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/psalmsin1759/Convert-Exchange-Rates
    cd converter-service

    ```

2. Install dependencies:

    ```bash
    composer install

    ```

3. Set up environment variables:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

## Usage

1. Test the application:

    ```bash
    php artisan test

    ```

2. Run the application:

    ```bash
    php artisan serve

    ```

3. Documentation (Swagger)

    ```bash
    https://hostname/api/documentation
    ```

```

```
