<?php

namespace SerwerSMS\SerwerSMSBundle\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\SerwerSMSInterface;

class Phones
{
    public function __construct(protected SerwerSMSInterface $master)
    {
    }

	/**
	 * Checking phone in to HLR
	 * 
	 * @param string $phone
	 * @param string $id Query ID returned if the processing takes longer than 60 seconds
	 * @return object
	 *      @option string "phone"
	 *      @option string "status"
	 *      @option int "imsi"
	 *      @option string "network"
	 *      @option bool "ported"
	 *      @option string "network_ported"
	 */
    public function check(string $phone, ?string $id = null): object
    {
        return $this->master->call('phones/check', [
            'phone' => $phone,
            'id'    => $id,
        ]);
    }

	/**
	 * Validating phone number
	 * 
	 * @param string $phone
	 * @return object
	 *      @option bool "correct"
	 */
    public function test(string $phone): object
    {
        return $this->master->call('phones/test', ['phone' => $phone]);
    }
}
