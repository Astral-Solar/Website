<?php

require_once("resource/common.php");

class Group
{
    private $id;
    private $name;
    private $identifier;
    private $creator;
    private $created;
    public $exists;

    function __construct($identifier = null)
    {
        global $databaseMain;

        $this->exists = false;
        if (!$identifier) return;

        $groupData = $databaseMain->from('groups')
            ->where('identifier')->is($identifier)
            ->select()
            ->first();
        if (!$groupData) return;
        $this->exists = true;

        $this->identifier = $identifier;

        $this->id = $groupData->id;
        $this->name = $groupData->name;
        $this->creator = $groupData->creator;
        $this->created = $groupData->created;
    }

    public function Create($name, $identifier, $creator){
        global $databaseMain;
        $databaseMain->insert(array(
            'name' => $name,
            'identifier' => $identifier,
            'creator' => $creator->GetSteamID64(),
            'created' => time()
        ))->into('groups');

        return new Group($identifier);
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
    public function SetName($name) {
        if (!$this->exists) return;
        global $databaseMain;

        $databaseMain->update('groups')
            ->where('id')->is($this->GetID())
            ->set([
                'name' => $name
            ]);
    }
    public function GetIdentifier() {
        if (!$this->exists) return;

        return $this->identifier;
    }
    public function SetIdentifier($name) {
        if (!$this->exists) return;
        global $databaseMain;

        $databaseMain->update('groups')
            ->where('id')->is($this->GetID())
            ->set([
                'identifier' => $name
            ]);
    }

    // Permissions
    public function HasPermission($node) {
        if (!$this->exists) return;

        global $databaseMain;
        $groupData = $databaseMain->from('groups_permissions')
            ->where('group_id')->is($this->GetID())
            ->where('node')->is($node)
            ->select()
            ->first();

        // We can use this to get general permissions. For example if we want to check if a user has any permission in the group category
        if (!$groupData) {
            $allPermissions = $this->GetAllPermissions($node);

            if (!$allPermissions) return false;

            return true;
        }

        return true;
    }
    public function GivePermission($node) {
        if (!$this->exists) return;

        global $databaseMain;
        $databaseMain->insert(array(
            'group_id' => $this->GetID(),
            'node' => $node
        ))->into('groups_permissions');
    }
    public function RemovePermission($node) {
        if (!$this->exists) return;

        global $databaseMain;
        $databaseMain->from('groups_permissions')
            ->where('group_id')->is($this->GetID())
            ->where('node')->is($node)
            ->delete();
    }
    public function GetAllPermissions($flag = '%') {
        if (!$this->exists) return;

        global $databaseMain;
        return $databaseMain->from('groups_permissions')
            ->where('group_id')->is($this->GetID())
            ->where('node')->like($flag)
            ->select()
            ->all();
    }

    // Actions
    public function GetAllGroups() {
        global $databaseMain;

        $results = $databaseMain->from('groups')
            ->select()
            ->all();
        if (!$results) return;


        $groups = [];
        foreach($results as $group) {
            $groupObj = new Group($group->identifier);
            array_push($groups, $groupObj);
        }

        return $groups;
    }
}