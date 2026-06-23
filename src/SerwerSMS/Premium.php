<?php

namespace SerwerSMS\SerwerSMSBundle\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\SerwerSMSInterface;

class Premium
{
    public function __construct(protected SerwerSMSInterface $master)
    {
    }

	/**
	 * List of received SMS Premium
	 * 
	 * @return object
	 *      @option object "items"
	 *          @option int "id"
	 *          @option string "to_number" Premium number
	 *          @option string "from_number" Sender phone number
	 *          @option string "date"
	 *          @option int "limit" Limitation the number of responses
	 *          @option string "text" Message
	 */
    public function index(): object
    {
        return $this->master->call('premium/index', []);
    }

	/**
	 * Sending replies for received SMS Premium
	 * 
	 * @param string $phone
	 * @param string $text Message
	 * @param string $gate Premium number
	 * @param int $id ID received SMS Premium
	 * @return object
	 *      @option bool "success"
	 */
    public function send(string $phone, string $text, string $gate, int $id): object
    {
        return $this->master->call('premium/send', [
            'phone' => $phone,
            'text'  => $text,
            'gate'  => $gate,
            'id'    => $id,
        ]);
    }

	/**
	 * View quiz results
	 * 
	 * @param int $id
	 * @return object
	 *      @option int "id"
	 *      @option string "name"
	 *      @option object "items"
	 *          @option int "id"
	 *          @option int "count" Number of response
	 */
    public function quiz(int $id): object
    {
        return $this->master->call('quiz/view', ['id' => $id]);
    }
}
