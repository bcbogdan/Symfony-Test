<?php

namespace AppBundle\Event\Order;

use AppBundle\Entity\Order;
use AppBundle\Event\LoggableEventInterface;
use Symfony\Component\EventDispatcher\Event;

class OrderStatus extends Event implements LoggableEventInterface
{
    const STATUS_CHANGE = 'order.status';

    private $order;
    private $state;

    public function __construct(Order $order, $state)
    {
        $this->order  = $order;
        $this->state  = $state;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getLogContext()
    {
        if($this->state){
            return array('new status' => $this->order->getStatus());
        } else {
            return array('old status' => $this->order->getStatus());
        }

    }

}