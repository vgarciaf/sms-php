<?php

namespace Descom\Sms\Test;

use Descom\Sms\Auth\AuthUser;
use Descom\Sms\Exceptions\RequestFail;
use Descom\Sms\Message;
use Descom\Sms\Sms;
use PHPUnit\Framework\TestCase;

class SmsTest extends TestCase
{
    protected $authOK;

    protected $authBAD;

    public function setUp(): void
    {
        parent::setUp();

        $this->authOK = new AuthUser('apitest', 'apitest');

        $this->authBAD = new AuthUser('demo', 'demo');
    }

    /** @test */
    public function test_if_get_exception_in_request_with_bad_credential()
    {
        try {
            $sms = new Sms($this->authBAD);
            $balance = $sms->getBalance();
            $this->assertTrue(false);
        } catch (RequestFail $e) {
            $this->assertEquals($e->getCode(), 401);
        }
    }

    /** @test */
    public function test_if_balance_is_number()
    {
        $sms = new Sms($this->authOK);

        $balance = $sms->getBalance();

        is_int($balance) ? $this->assertIsInt($balance) : $this->assertIsFloat($balance);
    }

    /** @test */
    public function test_if_get_exception_when_send_sms_with_bad_credential()
    {
        try {
            $sms = new Sms($this->authBAD);

            $message = new Message();

            $message->addTo('6666666')->setText('test sms text');

            $result = $sms->addMessage($message)
                ->send();

            $this->assertTrue(false);
        } catch (RequestFail $e) {
            $this->assertEquals($e->getCode(), 401);
        }
    }

    /** @test */
    public function test_if_get_exception_when_send_sms_with_bad_destination()
    {
        try {
            $sms = new Sms($this->authOK);

            $message = new Message();

            $message->addTo('6666666a')->setText('test sms text');

            $result = $sms->addMessage($message)
                ->send();
            $this->assertTrue(false);
        } catch (RequestFail $e) {
            $this->assertEquals($e->getCode(), 422);
        }
    }

    /** @test */
    public function test_if_get_id_of_shipment_when_send_sms()
    {
        $sms = new Sms($this->authOK);

        $message = new Message();

        $message->addTo('6666666')->setText('test sms text');

        $result = $sms->addMessage($message)
            ->setDryrun(true)
            ->send();

        $this->assertGreaterThan(1, $result->id);
    }

    /** @test */
    public function test_if_get_id_of_shipment_when_send_sms_with_not_force_serder()
    {
        $sms = new Sms($this->authOK);

        $message = new Message();

        $message->addTo('6666666')->setText('test sms text');

        $result = $sms->addMessage($message)
            ->setDryrun(true)
            ->setSenderNotForce(true)
            ->send();

        $this->assertGreaterThan(1, $result->id);
    }

    /** @test */
    public function test_if_get_id_of_shipment_when_send_sms_clean_after_send()
    {
        $sms = new Sms($this->authOK);

        $message = new Message();

        $message->addTo('666666666')->setText('test sms text');

        $result = $sms->addMessage($message)
            ->setDryrun(true)
            ->send();

        $message->addTo('666666667')->setText('test sms text');

        $result = $sms->addMessage($message)
            ->setDryrun(true)
            ->send();

        $this->assertGreaterThan(1, $result->id);
        $this->assertEquals(1, $result->num_sms);
    }

    /** @test */
    public function test_if_senderID_info_is_authorized()
    {
        $sms = new Sms($this->authOK);

        $senderID = $sms->getSenderID();

        $this->assertContains(
            'INFO',
            $senderID
        );
    }

    /** @test */
    public function test_if_senderID_perverso_is_not_authorized()
    {
        $sms = new Sms($this->authOK);

        $senderID = $sms->getSenderID();

        $this->assertNotContains(
            'perverso',
            $senderID
        );
    }

    /** @test */
    public function test_if_senderID_info_is_authorized_with_details()
    {
        $sms = new Sms($this->authOK);

        $senderID = $sms->getSenderID(true);

        $this->assertContains('INFO', $senderID->platform);
    }
}
