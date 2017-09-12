<?php

namespace Descom\Sms\Test;


use Descom\Sms\Auth\AuthUser;
use PHPUnit\Framework\TestCase;
use Descom\Sms\Exceptions\RequestFail;
use Descom\Sms\Sms;

class SmsTest extends TestCase
{
    /** @test */
    public function request_fail_if_send_bad_auth()
    {
        $this->expectException(RequestFail::class);
        $sms = new Sms(new AuthUser('demo', 'demo'));

        $balance = $sms->getBalance();
    }
}
