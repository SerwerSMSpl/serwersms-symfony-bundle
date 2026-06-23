<?php

namespace SerwerSMS\SerwerSMSBundle\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\SerwerSMSInterface;

class Subaccounts
{
    public function __construct(protected SerwerSMSInterface $master)
    {
    }

	/**
	 * Creating new subaccount
	 * 
	 * @param string $subaccount_username
	 * @param string $subaccount_password
	 * @param int $subaccount_id Subaccount ID, which is template of powers
	 * @param array $params
	 *      @option string "name"
	 *      @option string "phone"
	 *      @option string "email"
	 * @return object
	 *      @option bool "success"
	 *      @option int "id"
	 */
    public function add(string $subaccount_username, string $subaccount_password, int $subaccount_id, array $params = []): object
    {
        return $this->master->call('subaccounts/add', array_merge([
            'subaccount_username' => $subaccount_username,
            'subaccount_password' => $subaccount_password,
            'subaccount_id'       => $subaccount_id,
        ], $params));
    }

	/**
	 * List of subaccounts
	 * 
	 * @return array
	 *      @option object "items"
	 *          @option int "id"
	 *          @option string "username"
	 */
    public function index(): object
    {
        return $this->master->call('subaccounts/index', []);
    }

	/**
	 * View details of subaccount
	 * 
	 * @param int $id
	 * @return object
	 *      @option int "id"
	 *      @option string "username"
	 *      @option string "name"
	 *      @option string "phone"
	 *      @option string "email"
	 */
    public function view(int $id): object
    {
        return $this->master->call('subaccounts/view', ['id' => $id]);
    }

	/**
	 * Setting the limit on subaccount
	 * 
	 * @param int $id
	 * @param string $type Message type: eco|full|voice|mms|hlr
	 * @param int $value
	 * @return object
	 *      @option bool "success"
	 *      @option int "id"
	 */
    public function limit(int $id, string $type, int $value): object
    {
        return $this->master->call('subaccounts/limit', [
            'id'    => $id,
            'type'  => $type,
            'value' => $value,
        ]);
    }

	/**
	 * Deleting a subaccount
	 * 
	 * @param int $id
	 * @return object
	 *      @option bool "success"
	 */
    public function delete(int $id): object
    {
        return $this->master->call('subaccounts/delete', ['id' => $id]);
    }
}
