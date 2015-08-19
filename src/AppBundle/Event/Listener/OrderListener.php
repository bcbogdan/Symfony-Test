<?php

namespace AppBundle\Event\Listener;

use AppBundle\Entity\Order;
use AppBundle\Event\Order\OrderBeforeCreate;
use AppBundle\Event\Order\OrderEvent;
use AppBundle\Service\DeliveryService;
use AppBundle\Service\WarehouseService;
use AppBundle\Event\Order\OrderStatus;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bridge\Monolog\Logger;
class OrderListener
{

    /**
     *
     * @var WarehouseService
     */
    private $warehouseService;

    /**
     *
     * @var DeliveryService
     */
    private $deliveryService;

    private $eventDispatcher;

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(
        WarehouseService $warehouseService,
        DeliveryService $deliveryService,
        EventDispatcherInterface $eventDispatcher,
        Logger $logger
    )
    {
        $this->warehouseService = $warehouseService;
        $this->deliveryService = $deliveryService;
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
    }

    public function onBeforeCreate(OrderBeforeCreate $event)
    {

    }

    public function onAfterCreate(OrderEvent $event)
    {

        $this->warehouseService->reserveProducts($event->getOrder());
    }

    public function onReservationFailed(OrderEvent $event)
    {

        $this->eventDispatcher->dispatch(
            OrderStatus::STATUS_CHANGE,
            new OrderStatus($event->getOrder(), 0)
        );

        $event->getOrder()->setStatus(Order::STATUS_PROCESSING_PRODUCTS_MISSING);

        $this->eventDispatcher->dispatch(
            OrderStatus::STATUS_CHANGE,
            new OrderStatus($event->getOrder(), 1)
        );
    }

    public function setWarehouseService(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
        return $this;
    }

    public function onProductsReserved(OrderEvent $event)
    {
        $this->eventDispatcher->dispatch(
            OrderStatus::STATUS_CHANGE,
            new OrderStatus($event->getOrder(), 0)
        );

        $event->getOrder()->setStatus(Order::STATUS_PROCESSING_PRODUCTS_RESERVED);
        $productLines = $event->getOrder()->getProductLines();
        foreach($productLines as $productLine) {
            $this->logger->info('Reserved products' . $productLine->getProductSale()->getProduct());
        }
        $this->eventDispatcher->dispatch(
            OrderStatus::STATUS_CHANGE,
            new OrderStatus($event->getOrder(), 1)
        );
        $this->warehouseService->packageProducts($event->getOrder());
    }

    public function onPackagingStart(OrderEvent $event)
    {
        $this->eventDispatcher->dispatch(
            OrderStatus::STATUS_CHANGE,
            new OrderStatus($event->getOrder(), 0)
        );
        $event->getOrder()->setStatus(Order::STATUS_PROCESSING_PACKAGING);
        $this->eventDispatcher->dispatch(
            OrderStatus::STATUS_CHANGE,
            new OrderStatus($event->getOrder(), 1)
        );
    }

    public function onPackagingEnd(OrderEvent $event)
    {
        $this->deliveryService->deliverProducts($event->getOrder());
    }

    public function onDeliveryStart(OrderEvent $event)
    {
        $this->eventDispatcher->dispatch(
            OrderStatus::STATUS_CHANGE,
            new OrderStatus($event->getOrder(), 0)
        );
        $event->getOrder()->setStatus(Order::STATUS_DELIVERY_STARTED);
        $this->eventDispatcher->dispatch(
            OrderStatus::STATUS_CHANGE,
            new OrderStatus($event->getOrder(), 1)
        );
    }

    public function onDeliveryEnd(OrderEvent $event)
    {
        $this->eventDispatcher->dispatch(
            OrderStatus::STATUS_CHANGE,
            new OrderStatus($event->getOrder(), 0)
        );
        $event->getOrder()->setStatus(Order::STATUS_DELIVERED);
        $this->eventDispatcher->dispatch(
            OrderStatus::STATUS_CHANGE,
            new OrderStatus($event->getOrder(), 1)
        );
    }

    public function onStatusChange(OrderStatus $event)
    {

    }
}
