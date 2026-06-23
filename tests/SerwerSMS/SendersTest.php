<?php

namespace SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS\SerwerSMSTestCase;
use SerwerSMS\SerwerSMSBundle\SerwerSMS\Exception;

class SendersTest extends SerwerSMSTestCase
{
    public function testIndex(): void
    {
        $r = $this->serwersms->senders()->index(['personalized' => true]);
        $this->assertObjectHasProperty('items', $r);
    }

    public function testAdd(): void
    {
        try {
            $r = $this->serwersms->senders()->index(['personalized' => true]);
            $this->assertObjectHasProperty('items', $r);
        } catch (Exception|\Exception $e) {
            $this->fail(sprintf('[%s] %s', $e->getCode() ?? 0, $e->getMessage() ?? 'Unknown error'));
        }

        $filtered = array_values(array_filter($r->items, fn($item) => $item->name === 'NewSender'));
        if (count($filtered) > 0) {
            $this->markTestSkipped('Sender \'NewSender\' already exists.');
        }

        try {
            $r = $this->serwersms->senders()->add('NewSender');
            $this->assertObjectHasProperty('success', $r);
            $this->assertTrue($r->success);
        } catch (Exception|\Exception $e) {
            if (in_array((int)$e->getCode(), [4407])) {
                $this->markTestSkipped(sprintf('[%s] %s', $e->getCode(), $e->getMessage()));
            } else {
                $this->fail(sprintf('[%s] %s', $e->getCode() ?? 0, $e->getMessage() ?? 'Unknown error'));
            }
        }
    }
}
