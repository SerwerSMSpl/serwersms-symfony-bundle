<?php

namespace SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS\SerwerSMSTestCase;
use SerwerSMS\SerwerSMSBundle\SerwerSMS\Exception;

class GroupsTest extends SerwerSMSTestCase
{
    public function testAdd(): void
    {
        try {
            $r = $this->serwersms->groups()->add('test');
        } catch (Exception $e) {
            if ($e->getCode() === 28) {
                $this->markTestSkipped('API timeout.');
            }
            throw $e;
        }
        $this->assertObjectHasProperty('success', $r);
        $this->assertTrue($r->success);
    }

    public function testIndex(): void
    {
        try {
            $r = $this->serwersms->groups()->index();
        } catch (Exception $e) {
            if ($e->getCode() === 28) {
                $this->markTestSkipped('API timeout.');
            }
            throw $e;
        }
        $this->assertObjectHasProperty('items', $r);
    }

    public function testView(): void
    {
        try {
            $list = $this->serwersms->groups()->index();
        } catch (Exception $e) {
            if ($e->getCode() === 28) {
                $this->markTestSkipped('API timeout.');
            }
            throw $e;
        }
        if (empty($list->items)) {
            $this->markTestSkipped('No groups available.');
        }
        $r = $this->serwersms->groups()->view($list->items[0]->id);
        $this->assertObjectHasProperty('id', $r);
    }

    public function testEdit(): void
    {
        try {
            $list = $this->serwersms->groups()->index();
        } catch (Exception $e) {
            if ($e->getCode() === 28) {
                $this->markTestSkipped('API timeout.');
            }
            throw $e;
        }
        if (empty($list->items)) {
            $this->markTestSkipped('No groups available.');
        }
        $r = $this->serwersms->groups()->edit($list->items[0]->id, 'New name');
        $this->assertObjectHasProperty('success', $r);
        $this->assertTrue($r->success);
    }

    public function testDelete(): void
    {
        try {
            $list = $this->serwersms->groups()->index();
        } catch (Exception $e) {
            if ($e->getCode() === 28) {
                $this->markTestSkipped('API timeout.');
            }
            throw $e;
        }
        if (empty($list->items)) {
            $this->markTestSkipped('No groups available.');
        }
        $r = $this->serwersms->groups()->delete($list->items[0]->id);
        $this->assertObjectHasProperty('success', $r);
        $this->assertTrue($r->success);
    }

    public function testCheck(): void
    {
        try {
            $r = $this->serwersms->groups()->check('600700800');
        } catch (Exception $e) {
            if ($e->getCode() === 28) {
                $this->markTestSkipped('API timeout.');
            }
            throw $e;
        }
        $this->assertObjectHasProperty('items', $r);
    }
}
