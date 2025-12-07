<?php  
/**
 * 
 */
class TableroModelo extends Llaves
{
	protected $db = "";
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function getTablas()
	{
		return $this->db->querySelect("SHOW TABLES");
	}

	public function getPrestamos(){
		$sql = "SELECT p.id, c.clave, l.titulo, CONCAT(u.nombre,' ', u.apellidoPaterno) as usuario,";
		$sql.= "DATE_FORMAT(p.prestamo_dt,'%d-%m-%Y') as fechaInicio, DATE_FORMAT(p.devolucion_dt,'%d-%m-%Y') as fechaFin, ";
		$sql.= "DATEDIFF(p.devolucion_dt, NOW()) as dif ";
		$sql.= "FROM prestamos as p, usuarios as u, libros as l, copias as c ";
		$sql.= "WHERE p.baja=0 AND ";
		$sql.= "p.idCopia=c.id AND ";
		$sql.= "p.idUsuario=u.id AND ";
		$sql.= "c.idLibro=l.id ";
		$sql.= "ORDER BY p.devolucion_dt DESC ";
		$sql.= "LIMIT 10";
		return  $this->db->querySelect($sql);
	}

	public function respaldarTabla($tabla='',$fecha="",$id="")
	{
		if (empty($tabla) || empty($fecha)) return false;
		$db = $this->db->getBaseDatos();
		$salida = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `" . $db . "`\r\n--\r\n\r\n";
		$datos = $this->db->queryCrudo("SELECT * FROM ".$tabla);
		$campos = $datos->columnCount();
		$filas = $datos->rowCount();
		$esquemaTabla = $this->db->querySelect("SHOW CREATE TABLE ".$tabla);
		$esquema = $esquemaTabla[0]["Create Table"];
		$salida.= "\n\n".$esquema.";\n\n";
		for ($i=0, $contador=0; $i < $campos; $i++, $contador=0) { 
			while ($fila = $datos->fetch()) {
				// verificamos contador
				if ($contador%100==0||$contador==0) {
					$salida .= "\nINSERT INTO ".$tabla." VALUES";
				}
				$salida .= "\n(";
				for ($j=0; $j < $campos; $j++) { 
					$file[$j] = str_replace("\n", "\\n", addslashes($fila[$j]));
					if (isset($fila[$j])) {
						$salida .= '"'.$fila[$j].'"';
					} else {
						$salida .= '""';
					}
					if($j < ($campos-1)){
						$salida .= ',';
					}
				}
				$salida .= ")";
				//cada 100
				if ((($contador + 1)%100==0 && $contador !=0) || $contador+1==$filas) {
					$salida .= ";";
				} else {
					$salida .= ",";
				}
				$contador++;
			}
		}
		$salida .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
		$carpeta = "respaldos/".$fecha."-".$id;
		if (!file_exists($carpeta)) {
			mkdir($carpeta);
		}
		$archivo = sprintf('%s/%s.sql',$carpeta,$tabla);

		return file_put_contents($archivo, $salida) !== false;
	}

}
?>