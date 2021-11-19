<?php
require "../bootstrap/Route.php";

class Routes extends Route  {
    // Rotas
      
    protected function match($actual, $controller) 
    {
        
        if($this->path === $actual ) {
            $controller();
        }
    }
};

new Routes('user', function(){
    echo 'teste';
}, 'user');

?>