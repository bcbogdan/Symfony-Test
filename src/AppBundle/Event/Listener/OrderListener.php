<?php
namespace AppBundle\Event\Listener;
use AppBundle\Event\Order\OrderAfterCreate;
use AppBundle\Event\Order\OrderBeforeCreate;
use AppBundle\Service\AbstractDoctrineAware;
use AppBundle\Service\WarehouseService;
use Symfony\Component\HttpFoundation\Request;


class OrderListener extends AbstractDoctrineAware
{
    /** @var WarehouseService */
    private $warehouseService;
    public function onBeforeCreate(OrderBeforeCreate $event)
    {
        $request = Request::createFromGlobals();
        $this->logger->addInfo(
            'Creating order', array(
            'customerId' => $event->getCustomerId(),
            'products'   => $event->getProducts(),
            'request'    => $request->getContent(),
        ));
    }
    public function onAfterCreate(OrderAfterCreate $event)
    {
        $this->logger->addInfo(
            'Order created', array('orderId' => $event->getOrder()->getId())
        );
        $this->warehouseService->reserveProducts($event->getOrder());
    }
    public function setWarehouseService(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
        return $this;
    }
}