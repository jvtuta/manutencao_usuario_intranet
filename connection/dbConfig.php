<?php
class Db {
    public static function getDb() {
        try {
            $conn = mysqli_connect("localhost","root","<senha>","<nome_bd>");
           
            return $conn;
        } catch(Exception $e) {
            throw $e;
        }
    }
}

class Usuario {
    public static function all($db) {
        $query = 'select * from usuarios';
        $query = $db->query($query)->fetch_all();
        return $query;
    }
//$values[0],$values[1],$values[2],$values[3],'".SHA1('1234')."',$values[4],$values[0]
    public static function insert(mysqli $db, Array $values) {
        $query = "insert into usuarios(cdcon,cdfun,nome,usuario,senha,nivel,loja) 
        values(".$values[0].",".$values[1].",'".$values[2]."','".$values[3]."',"."SHA1('1234')".",".$values[4].",".$values[0].")";
        $db->query($query);
        //$erro = [$db->error,'teste',$values];
        //echo json_encode($erro);
    }

   public static function update(mysqli $db, $coluna, $id, $dado) {
       if($coluna == 'senha') {
            $query = "update usuarios set senha = SHA1('1234') where id=".$id;
            $db->query($query);
            $query = "update usuarios set senhapadrao = 1 where id=".$id;
            $db->query($query);
            return;
       }
       if($coluna == 'cdcon') {
           $query = "update usuarios set cdcon = ".$dado.", loja = ".$dado." where id=".$id;
       }  else {
            $query = "update usuarios set ". $coluna ." =
            '". $dado ."' where id =". $id;
        };
        $db->query($query);
        return;
        //$erro = [$db->error,'erro ao atualizar registros'];
        //echo json_encode($erro);
   } 

}
?>
