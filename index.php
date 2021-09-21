<?php
// Load composer
require_once 'vendor/autoload.php';


// Load the config
use Noodlehaus\Config;
use Noodlehaus\Parser\Json;
$config = new Config('config.php');

// Debugging
if ($config->get("Debug")) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// Load all the libs
use Jenssegers\Blade\Blade;
use J0sh0nat0r\SimpleCache\Cache;
use J0sh0nat0r\SimpleCache\Drivers\Redis;
use \PalePurple\RateLimit\RateLimit;
use \PalePurple\RateLimit\Adapter\Redis as RedisAdapter;
use Opis\Database\Database;
use Opis\Database\Connection;
use Intervention\Image\ImageManager;
use xPaw\SourceQuery\SourceQuery;

// Import other files
$files = scandir('class/');
foreach($files as $file) {
    if (!strpos($file, ".php")) continue;
    require_once('class/' . $file);
}
require_once('handler/session.php');

// Set up Image stuff
$imageHandler = new ImageManager(array('driver' => $config->get("Image Write Type")));

// Load the router object
$klein = new \Klein\Klein();

// Set up the database connection
// Main Database
$dbCreds = $config->get("Main Database Credentials");
$connection = new Connection(
    'mysql:host=' . $dbCreds['host'] .';dbname=' . $dbCreds['name'],
    $dbCreds['user'],
    $dbCreds['pass']
);
$connection->persistent();
$databaseMain = new Database($connection);
// xAdmin Database
$dbCreds = $config->get("xAdmin Database Credentials");
$connection = new Connection(
    'mysql:host=' . $dbCreds['host'] .';dbname=' . $dbCreds['name'],
    $dbCreds['user'],
    $dbCreds['pass']
);
$connection->persistent();
$databasexAdmin = new Database($connection);

// Create the cache object, connecting to the Redis server
$cache = new Cache(Redis::class, [
    'host' => '127.0.0.1',
    'database' => 2
]);

// Rate limit the entire site to 40 requests a minute (Even still maybe too many lol)
// Honestly, this could probably be done with the cache object above. Completely removing 1 extra lib
$redis = new \Redis();
$redis->pconnect('127.0.0.1', 6379);
$adapter = new RedisAdapter($redis);
$rateLimit = new RateLimit("ratelimit-master", 120, 60, $adapter); // 40 requests a minute
$ip = $_SERVER['REMOTE_ADDR']; // Use client IP as identity
if (!$rateLimit->check($ip)) {
    die("exceeded rate limit, please try again later");
}

// Error handling
$whoops = new \Whoops\Run;
if ($config->get("Debug")) {
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
}
$whoops->pushHandler(function($exception, $inspector, $run){
    global $me;

//    foreach($inspector->getFrames() as $frame) {
//        $logger = new Errors;
//        $logger->Log($exception->getMessage(), $frame->getFile(), $frame->getLine(), $me ? $me->GetSteamID64() : null);
//    }
});
$whoops->register();

// Login user
$token = $_COOKIE['session_key'] ?? false;
$me = new User();
if ($token) {
    $me = $me->CreateFromSession($token);
}

// Steam object
$steam = new Vikas5914\SteamAuth([
    'apikey' => $config->get('SteamAPI Key'), // Steam API KEY
    'domainname' => $config->get('Domain'), // Displayed domain in the login-screen
    'loginpage' => $config->get('Domain') . "/login", // Returns to last page if not set
    "logoutpage" => "/logout",
    "skipAPI" => false // true = dont get the data from steam, just return the steamid64
]);

// Load the existing blades from the view folder
$blade = new Blade('views', 'cache');

// Load all the routes
$files = scandir('routes/');
foreach($files as $file) {
    if (!strpos($file, ".php")) continue;
    require('routes/' . $file);
}

// Run some scheduled tasks
if (!$cache->has("scheduled-tasks")) { // run the scheduled tasks often
    $cache->store("scheduled-tasks", true, 60*10);
    // Update server info


    foreach($config->get('Servers') as $serverIP) {
        $info = explode(":", $serverIP);
        $query = new SourceQuery();
        $query->Connect($info[0], $info[1], 3, SourceQuery::SOURCE);

        $cache->store("server-info-" . $serverIP, $query->GetInfo());
    }
}

// Render the current route
$klein->dispatch();