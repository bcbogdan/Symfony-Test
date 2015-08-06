<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
//        $availableApiRoutes = [];
//        foreach ($this->get('router')->getRouteCollection()->all() as $name => $route) {
//            $route = $route->compile();
//            if( strpos($name, "api_") !== 0 ){
//                $emptyVars = [];
//                foreach( $route->getVariables() as $v ){
//                    $emptyVars[ $v ] = $v;
//                }
//                $url = $this->generateUrl( $name, $emptyVars );
//                $availableApiRoutes[] = ["name" => $name, "url" => $url, "variables" => $route->getVariables()];
//            }
//      }
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
      //  var_dump($routes); die('comment');
        return $this->render('AppBundle:Dashboard:index.html.twig', array(
            'routes' => $routeNames
        ));
    }

}