<?php

namespace AppBundle\Event\Order;

use AppBundle\Entity\Order;
use AppBundle\Event\LoggableEventInterface;
use Symfony\Component\EventDispatcher\Event;

class OrderEvent extends Event implements LoggableEventInterface
{
    const BEFORE_CREATE               = 'order.before_create';
    const AFTER_CREATE                = 'order.after_create';
    const PRODUCTS_RESERVATION_FAILED = 'order.products_reservation_failed';
    const PRODUCTS_RESERVED           = 'order.products_reserved';
    const PACKAGING_START             = 'order.packaging_start';
    const PACKAGING_END               = 'order.packaging_end';
    const INVOICE_GENERATED           = 'order.invoice_generated';
    const DELIVERY_START              = 'order.delivery_start';
    const DELIVERY_END                = 'order.delivery_end';
    /**
     *
     * @var Order
     */
    private $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    public function getOrder()
    {
        return $this->order;
    }


    public function getLogContext()
    {
        return array('id' => $this->order->getId());
    }

}
