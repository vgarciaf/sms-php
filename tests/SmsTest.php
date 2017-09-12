<?php

namespace Descom\Sms\Test;

use Descom\Sms\Auth\AuthUser;
use Descom\Sms\Exceptions\RequestFail;
use Descom\Sms\Message;
use Descom\Sms\Sms;
use PHPUnit\Framework\TestCase;

class SmsTest extends TestCase
{
    /** @test */
    public function request_fail_if_send_bad_auth()
    {
        $this->expectException(RequestFail::class);
        $sms = new Sms(new AuthUser('demo', 'demo'));

        $balance = $sms->getBalance();
    }

    /** @test */
    public function send_sms_with_bad_auth()
    {
        $this->expectException(RequestFail::class);
        $sms = new Sms(new AuthUser('demo', 'demo'));

        $message = new Message();

        $message->addDestintation('6666666')->setText('test sms text');

        $result = $sms->addMessage($message)
                ->setDryrun(true)
                ->send();
    }
}
