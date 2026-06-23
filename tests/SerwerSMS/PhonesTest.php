<?php

namespace SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS\SerwerSMSTestCase;

class PhonesTest extends SerwerSMSTestCase
{
    public function testCheck(): void
    {
        $r = $this->serwersms->phones()->check('500600700');
        $this->assertObjectHasProperty('phone', $r);
    }

    public function testTest(): void
    {
        $r = $this->serwersms->phones()->test('500600700');
        $this->assertObjectHasProperty('correct', $r);
        $this->assertTrue($r->correct);
    }
}
