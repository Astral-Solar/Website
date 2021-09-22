<?php

require_once("resource/common.php");

class Thread
{
    private $id;
    private $boardID;
    private $name;
    private $locked;
    private $deleted;
    private $sticky;
    private $creator;
    private $created;
    private $lastEdited;
    public $exists;

    function __construct($threadID = null)
    {
        global $databaseMain;

        $this->exists = false;
        if (!$threadID) return;


        $threadData = $databaseMain->from('forums_threads')
            ->where('id')->is($threadID)
            ->select()
            ->first();
        if (!$threadData) return;
        $this->exists = true;

        $this->id = $threadData->id;
        $this->boardID = $threadData->board_id;
        $this->name = $threadData->name;
        $this->locked = $threadData->locked;
        $this->deleted = $threadData->deleted;
        $this->sticky = $threadData->sticky;
        $this->creator = $threadData->creator;
        $this->created = $threadData->created;
        $this->lastEdited = $threadData->last_edited;
    }

    public function Create($board, $title, $creator){
        global $databaseMain;

        $databaseMain->insert(array(
                'board_id' => $board->GetID(),
                'name' => $title,
                'locked' => false,
                'deleted' => false,
                'sticky' => false,
                'creator' => $creator->GetSteamID64(),
                'created' => time(),
                'last_edited' => time()
            ))
            ->into('forums_threads');

        $threadID = $databaseMain->getConnection()->getPDO()->lastInsertId();

        return new Thread($threadID);
    }

    // Get/Set methods
    public function GetID() {
        if (!$this->exists) return;

        return $this->id;
    }
    public function GetTitle() {
        if (!$this->exists) return;

        return $this->name;
    }
    public function GetBoard() {
        if (!$this->exists) return;

        return new Board($this->boardID);
    }
    public function GetCreator() {
        if (!$this->exists) return;

        return new User($this->creator);
    }
    public function GetCreated() {
        if (!$this->exists) return;

        return $this->created;
    }
    public function GetLastEdited() {
        if (!$this->exists) return;

        return $this->lastEdited;
    }
    public function UpdateLastEdited() {
        if (!$this->exists) return;

        global $databaseMain;

        $databaseMain->update('forums_threads')
            ->where('id')->is($this->GetID())
            ->set([
                'last_edited' => time()
            ]);
    }
    public function IsLocked() {
        if (!$this->exists) return;

        return $this->locked;
    }
    public function SetLocked($state) {
        if (!$this->exists) return;

        global $databaseMain;

        $databaseMain->update('forums_threads')
            ->where('id')->is($this->GetID())
            ->set([
                'locked' => $state
            ]);
    }
    public function IsPinned() {
        if (!$this->exists) return;

        return $this->sticky;
    }
    public function SetPinned($state) {
        if (!$this->exists) return;

        global $databaseMain;

        $databaseMain->update('forums_threads')
            ->where('id')->is($this->GetID())
            ->set([
                'sticky' => $state
            ]);
    }
    public function IsDeleted() {
        if (!$this->exists) return;

        return $this->deleted;
    }
    public function SetDeleted($state) {
        if (!$this->exists) return;

        global $databaseMain;

        $databaseMain->update('forums_threads')
            ->where('id')->is($this->GetID())
            ->set([
                'deleted' => $state
            ]);
    }
    public function GetPosts() {
        if (!$this->exists) return;
        global $databaseMain;

        $results = $databaseMain->from('forums_threads_posts')
            ->orderBy('created', 'DESC')
            ->where('thread_id')->is($this->GetID())
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
    public function GetLastPost() {
        if (!$this->exists) return;
        global $databaseMain;

        $results = $databaseMain->from('forums_threads_posts')
            ->orderBy('created', 'DESC')
            ->where('thread_id')->is($this->GetID())
            ->select()
            ->first();
        if (!$results) return;


        return new ThreadPost($results->id);
    }
}