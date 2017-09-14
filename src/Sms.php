<?php

namespace Descom\Sms;

use Descom\Sms\Auth\AuthInterface as Auth;
use Descom\Sms\Exceptions\MessageTextAlreadyExits;
use Descom\Sms\Exceptions\RequestFail;
use Descom\Sms\Http\Http;

class Sms
{
    /**
     * The headers for request API.
     *
     * @var array
     */
    private $headers = [
        'Content-Type'  => 'application/json',
    ];

    /**
     * Define if then sent is dryrun.
     *
     * @var bool
     */
    private $dryrun = false;

    /**
     * Define if then messages for sent.
     *
     * @var array
     */
    private $messages = [];

    /**
     * Create a new sms instance.
     *
     * @param \Descom\Sms\Auth\BaseAuth $auth
     *
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->headers = array_merge($this->headers, $auth->headers());
    }

    /**
     * Set if the sent is dryrun.
     *
     * @param bool $dryrun
     *
     * @return $this
     */
    public function setDryrun($dryrun)
    {
        $this->dryrun = $dryrun;

        return $this;
    }

    /**
     * Add a message in sent.
     *
     * @param \Descom\Sms\Message $message
     *
     * @return $this
     */
    public function addMessage(Message $message)
    {
        foreach ($this->messages as $cur_message) {
            if ($cur_message->text == $message->text) {
                throw new MessageTextAlreadyExits($message->text);
            }
        }

        $this->messages[] = $message;

        return $this;
    }

    /**
     * Get the balance in platform.
     *
     * @return float
     */
    public function getBalance()
    {
        $http = new Http();

        $response = $http->sendHttp('GET', 'balance', $this->headers);

        if ($response->status == 200) {
            $data = json_decode($response->message);

            return $data->balance;
        } else {
            $exception = new RequestFail($response->message, $response->status);
            throw $exception;
        }
    }

    /**
     * Send SMS's to the platform.
     *
     * @return object
     */
    public function send()
    {
        $http = new Http();

        $data = [
            'messages' => [],
        ];

        foreach ($this->messages as $message) {
            $data['messages'][] = $message->getArray();
        }

        if (isset($this->dryrun) && $this->dryrun) {
            $data['dryrun'] = true;
        }

        $response = $http->sendHttp('POST', 'sms/send', $this->headers, $data);

        $this->messages = [];

        if ($response->status == 200) {
            return json_decode($response->message);
        } else {
            throw new RequestFail($response->message, $response->status);
        }
    }
}
