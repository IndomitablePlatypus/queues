<?php

namespace Queues\Api\V1\Infrastructure;

use PhpAmqpLib\Connection\AbstractConnection;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\RabbitMQQueue;

class RabbitWorker extends RabbitMQQueue
{
    public function __construct(AbstractConnection $connection, string $default, array $options = [])
    {
        parent::__construct($connection, $default, $options);

        [$destination, $exchange, $exchangeType, $attempts] = $this->publishProperties(null, $options);

        $this->declareDestination($destination, $exchange, $exchangeType);
    }

}
