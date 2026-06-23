<?php

namespace SerwerSMS\SerwerSMSBundle\Http;

use SerwerSMS\SerwerSMSBundle\SerwerSMS\Exception;

class CredentialsClient extends ApiClient
{
    protected readonly string $username;
    protected readonly string $password;

    public function __construct(
        string $username,
        string $password,
        string $apiUrl  = 'https://api2.serwersms.pl',
        int    $timeout = 30
    ) {
        if (empty($username)) {
            throw new Exception('Username is empty');
        }

        if (empty($password)) {
            throw new Exception('Password is empty');
        }

        parent::__construct($apiUrl, $timeout);

        $this->username = $username;
        $this->password = $password;
    }

    protected function applyAuth(array &$params): void
    {
        $params['username'] = $this->username;
        $params['password'] = $this->password;
    }

    protected function buildHeaders(string $dataString): array
    {
        return [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($dataString),
        ];
    }
}
