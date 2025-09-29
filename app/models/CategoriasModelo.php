<?php

class CategoriasModelo extends Llaves{

    protected $db = "";

    function __construct() {
        $this->db = new MySQLdb();
    }

    public function alta($data='') {
       $sql = "INSERT INTO categorias VALUES(0,"; //1. id 
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
        $sql = "UPDATE categorias SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
        return $this->db->queryNoSelect($sql);
    }

    public function getCategoriaId($id='') {
		if(empty($id)) return false;
		$sql = "SELECT * FROM categorias WHERE id='".$id."'";
		return $this->db->query($sql);
	}

    public function getNumRegistros() {
        $sql = "SELECT COUNT(*) FROM categorias WHERE baja=0";
        $salida = $this->db->query($sql);
        return $salida["COUNT(*)"];
    }

    public function getTabla($inicio=1, $tamano=0) {
        $sql = "SELECT id,clave,categoria ";
        $sql .= "FROM categorias ";
        $sql .= "WHERE baja=0 ";
        $sql .= "ORDER BY clave";
        if($tamano>0) {
            $sql .= " LIMIT ".$inicio.", ".$tamano;
        }
        return $this->db->querySelect($sql);
    }

    public function getIntegridadReferencial($id) {
        $ir_array = [0];
		$sql = "SELECT COUNT(*) FROM temas WHERE baja=0 AND idCategoria=".$id;
		$salida = $this->db->query($sql);
		$ir_array[0] = $salida["COUNT(*)"];
		return $ir_array;
    }

    public function modificar($data){
        $salida = false;
        if(!empty($data["id"])) {
            $sql = "UPDATE categorias SET ";
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