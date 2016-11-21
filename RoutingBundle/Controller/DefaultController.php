<?php

namespace Administration\RoutingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Route;

/**
 * Class DefaultController
 * @package Administration\RoutingBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * Methode qui retourne la list des routes
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function routerAction()
    {
        $router = $this->get('router');
        $routes = $router->getRouteCollection();


        foreach ($routes as $route) {
            $this->convertController($route);
        }

        return $this->render('RoutingBundle:Default:route.html.twig', array(
            'routes' => $routes
        ));
    }

    /**
     * @param Route $route
     */
    private function convertController(Route $route)
    {
        $nameParser = $this->get('controller_name_converter');
        if ($route->hasDefault('_controller')) {
            try {
                $route->setDefault('_controller', $nameParser->build($route->getDefault('_controller')));
            } catch (\InvalidArgumentException $e) {

            }
        }
    }


}
