<?php 
require __DIR__.'/../Models/User.php';

class UserController {
    
    public static function save()
    {
        $usuario = new User();
        $usuario->setValues('nome', 'teste');
        $usuario->setValues('cdcon', 3342);
        $usuario->setValues('login', 'teste');
        $usuario->setValues('usuario', 'teste');
        $usuario->setValues('senha', 'teste');
        $usuario->setValues('nivel', 2);
        $usuario->setValues('loja', 1);
        
        $usuario->save();
    }

    public static function index()
    {
        $usuario = new User();
        print_r($usuario->all());
    }
}
?>