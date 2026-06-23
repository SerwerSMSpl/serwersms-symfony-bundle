<?php

namespace SerwerSMS\SerwerSMSBundle\SerwerSMS;

use RuntimeException;

/**
 * Thrown when the SerwerSMS API returns an error response,
 * when the token is missing, or when an HTTP/CURL call fails.
 *
 * The exception code maps directly to the API error code returned
 * in the JSON payload (result->error->code), CURL error code,
 * or HTTP status code.
 */
class Exception extends RuntimeException
{
}
