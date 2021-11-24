<?php 
require __DIR__.'/../Models/User.php';

class UserController {
    
    public static function index()
    {
        $usuario = new User();
        echo json_encode($usuario->all());
    }
    
    public static function save($request)
    {
        $usuario = new User();
        $usuario->setValues('nome', $request['name'] );
        $usuario->setValues('cdcon', $request['cdcon']);
        $usuario->setValues('cdfun', $request['cdfun']);
        $usuario->setValues('usuario', $request['usuario']);
        $usuario->setValues('senha', sha1('1234'));
        $usuario->setValues('nivel', $request['nivel']);
        $usuario->setValues('loja', $request['cdcon']);
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