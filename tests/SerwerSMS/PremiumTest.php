<?php

namespace SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS\SerwerSMSTestCase;
use SerwerSMS\SerwerSMSBundle\SerwerSMS\Exception;

class PremiumTest extends SerwerSMSTestCase
{
    public function testIndex(): void
    {
        $r = $this->serwersms->premium()->index();
        $this->assertObjectHasProperty('items', $r);
    }

    public function testSend(): void
    {
        try {
            $r = $this->serwersms->premium()->send('500600700', 'Wiadomosc', 71200, 123456);
            $this->assertTrue(false);
        } catch (Exception $e) {
            $this->assertEquals(4201, $e->getCode());
            $this->assertTrue(true);
        }
    }

    public function testQuiz(): void
    {
        try {
            $r = $this->serwersms->premium()->quiz(123);
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertEquals(1004, $e->getCode());
            $this->assertTrue(true);
        }
    }
}
