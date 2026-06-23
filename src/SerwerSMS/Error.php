<?php

namespace SerwerSMS\SerwerSMSBundle\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\SerwerSMSInterface;

class Error
{
	public function __construct(protected SerwerSMSInterface $master)
    {
    }

    /**
     * Preview error
     *
     * @param int $code
     * @return object
     *      @option int "code"
     *      @option string "type"
     *      @option string "message"
     */
    public function view(int $code): object
    {
        return $this->master->call('error/' . $code, []);
    }
}
