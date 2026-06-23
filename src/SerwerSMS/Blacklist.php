<?php

namespace SerwerSMS\SerwerSMSBundle\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\SerwerSMSInterface;

class Blacklist
{
    public function __construct(protected SerwerSMSInterface $master)
    {
    }

	/**
	 * Add phone to the blacklist
	 * 
	 * @param string $phone
	 * @return object
	 *      @option bool "success"
	 *      @option int "id"
	 */
    public function add(string $phone): object
    {
        return $this->master->call('blacklist/add', ['phone' => $phone]);
    }

	/**
	 * List of blacklist phones
	 * 
	 * @param string $phone
	 * @param array $params
	 *      @option int "page" The number of the displayed page
	 *      @option int "limit" Limit items are displayed on the single page
	 * @return object
	 *      @option array "paging"
	 *          @option int "page" The number of current page
	 *          @option int "count" The number of all pages
	 *      @option array "items"
	 *          @option string "phone"
	 *          @option string "added" Date of adding phone
	 */
    public function index(?string $phone = null, array $params = []): object
    {
        return $this->master->call('blacklist/index', array_merge($params, [
            'phone' => $phone,
        ]));
    }

	/**
	 * Checking if phone is blacklisted
	 * 
	 * @param string $phone
	 * @return object
	 *      @option bool "exists"
	 */
    public function check(string $phone): object
    {
        return $this->master->call('blacklist/check', ['phone' => $phone]);
    }

	/**
	 * Deleting phone from the blacklist
	 * 
	 * @param string $phone
	 * @return object
	 *      @option bool "success"
	 */
    public function delete(string $phone): object
    {
        return $this->master->call('blacklist/delete', ['phone' => $phone]);
    }
}
