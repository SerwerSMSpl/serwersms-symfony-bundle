<?php

namespace SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS\SerwerSMSTestCase;

class ContactsTest extends SerwerSMSTestCase
{
    public function testAdd(): void
    {
        $params = [
            'email'      => 'test@mail.com',
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'company'    => 'Hello Word!',
        ];

        $r = $this->serwersms->contacts()->add(123, '500600800', $params);
        $this->assertObjectHasProperty('success', $r);
        $this->assertTrue($r->success);
    }

    public function testIndex(): void
    {
        $r = $this->serwersms->contacts()->index();
        $this->assertObjectHasProperty('items', $r);
    }

    public function testView(): void
    {
        $list = $this->serwersms->contacts()->index();
        $this->assertObjectHasProperty('items', $list);
        if (empty($list->items)) {
            $this->markTestSkipped('No contacts available.');
        }
        $r = $this->serwersms->contacts()->view($list->items[0]->id);
        $this->assertObjectHasProperty('id', $r);
    }

    public function testEdit(): void
    {
        $list = $this->serwersms->contacts()->index();
        $this->assertObjectHasProperty('items', $list);
        if (empty($list->items)) {
            $this->markTestSkipped('No contacts available.');
        }
        $params = [
            'email'      => 'test@mail.com',
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'company'    => 'Hello Word!',
        ];

        $r = $this->serwersms->contacts()->edit($list->items[0]->id, 123, '500600700', $params);
        $this->assertObjectHasProperty('success', $r);
        $this->assertTrue($r->success);
    }

    public function testDelete(): void
    {
        $list = $this->serwersms->contacts()->index();
        $this->assertObjectHasProperty('items', $list);
        if (empty($list->items)) {
            $this->markTestSkipped('No contacts available.');
        }
        $r = $this->serwersms->contacts()->delete($list->items[0]->id);
        $this->assertObjectHasProperty('success', $r);
        $this->assertTrue($r->success);
    }

    public function testImport(): void
    {
        $contact = [
            ['phone' => '500600700', 'email' => 'test@mail.com', 'first_name' => 'John', 'last_name' => 'Doe', 'company' => 'Hello Word!'],
            ['phone' => '500600800', 'email' => 'test@mail.com', 'first_name' => 'John', 'last_name' => 'Doe', 'company' => 'Hello Word!'],
        ];

        $g = $this->serwersms->contacts()->import('New group', $contact);
        $this->assertObjectHasProperty('success', $g);
        $this->assertObjectHasProperty('id', $g);
        $this->assertIsInt($g->id);
        $this->assertGreaterThan(0, $g->id);

        $c = $this->serwersms->contacts()->index($g->id);
        $this->assertObjectHasProperty('items', $c);
        $this->assertIsArray($c->items);
        $this->assertCount(2, $c->items);

        $d = $this->serwersms->groups()->delete($g->id, true);
        $this->assertObjectHasProperty('success', $d);
        $this->assertTrue($d->success);
    }
}
