<?php 
require_once "dbConfig.php";

//get['codigo_func_fcerta'],get['login_fcerta'],get['nivel'],get['nome_completo'],get['numero_loja'];
//cdcon,cfun,nome,usuario,senha,nivel,loja,ativo
$usuario = [$_GET['numero_loja'],$_GET['codigo_func_fcerta'],$_GET['nome_completo'],$_GET['login_fcerta'],$_GET['nivel']];
Usuario::insert(Db::getDb(),$usuario);

?>