<?php
/*
 * VIEWS
 */

$klein->respond('GET', '/forums', function ($request, $response) use ($blade, $me, $steam, $config) {

    return $blade->make('page.forums.index', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});


/*
 * POST
 */