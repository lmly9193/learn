<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Access Control
    |--------------------------------------------------------------------------
    |
    | This value for this key determines the environments, IPs, and users that
    | are allowed to access the devops routes. You may modify this default
    | value as needed to restrict access to your devops routes.
    |
    */

    'access' => [

        'allowed_environments' => [
            'local',
        ],

        'allowed_ips' => [
            // ...IpUtils::PRIVATE_SUBNETS,
        ],

        'allowed_users' => [
            // 'user@example.com'
        ],

    ],

];
