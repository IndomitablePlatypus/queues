<?php

namespace Queues\Api\V1\Config\Routing;

class Routing
{
    public const PREFIX_API = '/api/v1';
    public const MIDDLEWARE_API = ['api'];
    public const MIDDLEWARE_AUTH = ['auth:sanctum'];

    protected const URIS = [
        RouteName::GET_TOKEN => '/customer/get-token',
        RouteName::REGISTER => '/customer/register',
        RouteName::CLEAR_TOKENS => '/customer/wipe-tokens',

        RouteName::CUSTOMER_WORKSPACES => '/customer/workspaces',
        RouteName::CUSTOMER_CARDS => '/customer/card',
        RouteName::CUSTOMER_CARD => '/customer/card/{cardId}',
        RouteName::CUSTOMER_ID => '/customer/id',

        RouteName::GET_WORKSPACES => '/workspace',
        RouteName::ADD_WORKSPACE => '/workspace',
        RouteName::GET_WORKSPACE => '/workspace/{workspaceId}',
        RouteName::CHANGE_WORKSPACE_PROFILE => '/workspace/{workspaceId}/profile',

        RouteName::PROPOSE_INVITE => '/workspace/{workspaceId}/invite',
        RouteName::ACCEPT_INVITE => '/workspace/{workspaceId}/invite/{inviteId}/accept',
        RouteName::DISCARD_INVITE => '/workspace/{workspaceId}/invite/{inviteId}/discard',

        RouteName::LEAVE_RELATION => '/workspace/{workspaceId}/collaboration/leave',
        RouteName::FIRE_COLLABORATOR => '/workspace/{workspaceId}/collaboration/fire/{collaboratorId}',

        RouteName::GET_PLANS => '/workspace/{workspaceId}/plan',
        RouteName::ADD_PLAN => '/workspace/{workspaceId}/plan',
        RouteName::GET_PLAN => '/workspace/{workspaceId}/plan/{planId}',
        RouteName::CHANGE_PLAN_DESCRIPTION => '/workspace/{workspaceId}/plan/{planId}/description',
        RouteName::LAUNCH_PLAN => '/workspace/{workspaceId}/plan/{planId}/launch',
        RouteName::STOP_PLAN => '/workspace/{workspaceId}/plan/{planId}/stop',
        RouteName::ARCHIVE_PLAN => '/workspace/{workspaceId}/plan/{planId}/archive',

        RouteName::ADD_PLAN_REQUIREMENT => '/workspace/{workspaceId}/plan/{planId}/requirement',
        RouteName::CHANGE_PLAN_REQUIREMENT => '/workspace/{workspaceId}/plan/{planId}/requirement/{requirementId}',
        RouteName::REMOVE_PLAN_REQUIREMENT => '/workspace/{workspaceId}/plan/{planId}/requirement/{requirementId}',

        RouteName::GET_CARDS => '/workspace/{workspaceId}/card',
        RouteName::ISSUE_CARD => '/workspace/{workspaceId}/card',
        RouteName::GET_CARD => '/workspace/{workspaceId}/card/{cardId}',
        RouteName::COMPLETE_CARD => '/workspace/{workspaceId}/card/{cardId}/complete',
        RouteName::REVOKE_CARD => '/workspace/{workspaceId}/card/{cardId}/revoke',
        RouteName::BLOCK_CARD => '/workspace/{workspaceId}/card/{cardId}/block',
        RouteName::UNBLOCK_CARD => '/workspace/{workspaceId}/card/{cardId}/unblock',
        RouteName::NOTE_ACHIEVEMENT => '/workspace/{workspaceId}/card/{cardId}/achievement',
        RouteName::DISMISS_ACHIEVEMENT => '/workspace/{workspaceId}/card/{cardId}/achievement/{achievementId}',

    ];

    public static function route(string $name, array $arguments = []): string
    {
        return route($name, $arguments);
    }

    public static function uri(string $name): string
    {
        return static::URIS[$name] ?? '';
    }
}
