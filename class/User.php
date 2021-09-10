<?php

require_once("resource/common.php");

class User
{
    public $id;
    public $name;
    public $avatarURL;
    public $joined;
    public $lastSeen;
    public $exists;

    function __construct($id = null)
    {
        global $config;
        global $databaseMain;

        $this->exists = false;
        if (!$id) return;

        $this->id = $id;

        $userData = $databaseMain->from('users')
            ->where('userid')->is($id)
            ->select()
            ->first();
        if (!$userData) return;
        $this->exists = true;

        $this->name = $userData->name;
        $this->avatarURL = $userData->avatar;
        $this->joined = $userData->joined;
        $this->lastseen = time();
    }

    public function Create($id, $name, $avatar){
        global $databaseMain;
        $databaseMain->insert(array(
            'userid' => $id,
            'name' => $name,
            'avatar' => $avatar,
            'lastseen' => time(),
            'joined' => time()
        ))->into('users');

        return new User($id);
    }

    public function CreateFromSession($key) {
        global $databaseMain;

        $userID = $databaseMain->from('sessions')
            ->where('token')->is($key)
            ->select()
            ->first();

        if (!$userID) return $this;

        return new User($userID->userid);
    }
    public function CreateSessionKey() {
        global $databaseMain;
        $key = GenerateRandomString(32);

        $databaseMain->insert(array(
            'userid' => $this->GetSteamID64(),
            'token' => $key,
            'created' => time()
        ))->into('sessions');

        return $key;
    }
    public function DestroySessionKey($key) {
        global $databaseMain;

        $databaseMain->from('sessions')
            ->where('token')->is($key)
            ->delete();
    }
    public function ClearSessions() {
        if (!$this->exists) return;

        ClearUserSessions($this->GetSteamID64());
    }
    // Get methods
    public function GetSteamID64() {
        if (!$this->exists) return;

        return $this->id;
    }
    public function GetName() {
        if (!$this->exists) return;

        return $this->name;
    }
    public function GetAvatarURL() {
        if (!$this->exists) return;

        return $this->avatarURL;
    }
    public function CreateLog($log) {
        if (!$this->exists) return;

        //CreateAuditLog($this->GetSteamID64(), $log);
    }
}