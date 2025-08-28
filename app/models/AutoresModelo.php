<?php  
/**
 * 
 */
class AutoresModelo extends Llaves
{
	protected $db="";
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function alta($data='') {
	   if(empty($data)) return false;
	   $sql = "INSERT INTO autores VALUES(0,"; //1. id 
	   $sql.= "'".$data['idPais']."', "; //2. país
	   $sql.= "'".$data['idGenero']."', ";  //3. Genero
	   $sql.= "'".$data['nombre']."', ";    	//4. nombre
	   $sql.= "'".$data['apellidoPaterno']."', "; //5. apellido paterno
	   $sql.= "'".$data['apellidoMaterno']."', "; //6. Apellido Materno	   
	   $sql.= "'".$data['estado']."', ";    	//7. estado
	   //
	   $sql.= "'0', ";                          //8. baja lógica
	   $sql.= "NOW(),";                         //9. fecha alta-creado
	   $sql.= "'', ";                           //10. fecha baja
	   $sql.= "'')";                            //11. fecha modificado                        
	   return $this->db->queryNoSelect($sql);
	}

	public function bajaLogica($id){
		$sql = "UPDATE autores SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
		return $this->db->queryNoSelect($sql);
	}

	public function getAutorId($id='') {
		if(empty($id)) return false;
		$sql = "SELECT * FROM autores WHERE id='".$id."'";
		return $this->db->query($sql);
	}

	public function getNumRegistros() {
		$sql = "SELECT COUNT(*) FROM autores WHERE baja=0";
		$salida = $this->db->query($sql);
		return $salida["COUNT(*)"];
	}


	public function getTabla($inicio=1, $tamano=0) {
		$sql = "SELECT a.id, p.pais, ";
		$sql.= "a.apellidoPaterno,a.apellidoMaterno,a.nombre ";
		$sql.= "FROM autores as a, paises as p ";
		$sql.= "WHERE a.baja=0 AND ";
		$sql.= "a.idPais=p.id";
		if ($tamano>0) {
			$sql.= " LIMIT ".$inicio.", ".$tamano;
		}
		return $this->db->querySelect($sql);
	}


	public function modificar($data) {
		$salida = false;
	    if (!empty($data["id"])) {
	     $sql = "UPDATE autores SET "; 
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