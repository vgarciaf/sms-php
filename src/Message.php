<?php

namespace Descom\Sms;

use Descom\Sms\Exceptions\DestinationAlreadyExits;

class Message
{
    /**
     * The text of the message.
     *
     * @var string
     */
    private $text;

    /**
     * The destinations of the message.
     *
     * @var array
     */
    private $destinations = [];

    /**
     * The senderid of the message.
     *
     * @var string
     */
    private $senderid;

    /**
     * Set the "destination" of the message.
     *
     * @param string|array $to
     *
     * @return $this
     */
    public function addTo($to)
    {
        $destinations = (array) $to;

        foreach ($destinations as $destination) {
            if (in_array($destinations, $this->destinations)) {
                throw DestinationAlreadyExits::create($destination);
            } else {
                $this->destinations[] = $destination;
            }
        }

        return $this;
    }

    /**
     * Set the "text" of the message.
     *
     * @param string $message
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Set the "senderid" of the message.
     *
     * @param string $senderid
     *
     * @return $this
     */
    public function setSenderId($senderid)
    {
        $this->senderid = $senderid;

        return $this;
    }

    /**
     * Get array to send message.
     *
     * @return array
     */
    public function getArray()
    {
        $response = [
            'text'         => $this->text,
            'to'           => $this->destinations,
        ];

        if (isset($senderid) && $senderid) {
            $response['senderid'] = $senderid;
        }

        return $response;
    }
}
