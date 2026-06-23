<?php

namespace SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS\SerwerSMSTestCase;

class FilesTest extends SerwerSMSTestCase
{
    public function testAddMms(): void
    {
        $params = [
            'url'  => 'https://static.serwersms.pl/files/demo.jpg',
            'name' => 'Demo png',
        ];
        $r = $this->serwersms->files()->add('mms', $params);
        $this->assertObjectHasProperty('success', $r);
        $this->assertTrue($r->success);
    }

    public function testAddVoice(): void
    {
        $params = [
            'url'  => 'https://static.serwersms.pl/files/demo.wav',
            'name' => 'Demo wav',
        ];
        $r = $this->serwersms->files()->add('voice', $params);
        $this->assertObjectHasProperty('success', $r);
        $this->assertTrue($r->success);
    }

    public function testIndexMms(): void
    {
        $r = $this->serwersms->files()->index('mms');
        $this->assertObjectHasProperty('items', $r);

        if (!is_countable($r->items) || count($r->items) < 1) {
            $this->markTestSkipped('No MMS files available.');
        }
    }

    public function testIndexVoice(): void
    {
        $r = $this->serwersms->files()->index('voice');
        $this->assertObjectHasProperty('items', $r);

        if (!is_countable($r->items) || count($r->items) < 1) {
            $this->markTestSkipped('No Voice files available.');
        }
    }

    public function testViewMms(): void
    {
        $list = $this->serwersms->files()->index('mms');
        $this->assertObjectHasProperty('items', $list);
        if (empty($list->items)) {
            $this->markTestSkipped('No MMS files available.');
        }
        $r = $this->serwersms->files()->view($list->items[0]->id, 'mms');
        $this->assertObjectHasProperty('id', $r);
    }

    public function testViewVoice(): void
    {
        $list = $this->serwersms->files()->index('voice');
        $this->assertObjectHasProperty('items', $list);
        if (empty($list->items)) {
            $this->markTestSkipped('No Voice files available.');
        }
        $r = $this->serwersms->files()->view($list->items[0]->id, 'voice');
        $this->assertObjectHasProperty('id', $r);
    }

    public function testDeleteMms(): void
    {
        $list = $this->serwersms->files()->index('mms');
        $this->assertObjectHasProperty('items', $list);
        if (empty($list->items)) {
            $this->markTestSkipped('No MMS files available.');
        }

        $r = $this->serwersms->files()->delete($list->items[0]->id, 'mms');
        $this->assertObjectHasProperty('success', $r);
        $this->assertTrue($r->success);
    }

    public function testDeleteVoice(): void
    {
        $list = $this->serwersms->files()->index('voice');
        $this->assertObjectHasProperty('items', $list);
        if (empty($list->items)) {
            $this->markTestSkipped('No Voice files available.');
        }

        $r = $this->serwersms->files()->delete($list->items[0]->id, 'voice');
        $this->assertObjectHasProperty('success', $r);
        $this->assertTrue($r->success);
    }
}
