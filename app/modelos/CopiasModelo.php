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

	public function alta($data='')
	{
	   if(empty($data)) return false;
	   $sql = "INSERT INTO copias VALUES(0,"; //1. id 
	   $sql.= "'".$data['idLibro']."', "; //2. idLibro
	   $sql.= "'".$data['idEditorial']."', ";  //3. idEditorial
	   $sql.= "'".$data['idPais']."', ";    	//4. idPais
	   $sql.= "'".$data['clave']."', "; //5. clave
	   $sql.= "'".$data['copia']."', "; //6. copia
	   $sql.= "'".$data['anio']."', ";    	//7. año
	   $sql.= "'".$data['isdn']."', "; //8. isdn
	   $sql.= "'".$data['edicion']."', "; //9. Edicion   
	   $sql.= "'".$data['paginas']."', "; //10. Paginas   
	   $sql.= "'".$data['estado']."', ";    	//11. estado
	   //
	   $sql.= "'0', ";                          //12. baja lógica
	   $sql.= "NOW(),";                         //13. fecha alta-creado
	   $sql.= "'', ";                           //14. fecha baja
	   $sql.= "'')";                            //15. fecha modificado                        
	   return $this->db->queryNoSelect($sql);
	}

	public function bajaLogica($id){
		$sql = "UPDATE copias SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
		return $this->db->queryNoSelect($sql);
	}

	public function getId($id='')
	{
		if(empty($id)) return false;
		$sql = "SELECT * FROM copias WHERE id='".$id."'";
		return $this->db->query($sql);
	}

	public function getNumRegistros()
	{
		//
		$sql = "SELECT COUNT(*) FROM copias WHERE baja=0";
		$salida = $this->db->query($sql);
		return $salida["COUNT(*)"];
	}

	public function getTabla($inicio=1, $tamano=0)
	{
		$sql = "SELECT c.id, c.clave, ";
		$sql.= "l.titulo, c.edicion, c.copia, ec.estadoCopia, c.estado ";
		$sql.= "FROM copias as c, libros as l, estadosCopias as ec ";
		$sql.= "WHERE c.baja=0 AND ";
		$sql.= "c.idLibro=l.id AND ";
		$sql.= "c.estado=ec.id ";
		if ($tamano>0) {
			$sql.= " LIMIT ".$inicio.", ".$tamano;
		}
		return $this->db->querySelect($sql);
	}

	public function getLibros()
	{
		//
		$sql = "SELECT id, titulo ";
		$sql.= "FROM libros WHERE baja=0 ";
		$sql.= "ORDER BY titulo";
		return $this->db->querySelect($sql);
	}

	public function getEditoriales()
	{
		//
		$sql = "SELECT id, editorial ";
		$sql.= "FROM editoriales WHERE baja=0 ";
		$sql.= "ORDER BY editorial";
		return $this->db->querySelect($sql);
	}

	public function getIntegridadReferencial($id)
	{
		//
		$ir_array = [0];
		$sql = "SELECT COUNT(*) FROM prestamos WHERE baja=0 AND idCopia=".$id;
		$salida = $this->db->query($sql);
		$ir_array[0] = $salida["COUNT(*)"];
		// 
		return $ir_array;
	}

	public function modificar($data)
	{
		$salida = false;
	    if (!empty($data["id"])) {
	     $sql = "UPDATE copias SET "; 
	     $sql.= "idLibro='".$data['idLibro']."', ";
	     $sql.= "idEditorial='".$data['idEditorial']."', ";
	     $sql.= "idPais='".$data['idPais']."', ";
	     $sql.= "clave='".$data['clave']."', ";
	     $sql.= "copia='".$data['copia']."', ";
	     $sql.= "anio='".$data['anio']."', ";
	     $sql.= "isdn='".$data['isdn']."', ";
	     $sql.= "edicion='".$data['edicion']."', ";
	     $sql.= "paginas='".$data['paginas']."', ";
	     $sql.= "estado='".$data['estado']."', ";	
	     //
	     $sql.= "modifica_dt=(NOW()) ";
	     $sql.= "WHERE id=".$data['id'];
	     //Enviamos a la base de datos
	     $salida = $this->db->queryNoSelect($sql);
	    }
	    return $salida;
	}

}

?>