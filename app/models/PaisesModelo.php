<?php

class PaisesModelo extends Llaves{

    protected $db = "";

    function __construct() {
        $this->db = new MySQLdb();
    }

    public function alta($data='') {

    }

    public function bajaLogica($id='') {

    }

    public function getPaisId($id='') {
		if(empty($id)) return false;
		$sql = "SELECT * FROM paises WHERE id='".$id."'";
		return $this->db->query($sql);
	}

    public function getTabla($inicio = 1, $tamano = 0) {
        $sql = "SELECT id,pais ";
        $sql .= "FROM paises ";
        $sql .= "WHERE baja=0";
        if($tamano>0) {
            $sql .= " LIMIT ".$inicio.", ".$tamano;
        }
        return $this->db->querySelect($sql);
    }

    public function modificar($data){

		if(empty($data)) return false;
        $sql = "INSERT INTO paises VALUES(0,"; //1. id 
        $sql.= "'".$data['idTipoUsuario']."', "; //2. tipo
        $sql.= "'".$data['nombre']."', ";    	//3. nombre
        $sql.= "'".$data['apellidoPaterno']."', "; //4. apellido paterno
        $sql.= "'".$data['apellidoMaterno']."', "; //5. Apellido Materno	   
        $sql.= "'".$data['correo']."', ";    	//6. correo
        $sql.= "'".$data['clave']."', ";     	//7. clave de acceso
        $sql.= "'".$data['genero']."', ";    	//8. genero
        $sql.= "'".$data['telefono']."', ";    	//9. telefono
        $sql.= "'".$data['fechaNacimiento']."', ";  //10. fecha nacimieto
        $sql.= "'".$data['estado']."', ";    	//11. estado
        //
        $sql.= "'0', ";                          //12. baja lógica
        $sql.= "'', ";                           //13. fecha login
        $sql.= "NOW(),";                         //14. fecha alta-creado
        $sql.= "'', ";                           //15. fecha baja
        $sql.= "'')";                            //16. fecha modificado                        
        return $this->db->queryNoSelect($sql);
	 }

}