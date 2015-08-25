<?php

namespace AppBundle\Service;

use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\DigestAuthenticationEntryPoint;

class AuthenticationService extends DigestAuthenticationEntryPoint// implements AuthenticationEntryPointInterface
{

    public function start(Request $request, AuthenticationException $authException = null)
    {
       var_dump('ok'); die;
    }
}