<?php
namespace AppBundle\Event\Listener;
use AppBundle\Event\Order\OrderAfterCreate;
use AppBundle\Event\Order\OrderBeforeCreate;
use AppBundle\Service\AbstractDoctrineAware;
use AppBundle\Service\WarehouseService;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Communication\Email\Message;
use AppBundle\Service\EmailService;

class OrderListener extends AbstractDoctrineAware
{
    /** @var WarehouseService */
    private $warehouseService;

    /** @var  EmailService */
    private $EmailService;

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

        $email = new Message();
        $email->setTo('bogdan.carpusor@gmail.com')
              ->setSubject('emag')
              ->setMessage('hello');

//        var_dump( $this->EmailService); die('213');
        $this->EmailService->send($email);
        $this->warehouseService->reserveProducts($event->getOrder());
    }
    public function setWarehouseService(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
        return $this;
    }

    public function setEmailService(EmailService $EmailService)
    {
        $this->EmailService = $EmailService;
        return $this;
    }
}