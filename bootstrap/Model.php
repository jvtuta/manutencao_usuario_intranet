<?php

require __DIR__.'/../database/config.php';

abstract class Model extends Database 
{
    protected $columns, $data;
    protected $columnsAndData = [];

    public function __construct() 
    {
        if(!$this->table) {
            throw new Exception('Atributo tabela não foi setado!');
        }
    }

    public function getColumn()
    {
        return $this->columns;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setValues($key, $value) 
    {

        $this->columnsAndData[$key] = $value;

        $this->columns = array_keys($this->columnsAndData);
        $this->data = array_values($this->columnsAndData);

    }   

    public function all() 
    {
        
        return $this->query('select * from '.$this->table)->fetch_all();
    }

    protected function insert()
    {
        $columns = implode(',', $this->columns);
        
        $data = implode("','", $this->data);

        $queryString = "insert into ".
            $this->table."(".$columns.") 
            values('".
                $data
            ."')";

        try {
            mysqli_report(MYSQLI_REPORT_ALL);
            $this->query($queryString);
            
        } catch ( Exception $error ){
            echo $error->getMessage();
        }
        
    }

    public function update($id, $column, $data)
    {   

        $queryString = "update ". 
            $this->table ." set ". 
            $column . " = '" . $data. 
            "' where id = ". $id ;
        try {
            mysqli_report(MYSQLI_REPORT_ALL);
            $this->query($queryString);
        } catch (Exception $err) {
            echo $err->getMessage();
        }
        
    }

    public function save() 
    {
        return $this->insert();
    }

    
}

