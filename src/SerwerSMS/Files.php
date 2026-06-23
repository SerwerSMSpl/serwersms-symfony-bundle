<?php

namespace SerwerSMS\SerwerSMSBundle\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\SerwerSMSInterface;

class Files
{
    public function __construct(protected SerwerSMSInterface $master)
    {
    }

	/**
	 * Add new file
	 * 
	 * @param string $type - mms|voice
	 * @param array $params
	 *      @option string "url" URL address to file
	 *      @option resource "file" A file handler (only for MMS)
	 * @return object
	 *      @option bool "success"
	 *      @option string "id"
	 */
    public function add(string $type, array $params): object
    {
        return $this->master->call('files/add', array_merge($params, ['type' => $type]));
    }

	/**
	 * List of files
	 * 
	 * @param string $type - mms|voice
	 * @return object
	 *      @option array "items"
	 *          @option string "id"
	 *          @option string "name"
	 *          @option int "size"
	 *          @option string "type" - mms|voice
	 *          @option string "date"
	 */
    public function index(string $type): object
    {
        return $this->master->call('files/index', ['type' => $type]);
    }

	/**
	 * View file
	 * 
	 * @param string $id
	 * @param string $type - mms|voice
	 * @return object
	 *      @option string "id"
	 *      @option string "name"
	 *      @option int "size"
	 *      @option string "type" - mms|voice
	 *      @option string "date"
	 */
    public function view(string $id, string $type): object
    {
        return $this->master->call('files/view', [
            'id'   => $id,
            'type' => $type,
        ]);
    }

	/**
	 * Deleting a file
	 * 
	 * @param string $id
	 * @param string $type - mms|voice
	 * @return object
	 *      @option bool "success"
	 */
    public function delete(string $id, string $type): object
    {
        return $this->master->call('files/delete', [
            'id'   => $id,
            'type' => $type,
        ]);
    }
}
