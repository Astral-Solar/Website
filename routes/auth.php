<?php
// Auth stuff
$klein->respond('/login', function ($request, $response, $service) {
    global $steam;

    $user = new User($steam->steamid);
    if (!$user->exists) {
        $user = $user->Create($steam->steamid, $steam->personaname, $steam->avatarfull);
    }

    $sessionKey = $user->CreateSessionKey();
    setcookie('session_key', $sessionKey, time() + (60*60*24*30));

    $service->startSession();
    $response->redirect("/", 200);
});
$klein->respond('/logout', function ($request, $response, $service) {
    global $steam;
    global $me;


    if (!$me->exists) {
        $response->redirect("/", 403);
        $response->send();
        die();
    }

    $me->DestroySessionKey($_COOKIE['session_key']);
    setcookie('session_key', '', 1);

    $service->startSession();
    $response->redirect("/", 200);
});