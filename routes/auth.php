<?php
// Auth stuff
$klein->respond('GET', '/login', function ($request, $response, $service) {
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
$klein->respond('GET', '/logout', function ($request, $response, $service) {
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

// Discord stuff
$klein->respond('GET', '/discord/link', function ($request, $response, $service) {
    global $steam;
    global $me;
    global $config;

    if (!$me->exists) {
        $response->code(403);
        $response->send();
        die();
    }

    if($me->GetLinkedDiscord()) {
        $response->code(403);
        $response->send();
        die();
    }

    $provider = new \Wohali\OAuth2\Client\Provider\Discord([
        'clientId' => $config->get('Discord')['clientID'],
        'clientSecret' => $config->get('Discord')['clientSecret'],
        'redirectUri' => $config->get('Domain') . '/discord/link'
    ]);

    // Direct the user to login
    if (!isset($_GET['code'])) {
        $authUrl = $provider->getAuthorizationUrl([
            'scope' => ['identify', 'guilds.join']
        ]);
        $_SESSION['oauth2state'] = $provider->getState();

        $response->redirect($authUrl, 200);
        $response->send();

        die();
    }

    // Authenticate for any funny business
    if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
        unset($_SESSION['oauth2state']);
        exit('Suspicious activity identified');
    }


    //try {
        // Auth the logged in user
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        $user = $provider->getResourceOwner($token);
        $me->LinkDiscord($user->getId(), $user->getUsername() . "#" . $user->getDiscriminator(), $user->getAvatarHash());

        // [To-do] Give the user their roles or whatever here
        $user = $provider->getResourceOwner($token);

        $roles = [$config->get('Discord')['roles']['verified']];
        if ($me->GetSubscription()) {
            array_push($roles, $config->get('Discord')['roles']['premium']);
        }

        $restCord = new \RestCord\DiscordClient([
            'token' => $config->get('Discord')['botToken']
        ]);
        $restCord->guild->addGuildMember([
            'guild.id' => intval($config->get('Discord')['guildID']),
            'user.id' => intval($user->getId()),
            'access_token' => $token->getToken(),
            'roles' => $roles
        ]);

        foreach($roles as $role) {
            $restCord->guild->addGuildMemberRole([
                'guild.id' => intval($config->get('Discord')['guildID']),
                'user.id' => intval($user->getId()),
                'role.id' => $role
            ]);
        }

        $response->redirect("/settings", 200);
    //} catch (Exception $e) {
    //    die("Something went wrong!");
    //}

});