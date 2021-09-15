<?php
/*
 * VIEWS
 */

$klein->respond('GET', '/admin/permissions', function ($request, $response) use ($blade, $me, $steam, $config) {
    if (!$me->HasPermission("groups.%")) {
        $response->code(403);
        $response->send();
        die();
    }

    return $blade->make('page.admin.permissions', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});


$klein->respond('GET', '/admin/forums', function ($request, $response) use ($blade, $me, $steam, $config) {
    if (!$me->HasPermission("forums.%")) {
        $response->code(403);
        $response->send();
        die();
    }

    return $blade->make('page.admin.forums', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});


$klein->respond('GET', '/admin', function ($request, $response) use ($blade, $me, $steam, $config) {
    if (!$me->HasPermission("groups.%") and !$me->HasPermission('forums.%')) {
        $response->code(403);
        $response->send();
        die();
    }

    return $blade->make('page.admin.index', ['me' => $me, 'steam' => $steam, 'config' => $config])->render();
});
/*
 * POST
 */
$klein->respond('POST', '/admin/permissions/group/create', function ($request, $response, $service) use ($blade, $me, $steam, $config) {
    if (!$me->exists) {
        $response->code(403);
        $response->send();
        die();
    }

    if (!$me->HasPermission("groups.create")) {
        $response->code(403);
        $response->send();
        die();
    }

    // Validate Display Name
    $displayName = isset($_POST['display_name']) ? $_POST['display_name'] : false;
    if (!$displayName or (strlen($displayName) < 1) or (strlen($displayName) > 64)) {
        $response->code(400);
        $response->send();
        die();
    }
    // Validate Identifier
    $identifier = isset($_POST['identifier']) ? $_POST['identifier'] : false;
    if (!$identifier or (strlen($identifier) < 1) or (strlen($identifier) > 64)) {
        $response->code(400);
        $response->send();
        die();
    }

    // Set everything
    $group = new Group();
    $group->Create($displayName, $identifier, $me);

    $response->redirect("/admin/permissions", 200);
});
$klein->respond('POST', '/admin/permissions/group/nodes', function ($request, $response, $service) use ($blade, $me, $steam, $config) {
    if (!$me->exists) {
        $response->code(403);
        $response->send();
        die();
    }

    if (!$me->HasPermission("groups.edit.permissions")) {
        $response->code(403);
        $response->send();
        die();
    }

    $allGroups = new Group();
    $allGroups = $allGroups->GetAllGroups();


    foreach($allGroups as $group) {
        foreach($config->get("Permissions") as $permission) {
            $perm = $permission['node'];
            $permissionName = str_replace(' ', '_', $group->GetIdentifier()) . "_" . str_replace('.', '_', $perm);
            $allowed = isset($_POST[$permissionName]);


            $existingPermission = $group->HasPermission($perm);

            if ($allowed == $existingPermission) continue;

            if ($allowed) {
                $group->GivePermission($perm);
            } else {
                $group->RemovePermission($perm);
            }
        }
    }

    $response->redirect("/admin/permissions", 200);
});
$klein->respond('POST', '/admin/permissions/group/edit', function ($request, $response, $service) use ($blade, $me, $steam, $config) {
    if (!$me->exists) {
        $response->code(403);
        $response->send();
        die();
    }

    if (!$me->HasPermission("groups.edit.permissions")) {
        $response->code(403);
        $response->send();
    }

    // Validate Display Name
    $groupID = isset($_POST['group']) ? $_POST['group'] : false;
    if (!$groupID) {
        $response->code(400);
        $response->send();
        die();
    }
    // Validate Display Name
    $displayName = isset($_POST['display_name']) ? $_POST['display_name'] : false;
    if (!$displayName or (strlen($displayName) < 1) or (strlen($displayName) > 64)) {
        $response->code(400);
        $response->send();
        die();
    }
    // Validate Identifier
    $identifier = isset($_POST['identifier']) ? $_POST['identifier'] : false;
    if (!$identifier or (strlen($identifier) < 1) or (strlen($identifier) > 64)) {
        $response->code(400);
        $response->send();
        die();
    }

    $group = new Group($groupID);
    if (!$group->exists) {
        $response->code(400);
        $response->send();
        die();
    }

    $group->SetName($displayName);
    $group->SetIdentifier($identifier);

    $response->redirect("/admin/permissions", 200);
});


$klein->respond('POST', '/admin/forums/board/create', function ($request, $response, $service) use ($blade, $me, $steam, $config) {
    if (!$me->exists) {
        $response->code(403);
        $response->send();
        die();
    }

    if (!$me->HasPermission("forums.board.create")) {
        $response->code(403);
        $response->send();
        die();
    }

    // Validate Display Name
    $displayName = isset($_POST['display_name']) ? $_POST['display_name'] : false;
    if (!$displayName or (strlen($displayName) < 1) or (strlen($displayName) > 128)) {
        $response->code(400);
        $response->send();
        die();
    }
    // Validate Description
    $description = isset($_POST['description']) ? $_POST['description'] : false;
    if (!$description or (strlen($description) < 1) or (strlen($description) > 256)) {
        $response->code(400);
        $response->send();
        die();
    }
    // Validate Parent
    $parent = (isset($_POST['parent']) and !($_POST['parent'] == "")) ? $_POST['parent'] : false;
    if ($parent){
        $board = new Board($parent);
        if (!$board->exists) {
            $response->code(400);
            $response->send();
            die();
        }
    }

    // Create the board
    $board = new Board();
    $board->Create($displayName, $description, $parent, $me);
//
    $response->redirect("/admin/forums", 200);
});

$klein->respond('POST', '/admin/forums/board/permissions', function ($request, $response, $service) use ($blade, $me, $steam, $config) {
    if (!$me->exists) {
        $response->code(403);
        $response->send();
        die();
    }

    if (!$me->HasPermission("forums.board.permissions")) {
        $response->code(403);
        $response->send();
        die();
    }

    $boardID = isset($_POST['boardID']) ? $_POST['boardID'] : false;
    if (!$boardID) {
        $response->code(400);
        $response->send();
        die();
    }
    $board = new Board($boardID);
    if (!$board->exists) {
        $response->code(400);
        $response->send();
        die();
    }


    $allGroups = new Group();
    $allGroups = $allGroups->GetAllGroups();


    foreach($allGroups as $group) {
        foreach($config->get("Forum Thread Permissions") as $permission) {
            $permNode = $permission['node'];
            $perm = $board->GetID() . ":" . $permission['node'];
            $permissionName = str_replace(' ', '_', $group->GetIdentifier()) . "_" . str_replace('.', '_', $permNode);
            $allowed = isset($_POST[$permissionName]);


            $existingPermission = $group->HasPermission($perm);

            if ($allowed == $existingPermission) continue;

            if ($allowed) {
                $group->GivePermission($perm);
            } else {
                $group->RemovePermission($perm);
            }
        }
    }

    $response->redirect("/admin/forums", 200);
});