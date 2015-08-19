<?php
namespace AppBundle\Event;
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Symfony\Component\EventDispatcher\Event;
class EventDispatcher extends ContainerAwareEventDispatcher
{
    public function dispatch($eventName, Event $event = null)
    {
        if ($event instanceof LoggableEventInterface) {
            $this->getContainer()
                ->get('logger')
                ->addInfo($eventName, $event->getLogContext());
        }
        return parent::dispatch($eventName, $event);
    }
}