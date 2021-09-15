<?php
/*
 * VIEWS
 */

$klein->respond('GET', '/store/premium', function ($request, $response) use ($blade, $me, $steam, $config) {
    return $blade->make('page.store.premium', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});
