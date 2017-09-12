<?php

namespace Descom\Sms\Exceptions;

use InvalidArgumentException;

class MessageTextAlreadyExits extends InvalidArgumentException
{
    public static function create(string $text)
    {
        return new static("A `{$text}` text message already exists in a other message.");
    }
}
