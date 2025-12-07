<?php  
/**
 * 
 */
class PrestamosModelo extends Llaves
{
	protected $db="";
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function alta($data='')
	{
	   if(empty($data)) return false;
	   $sql = "INSERT INTO prestamos VALUES(0,"; //1. id 
	   $sql.= "'".$data['idCopia']."', "; //2. idCopia
	   $sql.= "'".$data['idUsuario']."', "; //3. idUsuario	
	   $sql.= "'".$data['prestamo']."', ";   //4. prestamo 
	   $sql.= "'".$data['devolucion']."', ";   //5. devolucion
	   $sql.= "'".COPIA_PRESTADO."', ";  //6. estado
	   //
	   $sql.= "'0', ";                  //7. baja lógica
	   $sql.= "NOW(),";                 //8. alta-creado
	   $sql.= "'', ";                   //9. baja
	   $sql.= "'')"; //10. modifica 
	   return $this->db->queryNoSelect($sql);
	}

	public function getId($id='')
	{
		if(empty($id)) return false;
		$sql = "SELECT * FROM prestamos WHERE id='".$id."'";
		return $this->db->query($sql);
	}

	public function getNumRegistros()
	{
		//
		$sql = "SELECT COUNT(*) FROM prestamos WHERE baja=0";
		$salida = $this->db->query($sql);
		return $salida["COUNT(*)"];
	}

	public function getTabla($inicio=1, $tamano=0)
	{
		$sql = "SELECT p.id, c.clave, l.titulo, ";
		$sql.= "CONCAT(u.nombre,' ',u.apellidoPaterno) as usuario,";
		$sql.= "DATE_FORMAT(p.prestamo_dt, '%d-%m-%Y') as prestamo, ";
		$sql.= "DATE_FORMAT(p.devolucion_dt, '%d-%m-%Y') as devolucion ";
		$sql.= "FROM prestamos as p, usuarios as u, libros as l, copias as c ";
		$sql.= "WHERE p.baja=0 AND ";
		$sql.= "p.idCopia=c.id AND ";
		$sql.= "p.idUsuario=u.id AND ";
		$sql.= "p.estado=".COPIA_PRESTADO." AND ";
		$sql.= "c.idLibro=l.id ";
		$sql.= "ORDER BY p.devolucion_dt DESC ";
		if ($tamano>0) {
			$sql.= " LIMIT ".$inicio.", ".$tamano;
		}
		return $this->db->querySelect($sql);
	}

	public function getUsuarios()
	{
		//
		$sql = "SELECT id, CONCAT(apellidoPaterno,' ',apellidoMaterno,', ',nombre) as usuario ";
		$sql.= "FROM usuarios WHERE baja=0 AND ";
		$sql.= "estado=".USUARIO_ACTIVO;
		$sql.= " ORDER BY usuario";
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

	public function getCopiasDisponibles()
	{
		//
		$sql = "SELECT c.id, CONCAT(c.clave,' ',l.titulo) as copia  ";
		$sql.= "FROM copias as c, libros as l ";
		$sql.= "WHERE c.baja=0 AND ";
		$sql.= "c.idLibro=l.id AND ";
		$sql.= "c.estado=".COPIA_DISPONIBLE." ";
		$sql.= "ORDER BY c.clave";
		return $this->db->querySelect($sql);
	}

	public function copiasModificar($idCopia='')
	{
		$salida = false;
	    if (!empty($idCopia)) {
	     $sql = "UPDATE copias SET ";
	     $sql.= "estado='".COPIA_PRESTADO."', ";
	     $sql.= "modifica_dt=(NOW()) ";
	     $sql.= "WHERE id=".$idCopia;
	     $salida = $this->db->queryNoSelect($sql);
	    }
	    return $salida;
	}

	public function copiasDevolver($data)
	{
		$salida = false;
	    if (!empty($data)) {
	     $sql = "UPDATE copias SET ";
	     $sql.= "estado='".$data["idEstado"]."', ";
	     $sql.= "modifica_dt=(NOW()) ";
	     $sql.= "WHERE id=".$data["idCopia"];
	     $salida = $this->db->queryNoSelect($sql);
	    }
	    return $salida;
	}

	public function prestamosDevolver($data)
	{
		$sql = "UPDATE prestamos SET ";
		$sql.= "baja=1, ";
		$sql.= "baja_dt=(NOW()) ";
		$sql.= "WHERE idCopia=".$data["idCopia"]." AND ";
		$sql.= "estado=".COPIA_PRESTADO." AND ";
		$sql.= "baja=0";
	    return $this->db->queryNoSelect($sql);
	}

	public function getEstadoCopia($copia,$numCopia)
	{
		//
		$sql = "SELECT id, estado ";
		$sql.= "FROM copias WHERE clave='".$copia."' AND ";
		$sql.= "copia='".$numCopia."'";
		return $this->db->query($sql);
	}
}

?>