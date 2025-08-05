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
}