<?php

require_once("resource/common.php");

class Premium
{
    private $id;
    private $userID;
    private $subscriber;
    private $status;
    private $cancelURL;
    private $updateURL;
    private $started;
    private $nextBill;
    private $active;
    public $exists;

    function __construct($userID = null)
    {
        global $databaseMain;

        $this->exists = false;
        if (!$userID) return;


        $subData = $databaseMain->from('subscriptions')
            ->where('userid')->is($userID)
            ->select()
            ->first();
        if (!$subData) return;
        $this->exists = true;

        $this->id = $subData->id;
        $this->userID = $subData->userid;
        $this->subscriber = $subData->subscriber;
        $this->status = $subData->status;
        $this->cancelURL = $subData->cancel_url;
        $this->updateURL = $subData->update_url;
        $this->started = $subData->started;
        $this->nextBill = $subData->next_bill;
        $this->active = $subData->active;
    }

    public function Create($userID, $subscriber, $cancelURL, $updateURL, $nextBill) {
        global $databaseMain;
        global $config;

        $databaseMain->insert(array(
                'userid' => $userID,
                'subscriber' => $subscriber,
                'status' => 'active',
                'cancel_url' => $cancelURL,
                'update_url' => $updateURL,
                'started' => time(),
                'next_bill' => strtotime($nextBill),
                'active' => true
            ))
            ->into('subscriptions');



        $user = new User($userID);
        if($user->exists and $user->GetLinkedDiscord()) {
            $restCord = new \RestCord\DiscordClient([
                'token' => $config->get('Discord')['botToken']
            ]);

            $restCord->guild->addGuildMemberRole([
                'guild.id' => intval($config->get('Discord')['guildID']),
                'user.id' => intval($user->GetLinkedDiscord()->discord_id),
                'role.id' => $config->get('Discord')['roles']['premium']
            ]);
        }

        return new Premium($userID);
    }
    public function Delete() {
        if (!$this->exists) return;
        global $databaseMain;
        global $config;

        $databaseMain->from('subscriptions')
            ->where('id')->is($this->GetID())
            ->delete();

        if($this->GetUser()->exists and $this->GetUser()->GetLinkedDiscord()) {
            $restCord = new \RestCord\DiscordClient([
                'token' => $config->get('Discord')['botToken']
            ]);

            $restCord->guild->removeGuildMemberRole([
                'guild.id' => intval($config->get('Discord')['guildID']),
                'user.id' => intval($this->GetUser()->GetLinkedDiscord()->discord_id),
                'role.id' => $config->get('Discord')['roles']['premium']
            ]);
        }
    }

    // Get/Set Methods
    public function GetID() {
        if (!$this->exists) return;

        return $this->id;
    }
    public function GetUser() {
        if (!$this->exists) return;

        return new User($this->userID);
    }
    public function SetActive($state) {
        if (!$this->exists) return;
        global $databaseMain;

        $databaseMain->update('subscriptions')
            ->where('userid')->is($this->GetUser()->GetSteamID64())
            ->set([
                'active' => $state,
            ]);
    }
    public function GetStatus() {
        if (!$this->exists) return;

        return $this->status;
    }
    public function SetStatus($status) {
        if (!$this->exists) return;
        global $databaseMain;

        $databaseMain->update('subscriptions')
            ->where('userid')->is($this->GetUser()->GetSteamID64())
            ->set([
                'status' => $status,
            ]);
    }
    public function SetNextBillDate($date) {
        if (!$this->exists) return;
        global $databaseMain;

        $databaseMain->update('subscriptions')
            ->where('userid')->is($this->GetUser()->GetSteamID64())
            ->set([
                'next_bill' => strtotime($date),
            ]);
    }
    public function GetNextBillDate() {
        if (!$this->exists) return;

        return $this->nextBill;
    }
    public function GetStarted() {
        if (!$this->exists) return;

        return $this->started;
    }
    public function GetCancelURL() {
        if (!$this->exists) return;

        return $this->cancelURL;
    }
    public function GetUpdateURL() {
        if (!$this->exists) return;

        return $this->updateURL;
    }

    // Other stuff
    public function LogRequest($data)
    {
        global $databaseMain;

        $databaseMain->insert(array(
                'data' => json_encode($data),
            ))
            ->into('paddle_log');
    }
    public function ValidateKey($key, $data) {
        global $config;
        // This is pretty much entirely yoinked from here https://developer.paddle.com/webhook-reference/verifying-webhooks
        $public_key = openssl_get_publickey($config->get('Paddle')['publicKey']);

        $signature = base64_decode($key);


        $fields = $data;
        unset($fields['p_signature']);
        // ksort() and serialize the fields
        ksort($fields);
        foreach($fields as $k => $v) {
            if(!in_array(gettype($v), array('object', 'array'))) {
                $fields[$k] = "$v";
            }
        }
        $serializedData = serialize($fields);


        // Verify the signature
        return openssl_verify($serializedData, $signature, $public_key, OPENSSL_ALGO_SHA1) == 1;
    }
}