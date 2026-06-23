<?php

namespace SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS;

use SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS\SerwerSMSTestCase;
use SerwerSMS\SerwerSMSBundle\SerwerSMS\Exception;

class MessagesTest extends SerwerSMSTestCase
{
    public function testSendSms(): void
    {
        $r = $this->serwersms->messages()->sendSms('500600700', 'Test message', 'INFORMACJA', ['test' => true, 'details' => true]);
        $this->assertObjectHasProperty('success', $r);
        $this->assertTrue($r->success);
        $this->assertObjectHasProperty('items', $r);
    }

    public function testSendPersonalized(): void
    {
        $messages = [
            ['phone' => '500600700', 'text' => 'First message'],
            ['phone' => '600700800', 'text' => 'Second message'],
        ];

        $r = $this->serwersms->messages()->sendPersonalized($messages, 'INFORMACJA', ['test' => true, 'details' => true]);
        $this->assertObjectHasProperty('success', $r);
        $this->assertTrue($r->success);
        $this->assertObjectHasProperty('items', $r);
    }

    public function testSendVoice(): void
    {
        $r = $this->serwersms->messages()->sendVoice('500600700', ['text' => 'Test message', 'test' => true, 'details' => true]);
        $this->assertObjectHasProperty('success', $r);
        $this->assertTrue($r->success);
        $this->assertObjectHasProperty('items', $r);
    }

    public function testSendMms(): void
    {
        $list = $this->serwersms->files()->index('mms');
        $this->assertObjectHasProperty('items', $list);
        $deleteFileAfterTesting = 0;

        if (empty($list->items)) {
            $params = [
                'url'  => 'https://static.serwersms.pl/files/demo.jpg',
                'name' => 'Demo jpg',
            ];
            $r = $this->serwersms->files()->add('mms', $params);
            $this->assertObjectHasProperty('success', $r);

            $list = $this->serwersms->files()->index('mms');
			$this->assertObjectHasProperty('items', $list);
			if (empty($list->items)) {
				$this->markTestSkipped('File mms was added but now is not available in index.');
			}

            $deleteFileAfterTesting = $r->id;
        }

        try {
			$r = $this->serwersms->messages()->sendMms('500600700', 'MMS Title', ['test' => true, 'file_id' => $list->items[0]->id, 'details' => true]);
			$this->assertObjectHasProperty('success', $r);
			$this->assertTrue($r->success);
			$this->assertObjectHasProperty('items', $r);
		} catch (\Exception $e) {
			$this->fail(sprintf('[%s] %s', $e->getCode(), $e->getMessage()));
        } finally {
            if ($deleteFileAfterTesting > 0) {
                $this->serwersms->files()->delete($deleteFileAfterTesting, 'mms');
            }
        }
    }

    public function testView(): void
    {
        $list = $this->serwersms->messages()->reports();
        $this->assertObjectHasProperty('items', $list);
        if (empty($list->items)) {
            $this->markTestSkipped('No message reports available.');
        }
        $r = $this->serwersms->messages()->view($list->items[0]->id);
        $this->assertObjectHasProperty('id', $r);
    }

    public function testReports(): void
    {
        $r = $this->serwersms->messages()->reports();
        $this->assertObjectHasProperty('items', $r);
    }

    public function testDelete(): void
    {
        $list = $this->serwersms->messages()->reports();
        $this->assertObjectHasProperty('items', $list);
        if (empty($list->items)) {
            $this->markTestSkipped('No message reports available.');
        }
        $r = $this->serwersms->messages()->delete($list->items[0]->id);
        $this->assertObjectHasProperty('success', $r);
        $this->assertFalse($r->success);
    }

    public function testReceived(): void
    {
        $r = $this->serwersms->messages()->received('nd');
        $this->assertObjectHasProperty('items', $r);
    }
}
