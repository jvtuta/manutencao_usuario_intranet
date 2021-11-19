<?php

require '../database/config.php';

abstract class Model extends Database implements ModelInterface
{

    public function getColumn()
    {
        return $this->column;
    }
    public function getDado()
    {
        return $this->dado;
    }
    public function getId()
    {
        return $this->id;
    }

    protected function all() 
    {
        $this->query('select * from '.$this->table);
    }

    protected function insert()
    {
        $columns = implode(',', $this->columns);
        $data = implode(',', $this->data);

        $queryString = "insert into ".
            $this->table."(".$columns.") 
            . values(".$data.")";
        try {
            $this->query($queryString);
        } catch ( Exception $error ){
            echo $error->getMessage();
        }
        
    }

    protected function update($id, $data)
    {   
        $columns = implode(',', $this->column);
        $data = implode(',',$data);

        $queryString = "update ". 
            $this->table ." set ". 
            $columns . "=" . $data. 
            'where id ='. $id;
        try {
            $this->query($queryString);
        } catch (Exception $err) {
            throw $err->getMessage();
        }
        
    }

    
}

interface ModelInterface
{
    public function getColumn();
    public function getDado();
    public function getId();
}
