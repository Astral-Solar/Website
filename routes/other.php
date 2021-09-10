<?php
/*
 * VIEWS
 */

$klein->respond('GET', '/', function () use ($blade, $me, $steam, $config) {
    return $blade->make('page.index', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});

/*
 * POSTS
 */