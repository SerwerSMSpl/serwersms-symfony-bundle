<?php

namespace SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS\SerwerSMSTestCase;

class AccountTest extends SerwerSMSTestCase
{
    public function testLimits(): void
    {
        $r = $this->serwersms->account()->limits();
        $this->assertObjectHasProperty('items', $r);
        $this->assertNotEmpty($r->items);
        $this->assertObjectHasProperty('type', $r->items[0]);
        $this->assertEquals('eco', $r->items[0]->type);
    }
}
