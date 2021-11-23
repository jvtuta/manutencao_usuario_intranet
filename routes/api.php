<?php
require __DIR__."/../bootstrap/Route.php";
require __DIR__."/../api/Controllers/UserController.php";

new Route('user-save', function(){
    return UserController::save();
}, 'v1/user-save');

new Route('users', function() {
    return UserController::index();
}, 'v1/users');


?>