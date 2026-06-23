<?php

namespace SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS\SerwerSMSTestCase;
use SerwerSMS\SerwerSMSBundle\SerwerSMS\Exception;

class SubaccountsTest extends SerwerSMSTestCase
{
    public function testAdd(): void
    {
        try {
            $r = $this->serwersms->subaccounts()->add('login', 'haslo', 123, ['phone' => '500600700']);
            $this->assertObjectHasProperty('success', $r);
            $this->assertTrue($r->success);
        } catch (Exception|\Exception $e) {
            if (in_array((int)$e->getCode(), [4500, 4502])) {
                $this->markTestSkipped(sprintf('[%s] %s', $e->getCode(), $e->getMessage()));
            } else {
                $this->fail(sprintf('[%s] %s', $e->getCode() ?? 0, $e->getMessage() ?? 'Unknown error'));
            }
        }
    }

    public function testIndex(): void
    {
        $r = $this->serwersms->subaccounts()->index();
        $this->assertObjectHasProperty('items', $r);
    }

    public function testView(): void
    {
        try {
            $r = $this->serwersms->subaccounts()->view(21973);
            $this->assertObjectHasProperty('username', $r);
        } catch (\Exception $e) {
            $this->markTestSkipped(sprintf('[%s] %s', $e->getCode(), $e->getMessage()));
        }
    }

    public function testLimit(): void
    {
        try {
            $r = $this->serwersms->subaccounts()->limit(123, 'eco', 200);
            $this->assertObjectHasProperty('success', $r);
            $this->assertFalse($r->success);
        } catch (\Exception $e) {
            $this->markTestSkipped(sprintf('[%s] %s', $e->getCode(), $e->getMessage()));
        }
    }

    public function testDelete(): void
    {
        try {
            $r = $this->serwersms->subaccounts()->delete(123);
            $this->assertObjectHasProperty('success', $r);
            $this->assertFalse($r->success);
        } catch (\Exception $e) {
            $this->markTestSkipped(sprintf('[%s] %s', $e->getCode(), $e->getMessage()));
        }
    }
}
