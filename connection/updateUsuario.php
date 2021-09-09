<?php
    require_once "dbConfig.php";
    $json = file_get_contents('php://input');
    $res = json_decode($json);
    if(isset($res->coluna) && $res->coluna != '') {
        Usuario::update(Db::getDb(),$res->coluna,$res->id,$res->data);
    };
    //echo json_encode($res);
?>