<?php 

abstract class Route {
    public $routeName, $route;
    protected $controller, $path, $routes;
    
    
    public function __construct($routeName, $controller, $path)
    {
        $this->routeName = $routeName;
        $this->controller = $controller;
        $this->path = parse_url($path, PHP_URL_QUERY);
    }

    
}


?>