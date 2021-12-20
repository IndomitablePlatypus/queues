<?php

namespace Queues\Api\V1\Config\Routing;

class Routing
{
    public const PREFIX = 'api/v1';
    public const MIDDLEWARE = [
        'api',
    ];

    public const SIGN_UP = '/sign-up';

    public static function for(string $route): string
    {
        return static::PREFIX . $route;
    }
}
