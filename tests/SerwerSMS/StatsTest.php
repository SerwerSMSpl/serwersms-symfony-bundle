<?php

namespace SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS\SerwerSMSTestCase;

class StatsTest extends SerwerSMSTestCase
{
    public function testIndex(): void
    {
        $r = $this->serwersms->stats()->index();
        $this->assertObjectHasProperty('items', $r);
    }
}
