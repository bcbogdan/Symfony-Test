<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        $router = $this->get('router');

        $routes = array();
        $routeNames = [];
        foreach ($router->getRouteCollection()->all() as $name => $route) {

            if($name[0] != "_") {
                if(strpos($name, "_") == false) {
                    $routes[$name] = $route->compile();
                    array_push($routeNames, $name);
                }
            }
        }
        return $this->render('AppBundle:Dashboard:index.html.twig', array(
            'routes' => $routeNames
        ));
    }

}