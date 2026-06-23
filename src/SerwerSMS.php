<?php

namespace SerwerSMS\SerwerSMSBundle;

use SerwerSMS\SerwerSMSBundle\SerwerSMSInterface;
use SerwerSMS\SerwerSMSBundle\Http\CredentialsClient;
use SerwerSMS\SerwerSMSBundle\SerwerSMS\ResourcesTrait;

class SerwerSMS implements SerwerSMSInterface
{
    use ResourcesTrait;

    private SerwerSMSInterface $client;

    public function __construct(
        string $username,
        string $password,
        string $apiUrl  = 'https://api2.serwersms.pl',
        int    $timeout = 30
    ) {
        $this->client = new CredentialsClient($username, $password, $apiUrl, $timeout);
    }

    public function call(string $url, array $params = []): object
    {
        return $this->client->call($url, $params);
    }
}
