<?php

class ConsultarModelo
{
    private $db = "";

    function __construct()
    {
        $this->db = new MySQLdb();
    }

    public function getPrestamos($idUsuario)  {
        $sql = "SELECT p.id, c.clave, l.titulo, ";
		$sql.= "DATE_FORMAT(p.prestamo_dt,'%d-%m-%Y') as fechaInicio, ";
		$sql.= "DATE_FORMAT(p.devolucion_dt,'%d-%m-%Y') as fechaFin ";
		$sql.= "FROM prestamos as p, usuarios as u, libros as l, copias as c ";
		$sql.= "WHERE p.baja=0 AND ";
		$sql.= "p.idCopia=c.id AND ";
		$sql.= "p.idUsuario=u.id AND ";
		$sql.= "p.idUsuario=".$idUsuario." AND ";
		$sql.= "c.idLibro=l.id ";
		$sql.= "ORDER BY p.devolucion_dt DESC ";
		$sql.= "LIMIT 10";
		return $this->db->querySelect($sql);
    }

    public function getTemas() {
        $sql = "SELECT t.id, t.tema, c.categoria ";
		$sql.= "FROM temas as t, categorias as c ";
		$sql.= "WHERE t.baja=0 AND ";
		$sql.= "t.idCategoria=c.id ";
		$sql.= "ORDER BY t.tema";
		return $this->db->querySelect($sql);
    }
}
