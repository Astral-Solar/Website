<?php

require_once("resource/common.php");

class User
{
    private $id;
    private $steamID;
    private $name;
    private $avatarURL;
    private $background;
    private $slug;
    private $bio;
    private $joined;
    private $lastSeen;
    public $exists;

    function __construct($steamID = null)
    {
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

        global $imageHandler;
        $img = $imageHandler->make($avatar);
        $img->save('public/storage/avatar/' . $id . '.jpg');

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
    public function GetAvatar() {
        if (!$this->exists) return;

        return '/public/storage/avatar/' . $this->GetSteamID64() . '.jpg';
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

        if(!file_exists('public/storage/backgrounds/' . $this->GetSteamID64() . '.jpg')) return false;

        return "/public/storage/backgrounds/" . $this->GetSteamID64() . ".jpg";
        //return $this->background;
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

        $bio = str_replace(["<", ">"], "", $bio);

        $databaseMain->update('users')
            ->where('id')->is($this->GetID())
            ->set([
                'bio' => $bio
            ]);
    }
    public function GetRecentForumPosts($amount = 10) {
        if (!$this->exists) return;
        global $databaseMain;

        $results = $databaseMain->from("forums_threads_posts")
            ->where('creator')->is($this->GetSteamID64())
            ->orderBy('last_edited', 'desc')
            ->limit($amount)
            ->select()
            ->all();
        if (!$results) return [];

        $posts = [];
        foreach($results as $post) {
            $postOjb = new ThreadPost($post->id);
            array_push($posts, $postOjb);
        }

        return $posts;
    }
    public function GetSubscription() {
        if (!$this->exists) return;

        $subscription = new Premium($this->GetSteamID64());

        return $subscription->exists ? $subscription : false;
    }

    public function GetMaintainedSubscriptions() {
        if (!$this->exists) return;
        global $databaseMain;
        global $config;

        $results = $databaseMain->from("subscriptions")
            ->where('subscriber')->is($this->GetSteamID64())
            ->select()
            ->all();
        if (!$results) return [];


        $subscriptions = [];
        foreach($results as $subs) {
            $subs = new Premium($subs->userid);
            array_push($subscriptions, $subs);
        }

        return $subscriptions;
    }


    // Permissions
    public function GetUserGroup() {
        if (!$this->exists) return;
        global $databasexAdmin;
        global $config;

        $userGroup = $databasexAdmin->from($config->get('xAdmin Permission Prefix') . "_users")
            ->where('userid')->is($this->GetSteamID64())
            ->select('rank')
            ->first();
        if (!$userGroup) return $config->get('Default Usergroup');

        return $userGroup->rank;
    }
    public function GetGroup() {
        if (!$this->exists) return;
        $groupIdentifier = $this->GetUserGroup();

        return new Group($groupIdentifier);
    }
    public function HasPermission($node) {
        if (!$this->exists) return;
        $group = $this->GetGroup();

        if (!$group) return false;

        return $group->HasPermission($node);
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
    public function FindAllByWord($any) {
        global $databaseMain;

        $results = $databaseMain->from('users')
            ->where('name')->like('%' . $any . '%')
            ->orWhere('userid')->like('%' . $any . '%')
            ->select()
            ->all();
        if (!$results) return [];


        $users = [];
        foreach($results as $user) {
            $userOjb = new User($user->userid);
            array_push($users, $userOjb);
        }

        return $users;
    }
}