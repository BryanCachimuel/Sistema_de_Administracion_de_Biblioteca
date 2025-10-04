<?php

class ConsultarModelo
{
	private $db = "";

	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function getPrestamos($idUsuario)
	{
		$sql = "SELECT p.id, c.clave, l.titulo, ";
		$sql .= "DATE_FORMAT(p.prestamo_dt,'%d-%m-%Y') as fechaInicio, ";
		$sql .= "DATE_FORMAT(p.devolucion_dt,'%d-%m-%Y') as fechaFin ";
		$sql .= "FROM prestamos as p, usuarios as u, libros as l, copias as c ";
		$sql .= "WHERE p.baja=0 AND ";
		$sql .= "p.idCopia=c.id AND ";
		$sql .= "p.idUsuario=u.id AND ";
		$sql .= "p.idUsuario=" . $idUsuario . " AND ";
		$sql .= "c.idLibro=l.id ";
		$sql .= "ORDER BY p.devolucion_dt DESC ";
		$sql .= "LIMIT 10";
		return $this->db->querySelect($sql);
	}

	public function getLibros($data)
	{
		$sql = "SELECT l.id, l.titulo, CONCAT(a.nombre,' ',a.apellidoPaterno,' ',a.apellidoMaterno) as autor, t.tema  ";
		$sql .= "FROM librosAutores as la, libros as l, ";
		$sql .= "autores as a, temas as t ";
		$sql .= "WHERE ";
		if ($data["titulo"] != "") {
			$sql .= "l.titulo LIKE('" . $data["titulo"] . "') AND ";
		}
		if ($data["nombre"] != "") {
			$sql .= "a.nombre LIKE('" . $data["nombre"] . "') AND ";
		}
		if ($data["apellidoPaterno"] != "") {
			$sql .= "a.apellidoPaterno LIKE('" . $data["apellidoPaterno"] . "') AND ";
		}
		if ($data["apellidoMaterno"] != "") {
			$sql .= "a.apellidoMaterno LIKE('" . $data["apellidoMaterno"] . "') AND ";
		}
		if ($data["idTema"] != "void") {
			$sql .= "t.id = " . $data["idTema"] . " AND ";
		}
		$sql .= "la.idLibro=l.id AND la.idAutor=a.id ";
		$sql .= "AND t.id=l.idTema AND la.baja=0 AND t.baja=0 AND a.baja=0 AND l.baja=0 ";
		$sql .= "ORDER BY l.titulo";
		return $this->db->querySelect($sql);
	}

	public function getTemas()
	{
		$sql = "SELECT t.id, t.tema, c.categoria ";
		$sql .= "FROM temas as t, categorias as c ";
		$sql .= "WHERE t.baja=0 AND ";
		$sql .= "t.idCategoria=c.id ";
		$sql .= "ORDER BY t.tema";
		return $this->db->querySelect($sql);
	}
}
