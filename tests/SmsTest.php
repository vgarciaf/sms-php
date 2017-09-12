<?php
namespace Descom\Sms\Test;

use Descom\Sms\Sms;
use Descom\Sms\Auth\AuthUser;
use Descom\Sms\Exceptions\RequestFail;

class SmsTest extends TestCase
{
    protected $sms;

    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function request_fail_if_send_bad_auth()
    {
        $this->expectException(RequestFail::class);
        $sms = new Sms(new AuthUser('demo', 'demo'));

        $balance = $sms->getBalance();
    }
}
