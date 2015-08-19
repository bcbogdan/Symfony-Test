<?php
namespace JsonRpcBundle\Controller;
use JsonRpcBundle\Server;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


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



        return new JsonResponse($result->toArray());
    }
}