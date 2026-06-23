<?php

namespace SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\SerwerSMSInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class SerwerSMSTestCase extends WebTestCase
{
    protected SerwerSMSInterface $serwersms;

    protected function setUp(): void
    {
        $this->serwersms = static::createClient()->getContainer()->get('serwer_sms');
    }
}
