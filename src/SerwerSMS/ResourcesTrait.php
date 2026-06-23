<?php

namespace SerwerSMS\SerwerSMSBundle\SerwerSMS;

trait ResourcesTrait
{
    private ?Account     $accountResource     = null;
    private ?Blacklist   $blacklistResource   = null;
    private ?Contacts    $contactsResource    = null;
    private ?Error       $errorResource       = null;
    private ?Files       $filesResource       = null;
    private ?Groups      $groupsResource      = null;
    private ?Messages    $messagesResource    = null;
    private ?Phones      $phonesResource      = null;
    private ?Premium     $premiumResource     = null;
    private ?Senders     $sendersResource     = null;
    private ?Stats       $statsResource       = null;
    private ?Subaccounts $subaccountsResource = null;
    private ?Templates   $templatesResource   = null;

    public function account(): Account         { return $this->accountResource     ??= new Account($this); }
    public function blacklist(): Blacklist      { return $this->blacklistResource   ??= new Blacklist($this); }
    public function contacts(): Contacts       { return $this->contactsResource    ??= new Contacts($this); }
    public function error(): Error             { return $this->errorResource       ??= new Error($this); }
    public function files(): Files             { return $this->filesResource       ??= new Files($this); }
    public function groups(): Groups           { return $this->groupsResource      ??= new Groups($this); }
    public function messages(): Messages       { return $this->messagesResource    ??= new Messages($this); }
    public function phones(): Phones           { return $this->phonesResource      ??= new Phones($this); }
    public function premium(): Premium         { return $this->premiumResource     ??= new Premium($this); }
    public function senders(): Senders         { return $this->sendersResource     ??= new Senders($this); }
    public function stats(): Stats             { return $this->statsResource       ??= new Stats($this); }
    public function subaccounts(): Subaccounts { return $this->subaccountsResource ??= new Subaccounts($this); }
    public function templates(): Templates     { return $this->templatesResource   ??= new Templates($this); }
}
