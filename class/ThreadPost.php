<?php

require_once("resource/common.php");

class ThreadPost
{
    private $id;
    private $threadID;
    private $content;
    private $deleted;
    private $creator;
    private $created;
    private $lastEdited;
    public $exists;

    function __construct($postID = null)
    {
        global $databaseMain;

        $this->exists = false;
        if (!$postID) return;


        $postData = $databaseMain->from('forums_threads_posts')
            ->where('id')->is($postID)
            ->select()
            ->first();
        if (!$postData) return;
        $this->exists = true;

        $this->id = $postData->id;
        $this->threadID = $postData->thread_id;
        $this->content = $postData->content;
        $this->deleted = $postData->deleted;
        $this->creator = $postData->creator;
        $this->created = $postData->created;
        $this->lastEdited = $postData->last_edited;
    }

    public function Create($thread, $content, $creator){
        global $databaseMain;

        $content = str_replace(["<", ">"], "", $content);

        $databaseMain->insert(array(
            'thread_id' => $thread->GetID(),
            'content' => $content,
            'deleted' => false,
            'creator' => $creator->GetSteamID64(),
            'created' => time(),
            'last_edited' => time()
        ))
            ->into('forums_threads_posts');

        $postID = $databaseMain->getConnection()->getPDO()->lastInsertId();

        return new ThreadPost($postID);
    }

    // Get/Set Methods
    public function GetID() {
        if (!$this->exists) return;

        return $this->id;
    }

    // Get/Set methods
    public function GetContent() {
        if (!$this->exists) return;

        return $this->content;
    }
    public function GetCreator() {
        if (!$this->exists) return;

        return new User($this->creator);
    }
    public function GetCreated() {
        if (!$this->exists) return;

        return $this->created;
    }
    public function GetThread() {
        if (!$this->exists) return;

        return new Thread($this->threadID);
    }
    public function IsDeleted() {
        if (!$this->exists) return;

        return $this->deleted;
    }
}