<?php
require "./bootstrap/autoload.php";


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
    echo 'user';
}, 'user');

new Routes('user-save', function() {
    echo 'user-save';
}, 'user-save');

new Routes('user-update', function() {
    echo 'user-update';
}, 'user-update');

?>