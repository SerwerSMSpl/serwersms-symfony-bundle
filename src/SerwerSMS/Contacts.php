<?php

namespace SerwerSMS\SerwerSMSBundle\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\SerwerSMSInterface;

class Contacts
{
    public function __construct(protected SerwerSMSInterface $master)
    {
    }

	/**
	 * Add new contact
	 * 
	 * @param int|array $group_id
	 * @param string $phone
	 * @param array $params
	 *      @option string "email"
	 *      @option string "first_name"
	 *      @option string "last_name"
	 *      @option string "company"
	 *      @option string "tax_id"
	 *      @option string "address"
	 *      @option string "city"
	 *      @option string "description"
	 * @return object
	 *      @option bool "success"
	 *      @option int "id"
	 */
    public function add(int|array $group_id, string $phone, array $params = []): object
    {
        return $this->master->call('contacts/add', array_merge($params, [
            'group_id' => $group_id,
            'phone'    => $phone,
        ]));
    }

	/**
	 * List of contacts
	 * 
	 * @param int $group_id
	 * @param string $search
	 * @param array $params
	 *      @option int "page" The number of the displayed page
	 *      @option int "limit" Limit items are displayed on the single page
     *      @option string "sort" Values: first_name|last_name|phone|company|tax_id|email|address|city|description
     *      @option string "order" Values: asc|desc
	 * @return object
	 *      @option array "paging"
	 *          @option int "page" The number of current page
	 *          @option int "count" The number of all pages
	 *      @options array "items"
	 *          @option int "id"
	 *          @option string "phone"
	 *          @option string "email"
	 *          @option string "company"
	 *          @option string "first_name"
	 *          @option string "last_name"
	 *          @option string "tax_id"
	 *          @option string "address"
	 *          @option string "city"
	 *          @option string "description"
	 *          @option bool "blacklist"
	 *          @option int "group_id"
	 *          @option string "group_name"
	 */
    public function index(?int $group_id = null, ?string $search = null, array $params = []): object
    {
        return $this->master->call('contacts/index', array_merge($params, [
            'group_id' => is_null($group_id) ? 'none' : $group_id,
            'search'   => $search,
        ]));
    }

	/**
	 * View single contact
	 * 
	 * @param int $id
	 * @return object
	 *      @option integer "id"
	 *      @option string "phone"
	 *      @option string "email"
	 *      @option string "company"
	 *      @option string "first_name"
	 *      @option string "last_name"
	 *      @option string "tax_id"
	 *      @option string "address"
	 *      @option string "city"
	 *      @option string "description"
	 *      @option bool "blacklist"
	 */
    public function view(int $id): object
    {
        return $this->master->call('contacts/view', ['id' => $id]);
    }

	/**
	 * Editing a contact
	 * 
	 * @param int $id
	 * @param int|array $group_id
	 * @param string $phone
	 * @param array $params
	 *      @option string "email"
	 *      @option string "first_name"
	 *      @option string "last_name"
	 *      @option string "company"
	 *      @option string "tax_id"
	 *      @option string "address"
	 *      @option string "city"
	 *      @option string "description"
	 * @return object
	 *      @option bool "success"
	 *      @option int "id"
	 */
    public function edit(int $id, int|array $group_id, string $phone, array $params = []): object
    {
        return $this->master->call('contacts/edit', array_merge($params, [
            'id'       => $id,
            'group_id' => $group_id,
            'phone'    => $phone,
        ]));
    }

	/**
	 * Deleting a phone from contacts
	 * 
	 * @param int $id
	 * @return object
	 *      @option bool "success"
	 */
    public function delete(int $id): object
    {
        return $this->master->call('contacts/delete', ['id' => $id]);
    }

	/**
	 * Import contact list
	 * 
	 * @param string $group_name
	 * @param array $contact[]
	 *      @option string "phone"
	 *      @option string "email"
	 *      @option string "first_name"
	 *      @option string "last_name"
	 *      @option string "company"
	 * @return object
	 *      @option bool "success"
	 *      @option int "id"
	 *      @option int "correct" Number of contacts imported correctly
	 *      @option int "failed" Number of errors
	 */
    public function import(string $group_name, array $contact): object
    {
        return $this->master->call('contacts/import', [
            'group_name' => $group_name,
            'contact'    => $contact,
        ]);
    }
}
