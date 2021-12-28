<?php

namespace Queues\Api\V1\Config\Routing;

/**
 * @method static string SIGN_IN()
 * @method static string SIGN_UP()
 * @method static string SIGN_OUT()
 *
 * @method static string WORKSPACES_ALL()
 * @method static string WORKSPACES_GET()
 * @method static string WORKSPACES_ADD()
 * @method static string WORKSPACES_GET_ONE()
 * @method static string WORKSPACES_CHANGE_PROFILE()
 *
 * @method static string INVITE_PROPOSE()
 * @method static string INVITE_ACCEPT()
 * @method static string INVITE_DISCARD()
 *
 * @method static string COLLABORATION_LEAVE()
 * @method static string COLLABORATION_FIRE()
 *
 * @method static string PLANS_GET()
 * @method static string PLANS_GET_ONE()
 * @method static string PLANS_ADD()
 * @method static string PLANS_CHANGE_DESCRIPTION()
 * @method static string PLANS_LAUNCH()
 * @method static string PLANS_STOP()
 * @method static string PLANS_ARCHIVE()
 *
 * @method static string REQUIREMENTS_ADD()
 * @method static string REQUIREMENTS_CHANGE()
 * @method static string REQUIREMENTS_DELETE()
 */
class Routing
{
    public const PREFIX_API = '/api/v1';
    public const MIDDLEWARE_API = ['api'];
    public const MIDDLEWARE_AUTH = ['auth:sanctum'];

    public const SIGN_IN = '/sign-in';
    public const SIGN_UP = '/sign-up';
    public const SIGN_OUT = '/sign-out';

    public const WORKSPACES_ALL = '/customer/workspaces';

    public const WORKSPACES_GET = '/workspace';
    public const WORKSPACES_ADD = '/workspace';
    public const WORKSPACES_GET_ONE = '/workspace/{workspaceId}';
    public const WORKSPACES_CHANGE_PROFILE = '/workspace/{workspaceId}/profile';

    public const INVITE_PROPOSE = '/workspace/{workspaceId}/invite';
    public const INVITE_ACCEPT = '/workspace/{workspaceId}/invite/{inviteId}/accept';
    public const INVITE_DISCARD = '/workspace/{workspaceId}/invite/{inviteId}/discard';

    public const COLLABORATION_LEAVE = '/workspace/{workspaceId}/collaboration/leave';
    public const COLLABORATION_FIRE = '/workspace/{workspaceId}/collaboration/fire/{collaboratorId}';

    public const PLANS_GET = '/workspace/{workspaceId}/plan';
    public const PLANS_ADD = '/workspace/{workspaceId}/plan';
    public const PLANS_GET_ONE = '/workspace/{workspaceId}/plan/{planId}';
    public const PLANS_CHANGE_DESCRIPTION = '/workspace/{workspaceId}/plan/{planId}/description';
    public const PLANS_LAUNCH = '/workspace/{workspaceId}/plan/{planId}/launch';
    public const PLANS_STOP = '/workspace/{workspaceId}/plan/{planId}/stop';
    public const PLANS_ARCHIVE = '/workspace/{workspaceId}/plan/{planId}/archive';

    public const REQUIREMENTS_ADD = '/workspace/{workspaceId}/plan/{planId}/requirement';
    public const REQUIREMENTS_CHANGE = '/workspace/{workspaceId}/plan/{planId}/requirement/{requirementId}';
    public const REQUIREMENTS_DELETE = '/workspace/{workspaceId}/plan/{planId}/requirement/{requirementId}';


    public static function __callStatic(string $name, array $arguments): string
    {
        return static::PREFIX_API . constant("static::$name");
    }
}
