<?php

namespace SerwerSMS\SerwerSMSBundle\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\SerwerSMSInterface;

class Senders
{
    public function __construct(protected SerwerSMSInterface $master)
    {
    }

	/**
	 * Creating new Sender name
	 * 
	 * @param string $name
	 * @return object
	 *      @option bool "success"
	 */
    public function add(string $name): object
    {
        return $this->master->call('senders/add', ['name' => $name]);
    }

	/**
	 * Senders list
	 * 
	 * @param array $params
	 *      @option bool "predefined"
     *      @option string "sort" Values: name
     *      @option string "order" Values: asc|desc
	 * @return object
	 *      @option object "items"
	 *          @option string "name"
	 *          @option string "agreement" delivered|required|not_required
	 *          @option string "status" pending_authorization|authorized|rejected|deactivated
	 */
    public function index(array $params = []): object
    {
        return $this->master->call('senders/index', $params);
    }
}
