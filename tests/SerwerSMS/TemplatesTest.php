<?php

namespace SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS\SerwerSMSTestCase;

class TemplatesTest extends SerwerSMSTestCase
{
    public function testIndex(): void
    {
        $r = $this->serwersms->templates()->index();
        $this->assertObjectHasProperty('items', $r);
    }

    public function testAdd(): void
    {
        $r = $this->serwersms->templates()->add('New template', 'Message from template');
        $this->assertObjectHasProperty('success', $r);
        $this->assertTrue($r->success);
    }

    public function testEdit(): void
    {
        $list = $this->serwersms->templates()->index();
        if (empty($list->items)) {
            $this->markTestSkipped('No SMS template to edit.');
        }
        $r = $this->serwersms->templates()->edit($list->items[0]->id, 'New template', 'Editing message from template');
        $this->assertObjectHasProperty('success', $r);
        $this->assertTrue($r->success);
    }

    public function testDelete(): void
    {
        $list = $this->serwersms->templates()->index();
        if (empty($list->items)) {
            $this->markTestSkipped('No SMS template to delete.');
        }
        $r = $this->serwersms->templates()->delete($list->items[0]->id);
        $this->assertObjectHasProperty('success', $r);
        $this->assertTrue($r->success);
    }
}
