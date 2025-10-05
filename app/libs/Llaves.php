<?php  

class Llaves {
	
	function __construct() {
	}

	public function getCatalogo($tipo, $ordenar=""){
		$sql = "SELECT * FROM ".$tipo;
		if(!empty($ordenar)){
			$sql.=" ORDER BY ".$ordenar;
		}
	    $data = $this->db->querySelect($sql);
	    return $data;
	}

	public function buscarCorreo($usuario='') {
        if(empty($usuario)) return false;
        $sql = "SELECT id, nombre, apellidoPaterno, apellidoMaterno, clave, correo, estado, idTipoUsuario FROM usuarios WHERE correo='".$usuario."'";
        return $this->db->query($sql);
    }

	public function setUsuario($id, $nombre, $apellidoPaterno, $apellidoMaterno, $clave) {
		$sql = "UPDATE usuarios SET ";
		$sql.= "nombre='".$nombre."', ";
		$sql.= "apellidoMaterno='".$apellidoMaterno."', ";
		$sql.= "apellidoPaterno='".$apellidoPaterno."' ";
		if ($clave!="") {
			$clave = hash_hmac("sha512", $clave, CLAVE);
			$sql.= ", clave='".$clave."' ";
		}
		$sql.= "WHERE id=".$id;
		return $this->db->queryNoSelect($sql);
	}

	

}