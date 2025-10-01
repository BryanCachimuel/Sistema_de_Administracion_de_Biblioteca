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
        $sql = "SELECT id, nombre, apellidoPaterno, apellidoMaterno, clave, correo, estado FROM usuarios WHERE correo='".$usuario."'";
        return $this->db->query($sql);
    }
}