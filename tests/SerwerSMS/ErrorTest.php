<?php

namespace SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS\SerwerSMSTestCase;

class ErrorTest extends SerwerSMSTestCase
{
    public function testView(): void
    {
        try {
            $r = $this->serwersms->error()->view(1000);
            $this->assertObjectHasProperty('error', $r);
            $this->assertEquals(1000, $r->error->code);
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }
}
