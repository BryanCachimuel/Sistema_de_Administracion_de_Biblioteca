<?php  
/**
 * 
 */
class LibrosModelo extends Llaves
{
	protected $db="";
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function alta($data='') {
	   if(empty($data)) return false;
	   $sql = "INSERT INTO libros VALUES(0,";   //1. id 
	   $sql.= "'".$data['idIdioma']."', ";      //2. idioma
	   $sql.= "'".$data['idTema']."', ";        //3. tema
	   $sql.= "'".$data['titulo']."', ";        //4. titulo
	   $sql.= "'".$data['estado']."', ";        //5. estado
	   $sql.= "'0', ";                          //6. baja lógica
	   $sql.= "NOW(),";                         //7. fecha alta-creado
	   $sql.= "'', ";                           //8. fecha baja
	   $sql.= "'')";                            //9. fecha modificado                        
	   return $this->db->queryNoSelect($sql);
	}

	public function bajaLogica($id){
		$sql = "UPDATE libros SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
		return $this->db->queryNoSelect($sql);
	}

	public function getLibroId($id='') {
		if(empty($id)) return false;
		$sql = "SELECT * FROM libros WHERE id='".$id."'";
		return $this->db->query($sql);
	}

	public function getNumRegistros() {
		$sql = "SELECT COUNT(*) FROM libros WHERE baja=0";
		$salida = $this->db->query($sql);
		return $salida["COUNT(*)"];
	}

	public function getTabla($inicio=1, $tamano=0) {
		$sql = "SELECT l.id, t.tema, ";
		$sql.= "l.titulo, i.idioma ";
		$sql.= "FROM libros as l, temas as t, idiomas as i ";
		$sql.= "WHERE l.baja=0 AND ";
		$sql.= "l.idTema=t.id AND ";
        $sql.= "l.idIdioma=i.id";
		if ($tamano>0) {
			$sql.= " LIMIT ".$inicio.", ".$tamano;
		}
		return $this->db->querySelect($sql);
	}

	public function modificar($data) {
		$salida = false;
	    if (!empty($data["id"])) {
	     $sql = "UPDATE libros SET "; 
	     $sql.= "idTema='".$data['idTema']."', ";
	     $sql.= "idIdioma='".$data['idIdioma']."', ";
	     $sql.= "titulo='".$data['titulo']."', ";
	     $sql.= "estado='".$data['estado']."', ";	
	     $sql.= "modifica_dt=(NOW()) ";
	     $sql.= "WHERE id=".$data['id'];
	     //Enviamos a la base de datos
	     $salida = $this->db->queryNoSelect($sql);
	    }
	    return $salida;
	}

	/* Libros - Autores */

	public function librosAutoresAlta($data='') {
		if(empty($data)) return false;
		$sql = "INSERT INTO librosAutores VALUES(0,"; //1. id 
		$sql.= "'".$data['idLibro']."', "; //2. libro
		$sql.= "'".$data['idAutor']."', "; //3. autor	   
		//
		$sql.= "'0', ";                  //4. baja lógica
		$sql.= "NOW(),";                 //5. alta-creado
		$sql.= "'', ";                   //6. baja
		$sql.= "'')"; //7. modifica                    
		return $this->db->queryNoSelect($sql);

	}

	public function librosAutoresBajaLogica($id){
		$sql = "UPDATE librosAutores SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
		return $this->db->queryNoSelect($sql);
	}

	public function getLibrosAutoresTabla($idLibro='') {
		// buscar libros de un autor
		if(empty($idLibro)) return false;
		$sql = "SELECT la.id, a.nombre, ";
		$sql.= "CONCAT(a.apellidoPaterno,' ',a.apellidoMaterno) as apellidos ";
		$sql.= "FROM librosAutores as la, autores as a ";
		$sql.= "WHERE la.idLibro=".$idLibro." AND ";
		$sql.= "la.baja=0 AND ";
		$sql.= "la.idAutor=a.id ";
		return $this->db->querySelect($sql);
	}

	public function getAutores() {
		$sql = "SELECT a.id, CONCAT(a.apellidoPaterno,' ',a.apellidoMaterno,', ',a.nombre) as autor ";
		$sql.= "FROM autores as a ";
		$sql.= "WHERE a.baja=0 ";
		$sql.= "ORDER BY autor";
		return $this->db->querySelect($sql);
	}

	public function getIdLibrosAutores($id='') {
		//Busca un registro de librosAutores
		if(empty($id)) return false;
		$sql = "SELECT la.id, la.idAutor, la.idLibro, ";
		$sql.= "a.nombre, a.apellidoPaterno, ";
		$sql.= "a.apellidoMaterno, l.titulo ";
		$sql.= "FROM librosAutores as la, autores as a, ";
		$sql.= "libros as l ";
		$sql.= "WHERE la.idLibro=l.id AND ";
		$sql.= "la.idAutor=a.id AND ";
		$sql.= "la.baja=0 AND ";
		$sql.= "la.id=".$id;
		return $this->db->query($sql);
	}

	/* copias */
	public function getCopiasLibroTabla($idLibro) {
		/* buscar copias por libro */
		if(empty($idLibro)) return false;
		$sql = "SELECT c.id, c.copia, c.clave, c.idLibro, ";
		$sql.= "c.edicion,c.anio,ec.estadoCopia as estado ";
		$sql.= "FROM copias as c, estadosCopias as ec ";
		$sql.= "WHERE c.idLibro=".$idLibro." AND ";
		$sql.= "c.estado=ec.id AND ";
		$sql.= "c.baja=0 ";
		return $this->db->querySelect($sql);
	}

}
?>