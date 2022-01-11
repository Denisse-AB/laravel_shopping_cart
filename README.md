# Laravel 8 Shopping Cart

Stripe ready Shopping Cart with Laravel 8 and Vue.js.

## Features

- Stripe v3
- Login system
- Wishlist area
- Comments area per product
- Localization english and spanish
- Stripe integration check passed :heavy_check_mark:

---

<p align="center">
  <img src="public\images\shop(4).png" width="500" alt="screenshot">
  <img src="public\images\shop(3).png" width="500" alt="screenshot">
  <img src="public\images\shop(2).png" width="500" alt="screenshot">
</p>

## Requirements

php >=7.3.0 | composer v2.2.3 | node v14.6.0 | Postgresql database

## Installation

- Clone repository

```javascript
git clone https://github.com/Denisse-AB/laravel_shopping_cart.git

// cd to the project root folder or
cd laravel_shopping_cart

composer install

npm install

// Set .env file manually or copy
copy .env.example .env

// Generate encryption key
php artisan key:generate
```

- Connect .env to your database
- Migrate database

```javascript
php artisan migrate

php artisan db:seed

php artisan serve
```

## Donation
If you like this project, buy me a cup of :coffee: :wink:

[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/donate?business=263QJ8D5YHR8E&no_recurring=0&item_name=I+believe+in+open+source%2C+but+a+little+donation+will+be+appreciated.+Thanks%21&currency_code=USD)
