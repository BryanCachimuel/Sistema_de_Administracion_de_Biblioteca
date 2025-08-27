<?php  
/**
 * 
 */
class UsuariosModelo extends Llaves
{
	protected $db="";
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function alta($data='') {
	  if(empty($data)) return false;
        $sql = "INSERT INTO usuarios VALUES(0,"; //1. id 
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

	public function bajaLogica($id){
		$sql = "UPDATE usuarios SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
		return $this->db->queryNoSelect($sql);
	}

	public function estadoActualizar($id, $estado) {
		$salida = false;
	    if (!empty("id")) {
	     $sql = "UPDATE usuarios SET "; 
	     $sql.= "estado='".$estado."', ";	
	     $sql.= "modifica_dt=(NOW()) ";
	     $sql.= "WHERE id=".$id;
	     //Enviamos a la base de datos
	     $salida = $this->db->queryNoSelect($sql);
	    }
	    return $salida;
	}

	public function getUsuarioId($id='')
	{
		if(empty($id)) return false;
		$sql = "SELECT * FROM usuarios WHERE id='".$id."'";
		return $this->db->query($sql);
	}

	public function getNumRegistros()
	{
		//
		$sql = "SELECT COUNT(*) FROM usuarios WHERE baja=0";
		$salida = $this->db->query($sql);
		return $salida["COUNT(*)"];
	}


	public function getTabla($inicio=1, $tamano=0) {
		$sql = "SELECT u.id, tu.tipoUsuario, eu.estado, ";
		$sql.= "CONCAT(u.apellidoPaterno,' ',u.apellidoMaterno,', ',u.nombre) as nombre ";
		$sql.= "FROM usuarios as u, tipousuarios as tu, estadosusuario as eu ";
		$sql.= "WHERE u.baja=0 AND ";
		$sql.= "u.idTipoUsuario=tu.id AND ";
		$sql.= "u.estado=eu.id";
		if ($tamano>0) {
			$sql.= " LIMIT ".$inicio.", ".$tamano;
		}
		return $this->db->querySelect($sql);
	}


	public function modificar($data) {
		$salida = false;
	    if (!empty($data["id"])) {
	     $sql = "UPDATE usuarios SET "; 
	     $sql.= "idTipoUsuario='".$data['idTipoUsuario']."', ";
	     $sql.= "correo='".$data['correo']."', ";
	     $sql.= "nombre='".$data['nombre']."', ";
	     $sql.= "clave='".$data['clave']."', ";
	     $sql.= "apellidoPaterno='".$data['apellidoPaterno']."', ";
	     $sql.= "apellidoMaterno='".$data['apellidoMaterno']."', ";
		 $sql.= "genero='".$data['genero']."', ";
	     $sql.= "telefono='".$data['telefono']."', ";
	     $sql.= "fechaNacimiento='".$data['fechaNacimiento']."', ";
	     $sql.= "estado='".$data['estado']."', ";	
	     $sql.= "modifica_dt=(NOW()) ";
	     $sql.= "WHERE id=".$data['id'];
	     //Enviamos a la base de datos
	     $salida = $this->db->queryNoSelect($sql);
	    }
	    return $salida;
	}
}
?>