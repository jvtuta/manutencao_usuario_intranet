<?php
require __DIR__."/../bootstrap/Route.php";
require __DIR__."/../api/Controllers/UserController.php";

new Route('user-save', function(){
    return UserController::save($_REQUEST);
}, 'v1/user-save');

new Route('users', function() {
    return UserController::index();
}, 'v1/users');

new Route('user-update', function($params) {

    return UserController::update(
        $params['id'],
        $params['column'],
        $params['data']
    );  
},'v1/user-update')


?>