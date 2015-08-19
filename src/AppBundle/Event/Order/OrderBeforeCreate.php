<?php

namespace AppBundle\Event\Order;

use AppBundle\Event\LoggableEventInterface;
use Symfony\Component\EventDispatcher\Event;

class OrderBeforeCreate extends Event implements LoggableEventInterface
{

    private $customerId;
    private $products;

    public function __construct($customerId, $products)
    {
        $this->customerId = $customerId;
        $this->products = $products;
    }

    public function getCustomerId()
    {
        return $this->customerId;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function getLogContext()
    {
        return array(
            'customerId' => $this->customerId,
            'products' => $this->products
        );
    }

}
