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
     * The sender of the message.
     *
     * @var string
     */
    private $sender;


    /**
         * Set the "destination" of the message.
         *
         * @param  string|array $destination
         * @return $this
         */
    public function addDestintation($destination)
    {
        $destinations = (array) $destination;

        foreach ($destinations as $destination)
        {
            if (in_array($destinations, $this->destinations))
            {
                throw DestinationAlreadyExits::create($destination);
            }
            else
            {
                $this->destinations[] = $destination;
            }
        }

        return $this;
    }

    /**
         * Set the "text" of the message.
         *
         * @param  string $message
         * @return $this
         */
    public function setText(string $text)
    {
        $this->text = $text;

        return $this;
    }

    /**
         * Set the "sender" of the message.
         *
         * @param  string $sender
         * @return $this
         */
    public function setSender(string $sender)
    {
        $this->sender = $sender;

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
            'text' => $this->text,
            'destinations' => $this->destinations
        ];

        if (isset($sender) && $sender)
        {
            $response['sender'] = $sender;
        }

        return $response;
    }

}
