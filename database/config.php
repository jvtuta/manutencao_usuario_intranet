<?php

abstract class Database {
    public function __construct()
    {
        $this->db();
    }

    protected function db() 
    {
        
        define('username', 'root');
        define('hostname', 'localhost');
        define('password', 'Safepcnmdmd1976');
        define('database', 'nivelacesso');

        try {   
            $conn = mysqli_connect(hostname, username, password, database);
            
            return $conn;

        } catch(Exception $err) {
            throw $err->getMessage();
        }
    }

    protected function query($q) 
    {
        return $this->db->query($q);
    }
}

?>