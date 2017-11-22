<?php

use Descom\Sms\Auth\AuthUser;
use Descom\Sms\Exceptions\DestinationAlreadyExists;
use Descom\Sms\Exceptions\MessageTextAlreadyExists;
use Descom\Sms\Exceptions\RequestFail;
use Descom\Sms\Message;
use Descom\Sms\Sms;

require '../vendor/autoload.php';

if ($argc < 5) {
    echo 'Usage '.$argv[0]." username password destination text.\n";
    exit(1);
}

$sms = new Sms(new AuthUser($argv[1], $argv[2]));

$message = new Message();

try {
    $message->addTo($argv[3])->setText($argv[4]);

    $result = $sms->addMessage($message)
            ->setDryrun(false)
            ->send();

    var_dump($result);
} catch (RequestFail $e) {
    echo 'Error nº: '.$e->getCode().'; message: '.$e->getMessage()."\n";
} catch (DestinationAlreadyExists $e) {
    echo 'Error: '.$e->getMessage()."\n";
} catch (MessageTextAlreadyExists $e) {
    echo 'Error: '.$e->getMessage()."\n";
}
