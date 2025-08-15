<?php

class IdiomasModelo extends Llaves{

    protected $db = "";

    function __construct() {
        $this->db = new MySQLdb();
    }

    public function alta($data='') {
       $sql = "INSERT INTO idiomas VALUES(0,"; //1. id 
	   $sql.= "'".$data['idioma']."', "; //2. país
	   //
	   $sql.= "0, ";                   //3. baja
	   $sql.= "NOW(), ";               //4. fecha alta
	   $sql.= "'', ";                  //. fecha baja 
	   $sql.= "'')";                   //8. fecha cambio
	   return $this->db->queryNoSelect($sql);

    }

    public function bajaLogica($id) {
        $sql = "UPDATE idiomas SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
        return $this->db->queryNoSelect($sql);
    }

    public function getIdiomaId($id='') {
		if(empty($id)) return false;
		$sql = "SELECT * FROM idiomas WHERE id='".$id."'";
		return $this->db->query($sql);
	}

    public function getNumRegistros() {
        $sql = "SELECT COUNT(*) FROM idiomas WHERE baja=0";
        $salida = $this->db->query($sql);
        return $salida["COUNT(*)"];
    }

    public function getTabla($inicio=1, $tamano=0) {
        $sql = "SELECT id,idioma ";
        $sql .= "FROM idiomas ";
        $sql .= "WHERE baja=0";
        if($tamano>0) {
            $sql .= " LIMIT ".$inicio.", ".$tamano;
        }
        return $this->db->querySelect($sql);
    }

    public function modificar($data){
        $salida = false;
        if(!empty($data["id"])) {
            $sql = "UPDATE idiomas SET ";
            $sql .= "idioma='".$data['idioma']."', ";
            $sql .= "modifica_dt=(NOW()) ";
            $sql .= "WHERE id=".$data['id'];
            // envio hacia la base de datos
            $salida = $this->db->queryNoSelect($sql);
        }
        return $salida;
	 }

}