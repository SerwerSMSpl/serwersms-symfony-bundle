<?php

namespace SerwerSMS\SerwerSMSBundle;

use SerwerSMS\SerwerSMSBundle\SerwerSMS\Exception;

interface SerwerSMSInterface
{
    /**
     * @param array<string, mixed> $params
     * @throws Exception
     */
    public function call(string $url, array $params = []): object;
}
