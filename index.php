<?php
// Load composer
require_once 'vendor/autoload.php';

// Load the config
$config = include("config.php");
define('CONFIG', $config, true);

// Load all the libs
use Jenssegers\Blade\Blade;
use J0sh0nat0r\SimpleCache\Cache;
use J0sh0nat0r\SimpleCache\Drivers\Redis;

// Load the router object
$klein = new \Klein\Klein();

// Create the cache object, connecting to the Redis server
$cache = new Cache(Redis::class, [
    'host' => '127.0.0.1',
    'database' => 3
]);

// Load the existing blades from the view folder
$blade = new Blade('views', 'cache');

// All the routes
$klein->respond('GET', '/hello-world', function () {
    global $blade;
    return $blade->make('basic')->render();
});

// Render the current route
$klein->dispatch();