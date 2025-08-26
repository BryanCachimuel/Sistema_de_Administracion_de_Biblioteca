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

	public function alta($data='')
	{
	   $sql = "INSERT INTO usuarios VALUES(0,"; //1. id 
	   $sql.= "'".$data['editorial']."', "; //3. editorial
	   $sql.= "'".$data['idPais']."', "; //2. país
	   $sql.= "'".$data['pagina']."', "; //4. pagina web
	   $sql.= "'".$data['estado']."', "; //5. estado
	   //
	   $sql.= "0, ";                   //6. baja
	   $sql.= "NOW(), ";               //7. fecha alta
	   $sql.= "'', ";                  //8. fecha baja 
	   $sql.= "'')";                   //9. fecha cambio
	   return $this->db->queryNoSelect($sql);
	}

	public function bajaLogica($id){
		$sql = "UPDATE usuarios SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
		return $this->db->queryNoSelect($sql);
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


	public function modificar($data)
	{
		$salida = false;
	    if (!empty($data["id"])) {
	     $sql = "UPDATE usuarios SET "; 
	     $sql.= "idPais='".$data['idPais']."', ";
	     $sql.= "editorial='".$data['editorial']."', ";
	     $sql.= "pagina='".$data['pagina']."', ";
	     $sql.= "modifica_dt=(NOW()) ";
	     $sql.= "WHERE id=".$data['id'];
	     //Enviamos a la base de datos
	     $salida = $this->db->queryNoSelect($sql);
	    }
	    return $salida;
	}
}
?>