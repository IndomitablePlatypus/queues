# CARDZ

## Preface

This repo is a lightweight version of the "Bonus Cards API" [app](https://github.com/codderzcom/cardz). Please refer to
the [Cardz](https://github.com/codderzcom/cardz) documentation to get acquainted with the domain.

In this instance, the underlying idea is slightly different. We try to use native Laravel features as much as possible
while keeping the (relatively) same API routes and responses as in the main app.

A couple of features diverge from this simplification concept, but only inasmuch as native Laravel features allow us to
go. We use docker with Laravel Sail, a Redis container, and a RabbitMQ container instead of using a fake provider like
in the main app, for example. Given the availability of Redis and RabbitMQ, we use queued jobs to handle asynchronous
data transfer when applicable. Actually, as you've probably guessed from the name of this repo, checking Laravel queues'
capabilities of working with RabbitMQ was one of the reasons to even try this at all.

We were going to use Laravel Sanctum authorization capabilities instead of something more involved but settled on
foregoing it altogether, at least for now.

This version casts aside a lot of design patterns used in the main one. There are basically no bounded contexts,
aggregate roots, repositories, buses, and other stuff. This code is a somewhat small ball of mud... as muddy as we were
willing to go.

## Installation instructions

- clone the [repo](https://github.com/codderzcom/queues) with `git clone`;
- ensure you have PHP 8.1+ (it's not strictly required to run containers);
- run `composer install`;
- copy `.env.example` to `.env`;
- provide your app key with `php artisan key:generate`;
- optionally run `alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'` to use the `sail` script without the
  path.
- run `sail up -d` or `./vendor/bin/sail up -d`;
- run migrations for your DB with `sail artisan migrate`;
- the demo application is now running on the `http://localhost/`.

Optionally, you can run `sail artisan tests` to take a look at the small assortment of included tests.

### Code structure

Most of the app code lies within the `src` directory. Parts of the infrastructure unrelated to the domain are in
the `codderz` directory. Consider it a kind of external lib.   
Some app code is in the `app` directory (mostly due to the Laravel structure), specifically in `Models` and `Jobs`.

Considering that the amount of code in this app is tiny compared to the main app, it's almost wholly contained in the
controllers and models.
