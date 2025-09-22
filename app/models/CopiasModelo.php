<?php  
/**
 * 
 */
class CopiasModelo extends Llaves
{
	protected $db="";
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function alta($data='') {
	   if(empty($data)) return false;
	   $sql = "INSERT INTO copias VALUES(0,"; //1. id 
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
		$sql = "UPDATE copias SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
		return $this->db->queryNoSelect($sql);
	}

	public function getCopiasId($id='') {
		if(empty($id)) return false;
		$sql = "SELECT * FROM copias WHERE id='".$id."'";
		return $this->db->query($sql);
	}

	public function getNumRegistros() {
		$sql = "SELECT COUNT(*) FROM copias WHERE baja=0";
		$salida = $this->db->query($sql);
		return $salida["COUNT(*)"];
	}


	public function getTabla($inicio=1, $tamano=0) {
		$sql = "SELECT c.id, c.clave, ";
		$sql.= "l.titulo,c.edicion,c.copia ";
		$sql.= "FROM copias as c, libros as l ";
		$sql.= "WHERE c.baja=0 AND ";
		$sql.= "c.idLibro=l.id";
		if ($tamano>0) {
			$sql.= " LIMIT ".$inicio.", ".$tamano;
		}
		return $this->db->querySelect($sql);
	}

	public function getLibro() {
		$sql = "SELECT id, titulo ";
		$sql.= "FROM libros WHERE baja=0 ";
		$sql.= "ORDER BY titulo";
		return $this->db->querySelect($sql);
	}

	public function getEditoriales() {
		$sql = "SELECT id, editorial ";
		$sql.= "FROM editoriales WHERE baja=0 ";
		$sql.= "ORDER BY editorial";
		return $this->db->querySelect($sql);
	}


	public function modificar($data) {
		$salida = false;
	    if (!empty($data["id"])) {
	     $sql = "UPDATE copias SET "; 
	     $sql.= "idPais='".$data['idPais']."', ";
	     $sql.= "idGenero='".$data['idGenero']."', ";
	     $sql.= "nombre='".$data['nombre']."', ";
	     $sql.= "apellidoPaterno='".$data['apellidoPaterno']."', ";
	     $sql.= "apellidoMaterno='".$data['apellidoMaterno']."', ";
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