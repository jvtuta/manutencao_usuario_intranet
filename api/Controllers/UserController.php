<?php 
require __DIR__.'/../Models/User.php';

class UserController {
    
    public static function index()
    {
        $usuario = new User();
        print_r($usuario->all());
    }
    
    public static function save($request)
    {
        $usuario = new User();
        $usuario->setValues('nome', $request['nome'] );
        $usuario->setValues('cdcon', $request['cdcon']);
        $usuario->setValues('cdfun', $request['cdfun']);
        $usuario->setValues('usuario', $request['usuario']);
        $usuario->setValues('senha', sha1($request['senha']));
        $usuario->setValues('nivel', $request['nivel']);
        $usuario->setValues('loja', $request['loja']);
        $usuario->setValues('ativo', 1);
        
        $usuario->save();
    }

    public static function update($id, $column, $data) 
    {
        $usuario = new User();
        if($column === 'senha') {
            $column = 'senhapadrao';
            $data = 1;
        }
        return $usuario->update($id, $column, $data);
    }

    
}
?>