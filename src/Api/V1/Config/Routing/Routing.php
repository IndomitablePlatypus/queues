<?php

namespace Queues\Api\V1\Config\Routing;

class Routing
{
    public const PREFIX_API = 'api/v1';
    public const PREFIX_BUSINESS = '/business';
    public const MIDDLEWARE_API = ['api'];
    public const MIDDLEWARE_AUTH = ['auth:sanctum'];

    public const SIGN_IN = '/sign-in';
    public const SIGN_UP = '/sign-up';
    public const SIGN_OUT = '/sign-out';

    public static function for(string $route): string
    {
        return static::PREFIX_API . $route;
    }
}
