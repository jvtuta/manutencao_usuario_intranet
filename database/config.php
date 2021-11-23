<?php

abstract class Database {

    protected function conn() 
    {
        
        define('username', 'root');
        define('hostname', '127.0.0.1');
        define('password', 'root');
        define('database', 'nivelacesso');

        try {   
            
            $conn = new mysqli(
                hostname, 
                username, 
                password, 
                database
            );
            if(!$conn) {
                die('Não foi possível concetar');
            }
            return $conn;
        } catch(Exception $err) {
            throw $err->getMessage();
        }
    }

    protected function query($q)
    {
        return $this->conn()->query($q);
    }

}

?>