<?php

namespace Descom\Sms\Exceptions;

use InvalidArgumentException;

class DestinationAlreadyExits extends InvalidArgumentException
{
    public static function create(string $destination)
    {
        return new static("A `{$destination}` destination already exists in a same message.");
    }
}
