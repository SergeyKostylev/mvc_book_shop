<?php

namespace Framework;

use \Framework\Session;

class Router
{
    private $routes;

    private $currentRoute;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function redirect($to)
    {
        header("Location: {$this->generateUrl($to)}");
        die;
    }

    public function generateUrl($name, array $parameters = [])
    {
        $routes = $this->routes;
//dump($routes);
        foreach ($routes as $key => $route)
        {
            if ($name == $key){
                $str=$route['pattern'];

                if($parameters) {
                    $pattern = '@{[a-zA-Z]+}@';
                    preg_match_all($pattern,$str,$matches);
                    $mas=array_combine($matches[0],$parameters);
//                    dump($mas);
                    foreach ($mas as $keyy => $item){
                        $pattern = $keyy;
                        $str = str_replace($pattern,$item,$str);
//                        dump($str);
                    }
                    return $str;
                }
                return $str;
            }
        }
    }

    public function match(Request $request)
    {
        $uri = $request->getUri(); // book/213
        ;
        $routes = $this->routes;
//        dump($routes);

        foreach ($routes as $route) {
            $pattern = $route['pattern'];
            // var_dump($pattern);

            if (!empty($route['parameters'])) {
                // var_dump($route['parameters']);
                foreach ($route['parameters'] as $name => $regex) {
                    $pattern = str_replace(
                        '{' . $name . '}',
                        '(' . $regex . ')',
                        $pattern
                    );
                }
            }

            $pattern = '@^' . $pattern . '$@';

//            var_dump($pattern);

            if (preg_match($pattern, $uri, $matches)) {
                // var_dump($matches);
                // remove match by whole regexp
                array_shift($matches);
                // var_dump($matches);

                if (!empty($route['parameters'])) {
                    $result = array_combine(
                        array_keys($route['parameters']),
                        $matches
                    );

//                   dump($result);die();

                    $request->mergeGetWithArray($result);
                }
                $this->currentRoute = $route;


                    if (isset($route['access'])) {
                        $access=$route['access'];
//                        dump($access);
                        if(Session::get("{$access}") != 'ok'){

                            throw new \Exception('access denied');}


                    }



                return;
            }
        }

        throw new \Exception('Page not found', 404);
    }

    public function getCurrentController()
    {
        return $this->getCurrentRouteAttribute('controller');
    }

    public function getCurrentAction()
    {
        return $this->getCurrentRouteAttribute('action');
    }

    private function getCurrentRouteAttribute($key)
    {
        if (!$this->currentRoute) {
            return null;
        }

        return $this->currentRoute[$key];
    }
}