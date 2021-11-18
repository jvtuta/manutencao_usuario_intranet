<?php

require_once '../connection/dbConfig.php';

$db = Db::getDb();
$usuarios = Usuario::all($db);

class Request {
    public static function response($data) 
    {
        echo json_encode($data);
    }
}

Request::response($usuarios);

?>