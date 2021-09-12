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
$klein->respond('POST', '/admin/permissions/nodes', function ($request, $response, $service) use ($blade, $me, $steam, $config) {
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