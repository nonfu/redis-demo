<?php

use App\Nebula\Resources\PostResource;
use App\Nebula\Resources\UserResource;
use Larsklopstra\Nebula\Http\Middleware\NebulaIPAuthStrategy;

return [

    'name' => 'Admin',

    'prefix' => '/admin',

    'domain' => null,

    'auth_strategy' => NebulaIPAuthStrategy::class,

    'allowed_ips' => [
        '127.0.0.1',
        '172.21.0.1'
    ],

    'allowed_emails' => [
        // 'admin@example.com',
    ],

    'resources' => [
        new UserResource(),
        new PostResource(),
    ],

    'dashboards' => [
        // new UserDashboard,
    ],

    'pages' => [
        // new CustomPage,
    ],
];
