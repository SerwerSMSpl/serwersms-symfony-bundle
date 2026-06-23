<?php

namespace SerwerSMS\SerwerSMSBundle\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\SerwerSMSInterface;

class Account
{
    public function __construct(protected SerwerSMSInterface $master)
    {
    }

    /**
     * Return limits SMS
     *
     * @param array<string, mixed> $params
     *      @option bool "show_type"
     * @return object
     *      @option array "items"
     *          @option string "type" Type of message
     *          @option string "chars_limit" The maximum length of message
     *          @option string "value" Limit messages
     */
    public function limits(array $params = []): object
    {
        return $this->master->call('account/limits', $params);
    }
}
