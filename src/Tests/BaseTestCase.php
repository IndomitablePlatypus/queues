<?php

namespace Queues\Tests;

use Faker\Factory;
use Faker\Generator;
use Tests\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected Generator $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create('ru-RU');
        parent::setUp();
    }

}
