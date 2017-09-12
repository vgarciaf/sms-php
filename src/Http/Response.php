<?php

namespace Descom\Sms\Http;

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class Response
{
    /**
     * The status HTTP response.
     *
     * @var array
     */
    public $status;

    /**
     * The Body HTTP response.
     *
     * @var array
     */
    public $message;
}
