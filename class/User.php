<?php

require_once("resource/common.php");

class User
{
    public $id;
    public $steamID;
    public $name;
    public $avatarURL;
    public $background;
    public $slug;
    public $bio;
    public $joined;
    public $lastSeen;
    public $exists;

    function __construct($steamID = null)
    {
        global $config;
        global $databaseMain;

        $this->exists = false;
        if (!$steamID) return;


        $userData = $databaseMain->from('users')
            ->where('userid')->is($steamID)
            ->select()
            ->first();
        if (!$userData) return;
        $this->exists = true;

        $this->steamID = $steamID;

        $this->id = $userData->id;
        $this->name = $userData->name;
        $this->avatarURL = $userData->avatar;
        $this->background = $userData->background or false;
        $this->slug = $userData->slug or false;
        $this->bio = $userData->bio or false;
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
    // Get/Set methods
    private function GetID() {
        if (!$this->exists) return;

        return $this->id;
    }
    public function GetSteamID64() {
        if (!$this->exists) return;

        return $this->steamID;
    }
    public function GetName() {
        if (!$this->exists) return;

        return $this->name;
    }
    public function SetName($name) {
        if (!$this->exists) return;
        global $databaseMain;

        $databaseMain->update('users')
            ->where('id')->is($this->GetID())
            ->set([
                'name' => $name
            ]);
    }
    public function GetAvatarURL() {
        if (!$this->exists) return;

        return $this->avatarURL;
    }
    public function GetSlug() {
        if (!$this->exists) return;

        return !($this->slug == "") ? $this->slug : "";
    }
    public function SetSlug($slug) {
        if (!$this->exists) return;
        global $databaseMain;

        $databaseMain->update('users')
            ->where('id')->is($this->GetID())
            ->set([
                'slug' => $slug
            ]);
    }
    public function GetBackground() {
        if (!$this->exists) return;

        return $this->background;
    }
    public function SetBackground($background) {
        if (!$this->exists) return;
        global $databaseMain;

        $databaseMain->update('users')
            ->where('id')->is($this->GetID())
            ->set([
                'background' => $background
            ]);
    }
    public function GetBio() {
        if (!$this->exists) return;

        return $this->bio;
    }
    public function SetBio($bio) {
        if (!$this->exists) return;
        global $databaseMain;

        $databaseMain->update('users')
            ->where('id')->is($this->GetID())
            ->set([
                'bio' => $bio
            ]);
    }

    // Actions
    public function CreateLog($log) {
        if (!$this->exists) return;

        //CreateAuditLog($this->GetSteamID64(), $log);
    }

    // Generic find methods
    public function FindByAny($any) {
        global $databaseMain;

        $user = new User($any);
        if ($user->exists) return $user;

        $results = $databaseMain->from('users')
            ->where('slug')->is($any)
            ->select()
            ->first();
        if (!$results) return;

        return new User($results->userid);
    }
}