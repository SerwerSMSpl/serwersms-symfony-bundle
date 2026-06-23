<?php

namespace SerwerSMS\SerwerSMSBundle\Http;

use SerwerSMS\SerwerSMSBundle\SerwerSMS\Exception;

class TokenClient extends ApiClient
{
    protected readonly string $token;

    public function __construct(
        string $token,
        string $apiUrl  = 'https://api2.serwersms.pl',
        int    $timeout = 30
    ) {
        if (empty($token)) {
            throw new Exception('Token is empty');
        }

        parent::__construct($apiUrl, $timeout);

        $this->token = $token;
    }

    protected function applyAuth(array &$params): void
    {
        // token is sent via Authorization header, not in params
    }

    protected function buildHeaders(string $dataString): array
    {
        return [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($dataString),
            'Authorization: Bearer ' . $this->token,
        ];
    }
}
