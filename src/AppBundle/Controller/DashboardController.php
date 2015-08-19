<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{

    public function indexAction()
    {
        if ($this->container->has('profiler')) {
            $this->container->get('profiler')->disable();
        }

        $dashboard = $this->get('app.dashboard');
        $this->get('order')->createOrder(1, array(array('id' => 1, 'quantity' => 1)));
        return $this->render(
                        'AppBundle:Dashboard:index.html.twig', array('items' => $dashboard->getItems())
        );
    }

}
