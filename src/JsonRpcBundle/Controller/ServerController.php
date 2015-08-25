<?php

namespace JsonRpcBundle\Controller;

use JsonRpcBundle\Logger;
use JsonRpcBundle\Server;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ServerController extends Controller
{

    public function handleAction(Request $request, $service)
    {
        $requestContent = $request->getContent();
        $logger = $this->get(Logger::ID)->getLogger();
        $logger->addInfo('request', array('content' => $requestContent));
        $server = $this->get(Server::ID);

        $authChecker = $this->get('security.authorization_checker');
        if (false === $authChecker->isGranted($service, $server)) {
            throw $this->createAccessDeniedException('Access denied');
        }

        $result = $server->handle($requestContent, $service);
        $result = $result->toArray();
        $logger->addInfo('response', $result);
        return new JsonResponse($result);
    }

}
