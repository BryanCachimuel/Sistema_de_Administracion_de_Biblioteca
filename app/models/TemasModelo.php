<?php

class TemasModelo extends Llaves{

    protected $db = "";

    function __construct() {
        $this->db = new MySQLdb();
    }

    public function alta($data='') {
       $sql = "INSERT INTO temas VALUES(0,"; //1. id 
	   $sql.= "'".$data['categoria']."', "; //2. categoria
       $sql.= "'".$data['clave']."', "; //3. clave
	   //
	   $sql.= "0, ";                   //4. baja
	   $sql.= "NOW(), ";               //5. fecha alta
	   $sql.= "'', ";                  //6. fecha baja 
	   $sql.= "'')";                   //7. fecha cambio
	   return $this->db->queryNoSelect($sql);

    }

    public function bajaLogica($id) {
        $sql = "UPDATE temas SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
        return $this->db->queryNoSelect($sql);
    }

    public function getTemasId($id='') {
		if(empty($id)) return false;
		$sql = "SELECT * FROM temas WHERE id='".$id."'";
		return $this->db->query($sql);
	}

    public function getNumRegistros() {
        $sql = "SELECT COUNT(*) FROM temas WHERE baja=0";
        $salida = $this->db->query($sql);
        return $salida["COUNT(*)"];
    }

    public function getTabla($inicio=1, $tamano=0) {
        $sql = "SELECT t.id, c.categoria, t.tema ";
        $sql .= "FROM temas as t, categorias as c ";
        $sql .= "WHERE t.baja=0 AND ";
        $sql .= "t.idCategoria=c.id ";
        $sql .= "ORDER BY c.clave";
        if($tamano>0) {
            $sql .= " LIMIT ".$inicio.", ".$tamano;
        }
        return $this->db->querySelect($sql);
    }

    public function modificar($data){
        $salida = false;
        if(!empty($data["id"])) {
            $sql = "UPDATE temas SET ";
            $sql .= "categoria='".$data['categoria']."', ";
            $sql .= "clave='".$data['clave']."', ";
            $sql .= "modifica_dt=(NOW()) ";
            $sql .= "WHERE id=".$data['id'];
            // envio hacia la base de datos
            $salida = $this->db->queryNoSelect($sql);
        }
        return $salida;
	 }

}