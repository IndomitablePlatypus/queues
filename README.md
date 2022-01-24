# CARDZ

## Preface

This repo is a light-weight version of the "Bonus Cards API" [app](https://github.com/IndomitablePlatypus/cardz).
Please refer to the [Cardz](https://github.com/IndomitablePlatypus/cardz) documentation to get acquainted with the domain.

In this instance the underlying idea is slightly different.
We try to use native Laravel features as much as possible while keeping the (relatively) same API routes and responses as in the main app.

A couple of features diverge from this simplification concept, but only inasmuch as native Laravel features allow us to go.
We use docker with Laravel Sail, a Redis container, and a RabbitMQ container instead of using a fake provider like in the main app, for example.
Given the availability of Redis and RabbitMQ we use queued jobs to handle asynchronous data handling when applicable.

The authorization was discarded as won't be necessary in this case. 

This version casts aside a lot of design patterns used in the main one. 
There are basically no contexts, aggregate roots, repositories, buses, and other stuff.
Basically, this code is as a somewhat small ball of mud. As muddy as we were willing to go.

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

## Some interesting reference links for DDD, ES, and CQRS
- http://practical-ddd.blogspot.com/2012/07/designing-aggregates.html
- https://www.jamesmichaelhickey.com/consistency-boundary/
- https://storyneedle.com/where-domain-models-meet-content-models/
- https://lostechies.com/jimmybogard/2014/05/13/a-better-domain-events-pattern/
- https://gojko.net/2009/03/12/qcon-london-2009-eric-evans-what-ive-learned-about-ddd-since-the-book/
- https://buildplease.com/pages/fpc-1/ - https://buildplease.com/pages/fpc-23/
- https://medium.com/@mgonzalezbaile/implementing-a-use-case-i-intro-38c80b4fed0 - https://medium.com/@mgonzalezbaile/implementing-a-use-case-v-given-when-then-testing-style-a17a645b1aa6
- https://herbertograca.com/2017/11/16/explicit-architecture-01-ddd-hexagonal-onion-clean-cqrs-how-i-put-it-all-together/
- https://chriskiehl.com/article/event-sourcing-is-hard/
- https://eventmodeling.org/posts/what-is-event-modeling/
- https://codeopinion.com/stop-doing-dogmatic-domain-driven-design/
- https://cqrs.files.wordpress.com/2010/11/cqrs_documents.pdf

## OpenApi
- Laravel OpenApi generator: generate OpenApi json. https://vyuldashev.github.io/laravel-openapi/#installation
- [RapiDoc](https://mrin9.github.io/RapiDoc/quickstart.html): wrap an OpenApi json.
