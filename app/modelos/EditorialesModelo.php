<?php  
/**
 * 
 */
class EditorialesModelo extends Llaves
{
	protected $db="";
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function alta($data='')
	{
	   $sql = "INSERT INTO editoriales VALUES(0,"; //1. id 
	   $sql.= "'".$data['idPais']."', "; //2. país
	   $sql.= "'".$data['editorial']."', "; //3. editorial
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
		$sql = "UPDATE editoriales SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
		return $this->db->queryNoSelect($sql);
	}

	public function getId($id='')
	{
		if(empty($id)) return false;
		$sql = "SELECT * FROM editoriales WHERE id='".$id."'";
		return $this->db->query($sql);
	}

	public function getNumRegistros()
	{
		//
		$sql = "SELECT COUNT(*) FROM editoriales WHERE baja=0";
		$salida = $this->db->query($sql);
		return $salida["COUNT(*)"];
	}

	public function getPaises()
	{
		//
		$sql = "SELECT id, pais ";
		$sql.= "FROM paises WHERE baja=0 ";
		$sql.= "ORDER BY pais";
		return $this->db->querySelect($sql);
	}

	public function getTabla($inicio=1, $tamano=0)
	{
		$sql = "SELECT e.id, p.pais, e.editorial ";
		$sql.= "FROM editoriales as e, paises as p ";
		$sql.= "WHERE e.baja=0 AND ";
		$sql.= "e.idPais=p.id ";
		if ($tamano>0) {
			$sql.= " LIMIT ".$inicio.", ".$tamano;
		}
		return $this->db->querySelect($sql);
	}

	public function getIntegridadReferencial($id)
	{
		//
		$ir_array = [0];
		$sql = "SELECT COUNT(*) FROM copias WHERE baja=0 AND idEditorial=".$id;
		$salida = $this->db->query($sql);
		$ir_array[0] = $salida["COUNT(*)"];
		return $ir_array;
	}

	public function modificar($data)
	{
		$salida = false;
	    if (!empty($data["id"])) {
	     $sql = "UPDATE editoriales SET "; 
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