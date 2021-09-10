<?php
function SetUserLastSeen($id) {
    global $MainDatabase;

    $id = $MainDatabase->real_escape_string($id);
    $time = time();

    $MainDatabase->query("UPDATE users SET lastseen='$time' WHERE userid='$id'");
}
function UpdateUserBan($id, $state) {
    global $MainDatabase;

    $id = $MainDatabase->real_escape_string($id);
    $state = $state ? 1 : 0;

    $MainDatabase->query("UPDATE users SET banned='$state' WHERE userid='$id'");
}
function GetUserGroup($id) {
    global $xAdminDatabse;
    global $cache;

    if ($cache->has("user-$id-usergroup")) {
        return $cache->get("user-$id-usergroup");
    }

    $id = $xAdminDatabse->real_escape_string($id);

    $result = $xAdminDatabse->query("SELECT rank FROM pol1_users WHERE userid='$id' LIMIT 1");

    // Some kind of error
    if (!$result) return;
    // No users with this info
    if ($result->num_rows < 1) return;
    $result = $result->fetch_array(MYSQLI_ASSOC);

    $cache->store("user-$id-usergroup", $result['rank'], 600);

    return $result['rank'];
}