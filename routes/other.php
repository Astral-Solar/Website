<?php
/*
 * VIEWS
 */

$klein->respond('GET', '/', function () use ($blade, $me, $steam, $config) {
    return $blade->make('page.index', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});

$klein->respond('GET', '/forums', function () use ($blade, $me, $steam, $config) {
    return $blade->make('page.forums.index', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});

$klein->respond('GET', '/community/users', function () use ($blade, $me, $steam, $config) {
    return $blade->make('page.community.users.index', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});

$klein->respond('GET', '/community/leaderboard', function () use ($blade, $me, $steam, $config) {
    return $blade->make('page.community.leaderboard.index', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});

$klein->respond('GET', '/community/staff', function () use ($blade, $me, $steam, $config) {
    return $blade->make('page.community.staff.index', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});

$klein->respond('GET', '/community/punishments', function () use ($blade, $me, $steam, $config) {
    return $blade->make('page.community.punishments.index', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});

$klein->respond('GET', '/community/rules', function () use ($blade, $me, $steam, $config) {
    return $blade->make('page.community.rules.index', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});

$klein->respond('GET', '/commits', function () use ($blade, $me, $steam, $config) {
    return $blade->make('page.commits.index', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});

$klein->respond('GET', '/legal/termsofservice', function () use ($blade, $me, $steam, $config) {
    return $blade->make('page.legal.termsofservice.index', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});

$klein->respond('GET', '/legal/privacypolicy', function () use ($blade, $me, $steam, $config) {
    return $blade->make('page.legal.privacypolicy.index', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});

/*
 * POSTS
 */