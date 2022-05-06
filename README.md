# CARDZ

## Preface

This repo is a lightweight version of the "Bonus Cards API" [app](https://github.com/codderzcom/cardz). Please refer to
the [Cardz](https://github.com/codderzcom/cardz) documentation to get acquainted with the domain.

Oftentimes, the value of the new project is not yet apparent, and the management wishes to test some working prototype
without fully committing to the project, thus creating the need for some kind of quick pilot project, MVP or the likes
of it. In this instance, the idea is to create a simple MVP app with an extensive use of native Laravel features. We'll
keep the same API routes and responses as in the main app to make them compatible and interchangeable from the frontend
perspective.

In some aspects it diverges from the simplification concept, but only inasmuch as native Laravel features allow us to
go. For example, we use docker with Laravel Sail and a RabbitMQ container instead of using a fake provider. Given the
availability of containers, queues, RabbitMQ and such, we use queued jobs to handle asynchronous data transfer when
applicable.

We were going to use Laravel Sanctum authorization capabilities instead of something more involved but settled on
foregoing it altogether, at least for now, as they do not add a lot of visible value for the MVP. However, Sanctum is
still used as an authentication module.

This version casts aside a lot of design patterns used in the main one. This, of course, does not mean that it's
unstructured or not scalable. It's quite possible to develop this MVP into a fully functional production application.
The main difference between the two approaches (this and the [main app](https://github.com/codderzcom/cardz)) is the
starting point of development and presumed managerial requirements.

## Installation instructions

- clone the [repo](https://github.com/codderzcom/queues) with `git clone`;
- run `composer install`;
- copy `.env.example` to `.env`;
- provide your app key with `php artisan key:generate`;
- optionally run `alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'` to use the `sail` script without the
  path.
- run `sail up -d` or `./vendor/bin/sail up -d`;
- run migrations for your DB with `sail artisan migrate`;
- the demo application is now running on the `http://localhost/`.

Optionally, you can run `sail artisan test` to take a look at the small assortment of included tests. 
For this to work you will need to either add `queues_testing` database in the postgres container or to modify 
`.env.testing` to work with other database. 

### Code structure

Most of the app code lies within the `src` directory. Parts of the infrastructure unrelated to the domain are in
the `codderz` directory. Consider it a kind of external lib.   
Some app code is in the `app` directory (mostly due to the Laravel structure), specifically in `Models` and `Jobs`.

Considering that the amount of code in this app is tiny compared to the main app, it's almost wholly contained in the
controllers and models.
