<?php

require_once("resource/common.php");

class Board
{
    private $id;
    private $parentID;
    private $name;
    private $description;
    private $creator;
    private $created;
    public $exists;

    function __construct($boardID = null)
    {
        global $databaseMain;

        $this->exists = false;
        if (!$boardID) return;


        $boardData = $databaseMain->from('forums_boards')
            ->where('id')->is($boardID)
            ->select()
            ->first();
        if (!$boardData) return;
        $this->exists = true;

        $this->id = $boardData->id;
        $this->parentID = $boardData->parent_id;
        $this->name = $boardData->name;
        $this->description = $boardData->description;
        $this->creator = $boardData->creator;
        $this->created = $boardData->created;
    }

    public function Create($name, $description, $parent, $creator, $background = false){
        global $databaseMain;

        $data = array(
            'parent_id' => $parent,
            'name' => $name,
            'description' => $description,
            'creator' => $creator->GetSteamID64(),
            'created' => time()
        );

        if (!$parent) {
            unset($data['parent_id']);
        }

        $databaseMain->insert($data)
            ->into('forums_boards');

        $boardID = $databaseMain->getConnection()->getPDO()->lastInsertId();

        if ($background) {
            $background->save('public/storage/forums/' . $boardID . '.jpg');
        }

        return new Board($boardID);
    }

    // Get/Set methods
    public function GetID() {
        if (!$this->exists) return;

        return $this->id;
    }
    public function GetName() {
        if (!$this->exists) return;

        return $this->name;
    }
    public function GetDescription() {
        if (!$this->exists) return;

        return $this->description;
    }
    public function GetParent() {
        if (!$this->exists) return;
        if (!$this->parentID) return false;

        return new Board($this->parentID);
    }
    public function GetChildren() {
        if (!$this->exists) return;
        global $databaseMain;

        $results = $databaseMain->from('forums_boards')
            ->where('parent_id')->is($this->GetID())
            ->select()
            ->all();
        if (!$results) return [];


        $boards = [];
        foreach($results as $board) {
            $boardOjb = new Board($board->id);
            array_push($boards, $boardOjb);
        }

        return $boards;
    }
    public function GetThreads() {
        if (!$this->exists) return;
        global $databaseMain;

        $results = $databaseMain->from('forums_threads')
            ->orderBy('sticky', 'desc')
            ->orderBy('last_edited', 'desc')
            ->where('board_id')->is($this->GetID())
            ->select()
            ->all();
        if (!$results) return [];


        $threads = [];
        foreach($results as $thread) {
            $threadOjb = new Thread($thread->id);
            array_push($threads, $threadOjb);
        }

        return $threads;
    }

    public function GetImage() {
        if (!$this->exists) return;

        if(!file_exists('public/storage/forums/' . $this->GetID() . '.jpg')) return false;

        return '/public/storage/forums/' . $this->GetID() . '.jpg';
    }

    // Other
    public function GetBreadCrumb() {
        if (!$this->exists) return [];
        $boards = [];

        $targetBoard = $this->GetParent();
        while($targetBoard) {
            array_push($boards, $targetBoard);
            $targetBoard = $targetBoard->GetParent();
        }

        return $boards;
    }
    public function GetBreadCrumbAsString() {
        if (!$this->exists) return;
        $breadCrumb = "";

        foreach($this->GetBreadCrumb() as $board) {
            $breadCrumb = $board->GetName() . "/" . $breadCrumb;
        }

        return $breadCrumb;
    }

    // Actions
    public function GetAll() {
        global $databaseMain;

        $results = $databaseMain->from('forums_boards')
            ->select()
            ->all();
        if (!$results) return [];


        $boards = [];
        foreach($results as $board) {
            $boardOjb = new Board($board->id);
            array_push($boards, $boardOjb);
        }

        return $boards;
    }
    public function GetBoardsWithParent($parent = NULL) {
        global $databaseMain;

        if ($parent) {
            $results = $databaseMain->from('forums_boards')
                ->where('parent_id')->is($parent)
                ->select()
                ->all();
        } else {
            $results = $databaseMain->from('forums_boards')
                ->where('parent_id')->isNull()
                ->select()
                ->all();
        }
        if (!$results) return [];


        $boards = [];
        foreach($results as $board) {
            $boardOjb = new Board($board->id);
            array_push($boards, $boardOjb);
        }

        return $boards;
    }
}