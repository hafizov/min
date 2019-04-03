## About Minificaton Links

This project makes your url links short.

## Installation

After pull this project go to the root directory in this project and run below command:
    
    composer install

Then install our `node_modules`

    npm install

Then copy `.env.example` to `.env` file and set up our project and run below command:

    php artisan key:generate

Set up our DB in `.env` file and run below command:
    
    php artisan migrate

Then install the supervisor follow in this link how to install it [Laravel Queues](https://laravel.com/docs/5.8/queues#supervisor-configuration):

## Features

- Google API binding for analyze.
- Users profiles
- Analyze in profiles user