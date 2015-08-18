<?php
namespace JsonRpcBundle\Controller;
use JsonRpcBundle\Server;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Communication\Email\Message;
use AppBundle\Communication\Email\PhpProvider;

class ServerController extends Controller
{
    public function handleAction(Request $request, $service)
    {
        $server = $this->get(Server::ID);
        $result = $server->handle($request->getContent(), $service);
        $logger = $this->get('monolog.logger.jsonrpc');

        if($this->container->getParameter('jsonrpc.switch') == 'on') {
            $logger->info($request->getContent());
        }

        $email = new Message();
        $email->setTo('bogdan.carpusor@gmail.com')
              ->setSubject('emag')
              ->setMessage('hello');

        $sendMail = new PhpProvider();
        var_dump($sendMail->send($email)); die('123');


        return new JsonResponse($result->toArray());
    }
}