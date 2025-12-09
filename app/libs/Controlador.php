<?php 
/**
 * 
 */
class Controlador
{
	
	function __construct(){}

	public function modelo($modelo='')
	{
		if (file_exists("../app/modelos/".$modelo.".php")) {
			require_once("../app/modelos/".$modelo.".php");
			return new $modelo;
		} else {
			die("El modelo ".$modelo." no existe");
		}
		
	}

	public function vista($vista='',$datos=[])
	{
		if (file_exists("../app/vistas/".$vista.".php")) {
			require_once("../app/vistas/".$vista.".php");
		} else {
			die("La vista ".$vista." no existe");
		}
	}

	public function mensaje($titulo='',$subtitulo,$texto,$url,$color,$url2="",$color2="",$texto2="")
	  {
	    $datos = [
	      "titulo" => $titulo,
	      "menu" => false,
	      "errores" => [],
	      "data" => [],
	      "subtitulo" => $subtitulo,
	      "texto" => $texto,
	      "url" => $url,
	      "color" => "alert-".$color,
	      "colorBoton" => "btn-".$color,
	      "textoBoton" => "Regresar",
	      "url2" => $url2,
	      "colorBoton2" => "btn-".$color2,
	      "textoBoton2" => $texto2
	      ];
	      $this->vista("mensaje",$datos);
	  }

	public function perfil()
	{
		$errores = [];
		$admon = ($this->usuario["idTipoUsuario"]==ADMON);
		$regreso = ($admon)?"tablero":"consultar";
		//
		if ($_SERVER['REQUEST_METHOD']=="POST") {
			//
			$id = $_POST['id']??"";
			$nombre = Helper::cadena($_POST['nombre']??"");
			$apellidoPaterno = Helper::cadena($_POST['apellidoPaterno']??"");
			$apellidoMaterno = Helper::cadena($_POST['apellidoMaterno']??"");
			$nueva = $_POST['clave']??"";
			$verifica = $_POST['verifica']??"";

			if(empty($nombre)){
				array_push($errores, "El nombre del usuario no puede estar vacío.");
			}
			if(empty($apellidoPaterno)){
				array_push($errores, "El apellido paterno no puede estar vacío.");
			}
			if(!(empty($nueva) && empty($verifica)) ){
				if(empty($verifica)){
					array_push($errores, "La nueva clave de acceso de verificación no puede estar vacía.");
				}
				if($nueva!=$verifica){
					array_push($errores, "Las claves de acceso no coinciden.");
				}
			}
			//
			if (empty($errores)) {
				if ($this->modelo->setUsuario($id, $nombre, $apellidoPaterno, $apellidoMaterno,$nueva)) {
					$data = $this->modelo->getUsuarioId($id);
					$this->sesion->setUsuario($data);
					 $this->mensaje(
		          		"Modificación del perfil exitoso", 
		          		"Modificación del perfil exitoso", 
		          		"Modificación del perfil exitoso ", 
		          		$regreso, 
		          		"success"
		          	);
				} else {
					$this->mensaje(
		          		"Error al modificar del perfil", 
		          		"Error al modificar del perfil", 
		          		"Error al modificar del perfil", 
		          		$regreso, 
		          		"danger"
		          	);
				}
				exit;
			}
		}
		//
		$datos = [
			"titulo"=> "Perfil del usuario",
			"subtitulo" => "Perfil del usuario",
			"admon" => $admon,
			"menu" => true,
			"regreso" => $regreso,
			"activo" => "perfil",
			"errores" => $errores,
			"data" => $this->usuario
		];
		$this->vista("tableroPerfilVista",$datos);
	}
}
 ?>