<?php

namespace SerwerSMS\SerwerSMSBundle\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\SerwerSMSInterface;

class Templates
{
    public function __construct(protected SerwerSMSInterface $master)
    {
    }

	/**
	 * List of templates
	 * @param array $params
     *      @option string "sort" Values: name
     *      @option string "order" Values: asc|desc
	 * @return object
	 *      @option object "items"
	 *          @option int "id"
	 *          @option string "name"
	 *          @option string "text"
	 */
    public function index(array $params = []): object
    {
        return $this->master->call('templates/index', $params);
    }

	/**
	 * Adding new template
	 * 
	 * @param string $name
	 * @param string $text
	 * @return object
	 *      @option object
	 *          @option bool "success"
	 *          @option int "id"
	 */
    public function add(string $name, string $text): object
    {
        return $this->master->call('templates/add', [
            'name' => $name,
            'text' => $text,
        ]);
    }

	/**
	 * Editing a template
	 * 
	 * @param int $id
	 * @param string $name
	 * @param string $text
	 * @return object
	 *      @option bool "success"
	 *      @option int "id"
	 */
    public function edit(int $id, string $name, string $text): object
    {
        return $this->master->call('templates/edit', [
            'id'   => $id,
            'name' => $name,
            'text' => $text,
        ]);
    }

	/**
	 * Deleting a template
	 * 
	 * @param int $id
	 * @return object
	 *      @option bool "success"
	 */
    public function delete(int $id): object
    {
        return $this->master->call('templates/delete', ['id' => $id]);
    }
}
