<?php
session_start();
class Autenticacao {
    public static function handle($request) {
        if($request=='/apps/manutencao-usuario/?root=memoram') {
            $_SESSION['autenticado']=true;
        }
        return;
    }

}

?>