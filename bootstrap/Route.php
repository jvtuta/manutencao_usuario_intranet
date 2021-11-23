<?php


class Route {
    public $name;
    protected $controller, $path, $routes;
    
    public function __construct($routeName, $controller, $path)
    {
        $this->name = $routeName;
        $this->path = $path;
        $this->match(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $controller);
    }
    
    protected function match($actual, $controller) 
    {

        if($this->path === $actual ) {
            $controller($_REQUEST);
        }
    }
}


?>