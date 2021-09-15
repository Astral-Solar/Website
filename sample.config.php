<?php
$config = [];
// Name of app
$config['App Name'] = "Astral";
// Debug
$config['Debug'] = false;
// Domain
$config['Domain'] = "https://astral.solar";
// Steam API Key
$config['SteamAPI Key'] = "KEY";
// Default usergroup
$config['Default Usergroup'] = "user";
// xAdmin prefix for permissions
$config['xAdmin Permission Prefix'] = "svr1";
// The largest size a file uploaded by a user can be, in bytes
$config['File Size'] = 1e+7;
// Database connection
$config['Main Database Credentials'] = [
    'host' => '1.1.1.1',
    'name' => 'database',
    'user' => 'user',
    'pass' => 'password'
];
$config['xAdmin Database Credentials'] = [
    'host' => '1.1.1.1',
    'name' => 'database',
    'user' => 'user',
    'pass' => 'password'
];
// Paddle config

$config['Paddle'] = [
    'sandbox' => false,
    'vendorID' => '123456',
    'APIKey' => 'APIKey',
    'productID' => '1234' // The premium product subscription ID
];
// Permissions
// The base permission nodes
$config['Permissions'] = [
    // Groups
    [
        'node' => 'groups.create',
        'name' => "Create Groups",
    ],
    [
        'node' => 'groups.edit',
        'name' => "Edit Groups",
    ],
    [
        'node' => 'groups.edit.permissions',
        'name' => "Edit Group Permissions",
    ],
    // Forums
    [
        'node' => 'forums.board.create',
        'name' => "Create Forum Boards",
    ],
    [
        'node' => 'forums.board.delete',
        'name' => "Delete Forum Boards",
    ],
    [
        'node' => 'forums.board.edit',
        'name' => "Edit Forum Boards",
    ],
    [
        'node' => 'forums.board.permissions',
        'name' => "Edit Forum Permissions",
    ],
];
// Forum permission nodes
$config['Forum Thread Permissions'] = [
    // Groups
    [
        'node' => 'forums.thread.read',
        'name' => "View Threads",
    ],
    [
        'node' => 'forums.thread.write',
        'name' => "Create Threads",
    ],
    [
        'node' => 'forums.thread.close',
        'name' => "Lock Threads",
    ],
    [
        'node' => 'forums.thread.sticky',
        'name' => "Pin Threads",
    ],
    [
        'node' => 'forums.thread.delete',
        'name' => "Delete Threads",
    ]
];

return $config;