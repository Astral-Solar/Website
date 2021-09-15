<?php
/*
 * VIEWS
 */

$klein->respond('GET', '/profile/[:userID]', function ($request, $response) use ($blade, $me, $steam, $config) {
    $profileUser = new User();
    $profileUser = $profileUser->FindByAny($request->userID);

    if (!$profileUser) {
        $response->code(404);
        $response->send();
        die();
    }

    return $blade->make('page.profile', ['me' => $me, 'steam' => $steam, 'config' => $config, 'profileOwner' => $profileUser])->render();
});

$klein->respond('GET', '/settings', function ($request, $response) use ($blade, $me, $steam, $config) {
    if (!$me->exists) {
        $response->code(403);
        $response->send();
        die();
    }

    return $blade->make('page.settings', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});


/*
 * POST
 */

$klein->respond('POST', '/settings', function ($request, $response, $service) use ($blade, $me, $steam, $config) {
    if (!$me->exists) {
        $response->code(403);
        $response->send();
        die();
    }

    // Validate Display Name
    $displayName = !($_POST['display_name'] == "") ? $_POST['display_name'] : $me->GetName();
    if ((strlen($displayName) < 4) or (strlen($displayName) > 255)) {
        $response->code(400);
        $response->send();
        die();
    }

    // Validate Bio
    $bio = !($_POST['bio'] == '{"ops":[{"insert":"\n"}]}') ? $_POST['bio'] : NULL;
    if ($bio and (strlen($bio) > 10000)) {
        $response->code(402);
        $response->send();
        die();
    }

    // Validate Background
    $background = isset($_FILES['background']['tmp_name']) ? $_FILES['background']['tmp_name'] : false;
    if ($background) {
        global $imageHandler;

        $img = $imageHandler->make($background);

        if ($img->filesize() > $config->get('File Size'))  {
            $response->code(402);
            $response->send();
            die();
        }
    }

    // Validate Slug
    $slug = !($_POST['slug'] == "") ? $_POST['slug'] : NULL;
    if (isset($slug) and ((strlen($slug) < 4) or (strlen($slug) > 20))) {
        $response->code(403);
        $response->send();
        die();
    }


    // Set everything
    $me->SetName($displayName);
    $me->SetBio($bio);
    if ($background) {
        echo "Cool background bro";
        $img->save('public/storage/backgrounds/' . $me->GetSteamID64() . '.jpg');
//        $me->SetBackground($background);
    }
    $me->SetSlug($slug);

    $response->redirect("/profile/" . $me->GetSteamID64(), 200);
});
