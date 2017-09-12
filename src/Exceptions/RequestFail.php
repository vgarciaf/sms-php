<?php

namespace Descom\Sms\Exceptions;

use Exception;

class RequestFail extends Exception
{
    public static function create(string $message)
    {
        return new static($message);
    }
}
