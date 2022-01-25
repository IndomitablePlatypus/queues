# CARDZ

## Preface

This repo is a light-weight version of the "Bonus Cards API" [app](https://github.com/IndomitablePlatypus/cardz).
Please refer to the [Cardz](https://github.com/IndomitablePlatypus/cardz) documentation to get acquainted with the domain.

In this instance the underlying idea is slightly different.
We try to use native Laravel features as much as possible while keeping the (relatively) same API routes and responses as in the main app.

A couple of features diverge from this simplification concept, but only inasmuch as native Laravel features allow us to go.
We use docker with Laravel Sail, a Redis container, and a RabbitMQ container instead of using a fake provider like in the main app, for example.
Given the availability of Redis and RabbitMQ we use queued jobs to handle asynchronous data transfer when applicable.

We were going to use Laravel Sanctum authorization capabilities instead of something more involved but settled on foregoing it altogether, at least for now. 

This version casts aside a lot of design patterns used in the main one. 
There are basically no bounded contexts, aggregate roots, repositories, buses, and other stuff.
This code is a somewhat small ball of mud... as muddy as we were willing to go.

## Installation instructions

- clone the [repo](https://github.com/IndomitablePlatypus/cardz/) with `git clone`;
- ensure you have **PHP 8.0+**;
- run `composer install`;
- copy `.env.example` to `.env`;
- provide your app key with `php artisan key:generate`;
- make sure you have **PostgreSQL** installed and running;
- create a relevant database and provide credentials for the DB connection in your `.env` file;
- run migrations for your DB with the `php artisan migrate` command;
- launch `php artisan serve` and proceed to the provided localhost page to take a look at the project API documentation.

Optionally, you can run `php artisan tests` to take a look at a small assortment of included tests.

The RabbitMQ messaging is faked, so there's no need to install RabbitMQ for now.

### Code structure

Most of the app code lies within the `src` directory. Parts of the infrastructure unrelated to the domain are in the `codderz` directory. Consider it a kind of external lib.   
A small bit of an app code is in the `app` directory mostly due to the Laravel structure.


## OpenApi
- Laravel OpenApi generator: generate OpenApi json. https://vyuldashev.github.io/laravel-openapi/#installation
- [RapiDoc](https://mrin9.github.io/RapiDoc/quickstart.html): wrap an OpenApi json.
