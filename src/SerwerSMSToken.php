<?php

namespace SerwerSMS\SerwerSMSBundle;

use SerwerSMS\SerwerSMSBundle\SerwerSMSInterface;
use SerwerSMS\SerwerSMSBundle\Http\TokenClient;
use SerwerSMS\SerwerSMSBundle\SerwerSMS\ResourcesTrait;

class SerwerSMSToken implements SerwerSMSInterface
{
    use ResourcesTrait;

    private SerwerSMSInterface $client;

    public function __construct(
        string $token,
        string $apiUrl  = 'https://api2.serwersms.pl',
        int    $timeout = 30
    ) {
        $this->client = new TokenClient($token, $apiUrl, $timeout);
    }

    public function call(string $url, array $params = []): object
    {
        return $this->client->call($url, $params);
    }
}
