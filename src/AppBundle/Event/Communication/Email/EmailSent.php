<?php

namespace AppBundle\Event\Communication\Email;

use AppBundle\Communication\Email\Message;

class EmailSent extends EmailEvent
{

    /**
     *
     * @var Message
     */
    private $message;

    public function __construct($type, $emailAddress, $arguments, Message $message)
    {
        parent::__construct($type, $emailAddress, $arguments);
        $this->message = $message;
    }

    public function getLogContext()
    {
        $context = array(
            'from' => $this->message->getFrom(),
            'subject' => $this->message->getSubject(),
            'body' => $this->message->getMessage()
        );
        return array_merge(parent::getLogContext(), $context);
    }

    public function getMessage()
    {
        return $this->message;
    }

}
