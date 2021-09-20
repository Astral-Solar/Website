<?php
/*
 * VIEWS
 */

$klein->respond('GET', '/', function () use ($blade, $me, $steam, $config, $cache) {
    return $blade->make('page.index', ['me' => $me, 'steam' => $steam, 'config' => $config, 'cache' => $cache])->render();
});

/*
 * POSTS
 */