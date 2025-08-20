<?php

class EditorialesModelo extends Llaves{

    protected $db = "";

    function __construct() {
        $this->db = new MySQLdb();
    }

    public function alta($data='') {
       $sql = "INSERT INTO editoriales VALUES(0,"; //1. id 
	   $sql.= "'".$data['idCategoria']."', "; //2. categoria
       $sql.= "'".$data['tema']."', "; //3. clave
	   //
	   $sql.= "0, ";                   //4. baja
	   $sql.= "NOW(), ";               //5. fecha alta
	   $sql.= "'', ";                  //6. fecha baja 
	   $sql.= "'')";                   //7. fecha cambio
	   return $this->db->queryNoSelect($sql);

    }

    public function bajaLogica($id) {
        $sql = "UPDATE editoriales SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
        return $this->db->queryNoSelect($sql);
    }

    public function getEditorialId($id='') {
		if(empty($id)) return false;
		$sql = "SELECT * FROM editoriales WHERE id='".$id."'";
		return $this->db->query($sql);
	}

    public function getNumRegistros() {
        $sql = "SELECT COUNT(*) FROM editoriales WHERE baja=0";
        $salida = $this->db->query($sql);
        return $salida["COUNT(*)"];
    }

    public function getPaises() {
        $sql = "SELECT id, pais ";
        $sql .= "FROM paises WHERE baja=0 ";
        $sql .= "ORDER BY pais";
        return $this->db->querySelect($sql);
    }

    public function getTabla($inicio=1, $tamano=0) {
        $sql = "SELECT e.id, p.pais, e.editorial ";
        $sql .= "FROM editoriales as e, paises as p ";
        $sql .= "WHERE e.baja=0 AND ";
        $sql .= "e.idPais=p.id ";
        if($tamano>0) {
            $sql .= " LIMIT ".$inicio.", ".$tamano;
        }
        return $this->db->querySelect($sql);
    }

    public function modificar($data){
        $salida = false;
        if(!empty($data["id"])) {
            $sql = "UPDATE editoriales SET ";
            $sql .= "idCategoria='".$data['idCategoria']."', ";
            $sql .= "tema='".$data['tema']."', ";
            $sql .= "modifica_dt=(NOW()) ";
            $sql .= "WHERE id=".$data['id'];
            // envio hacia la base de datos
            $salida = $this->db->queryNoSelect($sql);
        }
        return $salida;
	 }

}