<?php

namespace SerwerSMS\SerwerSMSBundle\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\SerwerSMSInterface;

class Groups
{
    public function __construct(protected SerwerSMSInterface $master)
    {
    }

	/**
	 * Add new group
	 * 
	 * @param string $name
	 * @return object
	 *      @option bool "success"
	 *      @option int "id"
	 */
    public function add(string $name): object
    {
        return $this->master->call('groups/add', ['name' => $name]);
    }

	/**
	 * List of group
	 * 
	 * @param string $search Group name
	 * @param array $params
	 *      @option int "page" The number of the displayed page
	 *      @option int "limit" Limit items are displayed on the single page
     *      @option string "sort" Values: name
     *      @option string "order" Values: asc|desc
	 * @return object
	 *      @option array "paging"
	 *          @option int "page" The number of current page
	 *          @option int "count" The number of all pages
	 *      @option array "items"
	 *          @option int "id"
	 *          @option string "name"
	 *          @option int "count" Number of contacts in the group
	 */
    public function index(?string $search = null, array $params = []): object
    {
        return $this->master->call('groups/index', array_merge(['search' => $search], $params));
    }

	/**
	 * View single group
	 * 
	 * @param int $id
	 * @return object
	 *      @option int "id"
	 *      @option string "name"
	 *      @option int "count" Number of contacts in the group
	 */
    public function view(int $id): object
    {
        return $this->master->call('groups/view', ['id' => $id]);
    }

	/**
	 * Editing a group
	 * 
	 * @param int $id
	 * @param string $name
	 * @return object
	 *      @option bool "success"
	 *      @option int "id"
	 */
    public function edit(int $id, string $name): object
    {
        return $this->master->call('groups/edit', [
            'id'   => $id,
            'name' => $name,
        ]);
    }

	/**
	 * Deleting a group
	 * 
	 * @param int $id
	 * @param bool|null $delete_contacts If true, also deletes all contacts in the group
	 * @return object
	 *      @option bool "success"
	 */
    public function delete(int $id, ?bool $delete_contacts = null): object
    {
        $params = ['id' => $id];
        if ($delete_contacts === true) {
            $params['delete_contacts'] = true;
        }
        return $this->master->call('groups/delete', $params);
    }

	/**
	 * Viewing a groups containing phone
	 * 
	 * @param string $phone
	 * @return object
	 *      @option int "id"
	 *      @option int "group_id"
	 *      @option string "group_name"
	 */
    public function check(string $phone): object
    {
        return $this->master->call('groups/check', ['phone' => $phone]);
    }
}
