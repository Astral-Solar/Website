<?php
$config = [];
// Name of app
$config['App Name'] = "Astral";
// Slogan
$config['Slogan'] = "A community worth joining";
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
// Servers
$config['Servers'] = [
    'localhost:27015',
];
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
    'productID' => '1234', // The premium product subscription ID
    'publicKey' => "-----BEGIN PUBLIC KEY-----
ABC69==
-----END PUBLIC KEY-----"
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

// Store Premium service reasons
$config['Store Premium Content'] = [
    [
        'title' => "Reason 1",
        'img' => "https://www.cnet.com/a/img/aTLKqWz80LEDLhuX74RcgdKiXMM=/1200x675/2020/02/14/676146ec-f899-4c73-a132-99f7bff87827/vbucks.png",
        'desc' => "I love money. Money is honestly the best thing in the world. Take a look at this cool thing we can do with the money you're going to give us."
    ],
    [
        'title' => "Reason 2",
        'img' => "https://image.shutterstock.com/image-illustration/big-pile-money-american-dollar-260nw-526522342.jpg",
        'desc' => "This is what my bank account will look like after you give me all your money lol."
    ],
    [
        'title' => "Reason 3",
        'desc' => "This reason has no image. It's because we're too poor to afford one. You can change that by giving us your money. :)"
    ]
];

return $config;