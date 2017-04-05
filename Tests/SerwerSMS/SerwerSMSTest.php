<?php

namespace SerwerSMS\SerwerSMSBundle\Tests\SerwerSMS;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class SerwerSMSTest extends WebTestCase {
	
    public function testSendSms() {
		
        $serwersms = static::createClient()->getContainer()->get('serwer_sms');
        $r =  $serwersms->messages->sendSms(
                  array('500000001'
                  ),
                  'Test FULL message',
                  'INFORMACJA',
                  array(
                          'test' => true,
                          'details' => true
                  )
        );
        $this->assertObjectHasAttribute('success', $r);
        $this->assertTrue($r->success);
        $this->assertObjectHasAttribute('items', $r);
		
    }	
}