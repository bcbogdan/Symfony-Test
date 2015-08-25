<?php
namespace AppBundle\Service\Document;
use AppBundle\Document\Document;
use AppBundle\Document\ProductLine;
use AppBundle\Entity\Order;
use AppBundle\Event\Order\OrderEvent;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Templating\EngineInterface as Templating;


class DocumentService
{
    const ID = 'app.document';
    /**
     *
     * @var Templating
     */
    private $twigEngine;
    /**
     *
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    /**
     *
     * @var DocumentManager
     */
    private $documentManager;
    public function __construct(
        Templating $twigEngine,
        EventDispatcherInterface $eventDispatcher,
        ManagerRegistry $documentManager
    ) {
        $this->twigEngine = $twigEngine;
        $this->eventDispatcher = $eventDispatcher;
        $this->documentManager = $documentManager->getManager();
    }
    public function generateInvoice(Order $order) {
        $templateName = 'AppBundle:Document:invoice.html.twig';
        $document = $this->createDocumentFromOrder($order);
        $html = $this->twigEngine->render($templateName, array('document' => $document));
        $document->setBodyHtml($html);
        $document->setBodyPdf($this->convertHtmlToPdf($html));
        $this->documentManager->persist($document);
        $this->documentManager->flush();$this->eventDispatcher->dispatch(
            OrderEvent::INVOICE_GENERATED, new OrderEvent($order)
        );
    }
    private function createDocumentFromOrder(Order $order) {
        $document = new Document();
        $billingAddress = $order->getBillingAddress();
        $productLines = $this->createProductLinesFromOrder($order);
        $total = 0;
        foreach ($productLines as $productLine) {
            $total += $productLine->getTotal();
        }
        $document->setBillingAddress($billingAddress->getName())
            ->setCurrency($billingAddress->getCountry()->getCurrency())
            ->setCustomerName($order->getCustomer()->getContact()->getName())
            ->setOrderNumber($order->getId())
            ->setProductLines($productLines)
            ->setTotal($total)
            ->setType('invoice');
        return $document;
    }
    private function createProductLinesFromOrder(Order $order) {
        $productLines = array();
        foreach ($order->getProductLines() as $orderProductLine) {
            $code = $orderProductLine->getProductSale()->getProduct()->getCode();
            $title = $orderProductLine->getProductSale()->getProduct()->getTitle();
            $price = $orderProductLine->getProductSale()->getPrice();
            $quantity = $orderProductLine->getQuantity();
            $productLine = new ProductLine();
            $productLine->setCode($code)
                ->setPrice($price)
                ->setQuantity($quantity)
                ->setTitle($title)
                ->setTotal($quantity * $price);
            $productLines[] = $productLine;
        }
        return $productLines;
    }
    private function convertHtmlToPdf($html) {
        $process = new Process(sprintf("echo '%s' | wkhtmltopdf - -", $html));
        $process->run();
        return $process->getOutput();
    }
}