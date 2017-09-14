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
     * The senderID of the message.
     *
     * @var string
     */
    private $senderID;

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
     * Set the "senderID" of the message.
     *
     * @param string $senderID
     *
     * @return $this
     */
    public function setsenderID($senderID)
    {
        $this->senderID = $senderID;

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

        if (isset($senderID) && $senderID) {
            $response['senderID'] = $senderID;
        }

        return $response;
    }
}
