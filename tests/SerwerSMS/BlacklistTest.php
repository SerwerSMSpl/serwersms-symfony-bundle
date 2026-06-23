<?php

namespace SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS\SerwerSMSTestCase;

class BlacklistTest extends SerwerSMSTestCase
{
    public function testAdd(): void
    {
        $r = $this->serwersms->blacklist()->add('500600720');
        $this->assertObjectHasProperty('success', $r);
        $this->assertTrue($r->success);
    }

    public function testIndex(): void
    {
        $r = $this->serwersms->blacklist()->index();
        $this->assertObjectHasProperty('items', $r);
    }

    public function testCheck(): void
    {
        $r = $this->serwersms->blacklist()->check('500600720');
        $this->assertObjectHasProperty('exists', $r);
        $this->assertTrue($r->exists);
    }

    public function testDelete(): void
    {
        $r = $this->serwersms->blacklist()->delete('500600720');
        $this->assertObjectHasProperty('success', $r);
        $this->assertTrue($r->success);
    }
}
