<?php  
/**
 * 
 */
class Usuarios extends Controlador
{
	private $modelo = "";
	
	function __construct()
	{
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->sesion->finalizarLogin();
		}
		$this->modelo = $this->modelo("UsuariosModelo");
	}

	public function caratula($pagina=1) {
		$num = $this->modelo->getNumRegistros();
		$inicio = ($pagina-1)*TAMANO_PAGINA;
		$totalPaginas = ceil($num/TAMANO_PAGINA);
		$data = $this->modelo->getTabla($inicio,TAMANO_PAGINA);	
		$datos = [
			"titulo" => "Usuarios",
			"subtitulo" => "Usuarios",
			"activo" => "usuarios",
			"menu" => true,
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "usuarios",
				"pagina" => $pagina
			],
			"data" => $data
		];
		$this->vista("usuariosCaratulaVista",$datos);
	}

	public function alta(){
	   //Definir los arreglos
	    $data = [];
	    $errores = array();
	    $pag = 1;

	    //Recibimos la información de la vista
	    if ($_SERVER['REQUEST_METHOD']=="POST") {
	      //
	      $id = $_POST['id'] ?? "";
	      $pag = $_POST['pag'] ?? "1";
	      $idTipoUsuario = Helper::cadena($_POST['idTipoUsuario'] ?? "");
		  $correo = Helper::cadena($_POST['correo'] ?? "");
		  $nombre = Helper::cadena($_POST['nombre'] ?? "");
		  $apellidoPaterno = Helper::cadena($_POST['apellidoPaterno'] ?? "");
		  $apellidoMaterno = Helper::cadena($_POST['apellidoMaterno'] ?? "");
		  $genero = Helper::cadena($_POST['genero'] ?? "");
		  $telefono = Helper::cadena($_POST['telefono'] ?? "");
		  $fechaNacimiento = Helper::cadena($_POST['fechaNacimiento'] ?? "");
		  $estado = Helper::cadena($_POST['estado'] ?? "");

			// validar la información
			if (Helper::correo($correo) == false) {
				array_push($errores, "El correo no tiene un formato correcto");
			}
			if (empty($correo)) {
				array_push($errores, "El correo es requerido");
			}
			if (trim($id)==="" && $this->modelo->buscarCorreo($correo)) {
				array_push($errores, "El correo ya existe en la base de datos");
			}

			if (empty($nombre)) {
				array_push($errores, "El nombre es requerido");
			}

			if (empty($apellidoPaterno)) {
				array_push($errores, "El apellido paterno es requerido");
			}

			if (Helper::fecha($fechaNacimiento) == false) {
				array_push($errores, "El formato de la fecha de nacimiento no es correcto");
			}

			if($genero == "void") {
				array_push($errores, "El genero es requerido");
			}

	      if (empty($errores)) { 
			// Crear arreglo de datos
			$clave = Helper::generarClave(10);
			$data = [
			 "id" => $id,
			 "idTipoUsuario" => $idTipoUsuario,
			 "correo" => $correo,
			 "nombre" => $nombre,
			 "clave" => $clave,
			 "apellidoPaterno" => $apellidoPaterno,
			 "apellidoMaterno" => $apellidoMaterno,
			 "genero" => $genero,
			 "telefono" => $telefono,
			 "fechaNacimiento" => $fechaNacimiento,
			 "estado" => $estado
			];
	        //Enviamos al modelo
	        if(trim($id)===""){
	          //Alta
	          if ($this->modelo->alta($data)) {
	            $this->mensaje(
	          		"Alta de un usuario", 
	          		"Alta de un usuario", 
	          		"Se añadió correctamente el usuario: ".$correo, 
	          		"usuarios/".$pag, 
	          		"success"
	          	);
	          } else {
	          	$this->mensaje(
	          		"Error al añadir un usuario.", 
	          		"Error al añadir un usuario.", 
	          		"Error al modificar un usuario: ".$correo, 
	          		"usuarios/".$pag, 
	          		"danger"
	          	);
	          }
	        } else {
	          //Modificar
	          if ($this->modelo->modificar($data)) {
	            $this->mensaje(
	          		"Modificar un usuario", 
	          		"Modificar un usuario", 
	          		"Se modificó correctamente el usuario: ".$correo,
	          		"usuarios/".$pag, 
	          		"success"
	          	);
	          } else {
	          	$this->mensaje(
	          		"Error al modificar un usuario.", 
	          		"Error al modificar un usuario.", 
	          		"Error al modificar un usuario: ".$correo, 
	          		"usuarios/".$pag, 
	          		"danger"
	          	);
	          }
	        }
	      }
	    } 
	    if(!empty($errores) || $_SERVER['REQUEST_METHOD']!="POST" ){
	    	//Vista Alta
	    	$tipoUsuarios = $this->modelo->getCatalogo("tipoUsuarios");
			$estadosUsuario = $this->modelo->getCatalogo("estadosUsuario");
			$genero = $this->modelo->getCatalogo("genero");
		    $datos = [
		      "titulo" => "Alta de un usuario",
		      "subtitulo" => "Alta de un usuario",
		      "activo" => "usuarios",
		      "menu" => true,
		      "admon" => "admon",
		      "tipoUsuarios" => $tipoUsuarios,
			  "estadosUsuario" => $estadosUsuario,
			  "genero" => $genero,
		      "pag" => $pag,
		      "errores" => $errores,
		      "data" => []
		    ];
		    $this->vista("usuariosAltaVista",$datos);
	    }
  	}

  	public function borrar($id="",$pag=1) {
	    //Leemos los datos del registro del id
	    $data = $this->modelo->getUsuarioId($id);
	    $tipoUsuarios = $this->modelo->getCatalogo("tipoUsuarios");
		$estadosUsuario = $this->modelo->getCatalogo("estadosUsuario");
		$genero = $this->modelo->getCatalogo("genero");
    	//Vista baja
	    $datos = [
	      "titulo" => "Baja de un usuario",
	      "subtitulo" => "Baja de un usuario",
	      "menu" => true,
	      "admon" => "admon",
	      "errores" => [],
	      "pag" => $pag,
	      "tipoUsuarios" => $tipoUsuarios,
		  "estadosUsuario" => $estadosUsuario,
		  "genero" => $genero,
	      "activo" => 'usuarios',
	      "data" => $data,
	      "baja" => true
	    ];
	    $this->vista("usuariosAltaVista",$datos);
	  }

	public function bajaLogica($id='',$pag=1) {
	   if (isset($id) && $id!="") {
	     if ($this->modelo->bajaLogica($id)) {
        	$this->mensaje(
        		"Borrar un usuario", 
        		"Borrar un usuario", 
        		"Se borró correctamente el usuario.", 
        		"usuarios/".$pag, 
        		"success"
        	);
        } else {
        	$this->mensaje(
        		"Error al borrar un usuario", 
        		"Error al borrar un usuario", 
        		"Error al borrar un usuario.", 
        		"usuarios/".$pag, 
        		"danger"
        	);
        }
	   }
	}

  	public function modificar($id,$pag=1) {
		//Leemos los datos de la tabla
		$data = $this->modelo->getUsuarioId($id);
		$tipoUsuarios = $this->modelo->getCatalogo("tipoUsuarios");
		$estadosUsuario = $this->modelo->getCatalogo("estadosUsuario");
		$genero = $this->modelo->getCatalogo("genero");
		$datos = [
		      "titulo" => "Modificar un usuario",
		      "subtitulo" => "Modificar un usuario",
		      "activo" => "usuarios",
		      "menu" => true,
		      "admon" => "admon",
		      "tipoUsuarios" => $tipoUsuarios,
			  "estadosUsuario" => $estadosUsuario,
			  "genero" => $genero,
		      "pag" => $pag,
		      "errores" => [],
		      "data" => $data
		    ];
		$this->vista("usuariosAltaVista",$datos);
	}
}
?>