<?php

namespace Framework\Twig;

use Framework\Router;
use Framework\Session;

class AppExtension extends \Twig_Extension
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;


    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('path', [$this, 'getUri']),
            new \Twig_SimpleFunction('sessionGet', [$this, 'sessionGet'])
        );
    }

    public function sessionGet($name)
    {

        return Session::get($name);
    }

    public function getUri($name, array $parameters = [])
    {

        return $this->router->generateUrl($name, $parameters);
    }
}