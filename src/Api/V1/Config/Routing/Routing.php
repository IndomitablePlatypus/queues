<?php

namespace Queues\Api\V1\Config\Routing;

/**
 * @method static string SIGN_IN()
 * @method static string SIGN_UP()
 * @method static string SIGN_OUT()
 */
class Routing
{
    public const PREFIX_API = 'api/v1';
    public const PREFIX_BUSINESS = '/business';
    public const MIDDLEWARE_API = ['api'];
    public const MIDDLEWARE_AUTH = ['auth:sanctum'];

    public const SIGN_IN = '/sign-in';
    public const SIGN_UP = '/sign-up';
    public const SIGN_OUT = '/sign-out';

    public static function __callStatic(string $name, array $arguments): string
    {
        return static::PREFIX_API . constant("static::$name");
    }
}
