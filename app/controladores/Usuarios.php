<?php  
/**
 * 
 */
class Usuarios extends Controlador
{
	private $modelo = "";
	private $usuario = "";
	private $sesion;
	
	function __construct()
	{
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->modelo = $this->modelo("UsuariosModelo");
			$this->usuario = $this->sesion->getUsuario();
		} else {
			header("location:".RUTA);
		}
	}

	public function caratula($pagina=1)
	{
		$num = $this->modelo->getNumRegistros();
		$inicio = ($pagina-1)*TAMANO_PAGINA;
		$totalPaginas = ceil($num/TAMANO_PAGINA);
		$data = $this->modelo->getTabla($inicio,TAMANO_PAGINA);	
		$datos = [
			"titulo" => "Usuarios",
			"subtitulo" => "Usuarios",
			"activo" => "usuarios",
			"menu" => true,
			"admon" => ADMON,
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
	      //
	      // Validamos la información
	      // 
	      if(Helper::correo($correo)==false){
	        array_push($errores,"El correo no tiene un formato correcto.");
	      }
	      if(empty($correo)){
	        array_push($errores,"El correo es requerido.");
	      }
	      if (trim($id)==="" && $this->modelo->buscarCorreo($correo)) {
	      	array_push($errores,"El correo ya existe en la base de datos.");
	      }
	      /*-------------------------*/
	      if(empty($nombre)){
	        array_push($errores,"El nombre es requerido.");
	      }
	      if(empty($apellidoPaterno)){
	        array_push($errores,"El apellido paterno es requerido.");
	      }
	      if(Helper::fecha($fechaNacimiento)==false){
	        array_push($errores,"El formato de la fecha de nacimieto no es correcta.");
	      }
	      if($genero=="void"){
	        array_push($errores,"El género es obligatorio.");
	      }
	      if (empty($errores)) { 
			// Crear arreglo de datos
			//
			$clave = Helper::generarClave(10);
			$data = [
			 "id" => $id,
			 "idTipoUsuario"=>$idTipoUsuario,
		     "correo"=> $correo,
		     "nombre"=> $nombre,
		     "clave"=>$clave,
		     "apellidoPaterno"=> $apellidoPaterno,
		     "apellidoMaterno"=> $apellidoMaterno,
		     "genero"=> $genero,
		     "telefono"=> $telefono,
		     "fechaNacimiento"=> $fechaNacimiento,
		     "estado"=> $estado
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
		      "admon" => ADMON,
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

  	public function borrar($id="",$pag=1){
	    //Leemos los datos del registro del id
	    $data = $this->modelo->getId($id);
	   	$tipoUsuarios = $this->modelo->getCatalogo("tipoUsuarios");
	    $estadosUsuario = $this->modelo->getCatalogo("estadosUsuario");
	    $genero = $this->modelo->getCatalogo("genero");
	    $ir_array = $this->modelo->getIntegridadReferencial($id);

	    if ($ir_array[0]==0) {
	    	//Vista baja
		    $datos = [
		      "titulo" => "Baja de un usuario",
		      "subtitulo" => "Baja de un usuario",
		      "menu" => true,
		      "admon" => ADMON,
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
		} else {
			$this->mensaje(
        		"Error al borrar un usuario", 
        		"Error al borrar un usuario", 
        		"No podemos eliminar el usuario porque tiene:<ul><li>".$ir_array[0]." préstamos.</li></ul>Primero debe eliminar esas referencias.", 
        		"usuarios", 
        		"danger"
        	);
		}
	  }

	public function bajaLogica($id='',$pag=1){
	   if (isset($id) && $id!="") {
	     if ($this->modelo->bajaLogica($id)) {
        	$this->mensaje(
        		"Borrar un usuario", 
        		"Borrar un usuario", 
        		"Se borró correctamente un usuario.", 
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

	public function estadoActualizar()
	{
		$errores = [];
		if ($_SERVER['REQUEST_METHOD']=="POST") {
			//
			$id = $_POST['id'] ?? "";
			$pag = $_POST['pag'] ?? "1";
			$estado = $_POST['estado'] ?? "void";
			if($estado=="void"){
	       		array_push($errores,"El género es obligatorio.");
	       	}
	       	if($id==1){
	       		$this->mensaje(
	        		"Error al actualizar el estado del usuario", 
	        		"Error al actualizar el estado del usuario", 
	        		"No se puede cambiar el estado del administrador original.", 
	        		"usuarios/".$pag, 
	        		"danger"
	        	);
	       		array_push($errores,"No se puede cambiar el estado del administrador original.");
	       	}
	       	if (empty($errores)) {
	       		if ($this->modelo->estadoActualizar($id,$estado)) {
	       			$this->mensaje(
		        		"Actualizar el estado del usuario",
		        		"Actualizar el estado del usuario",
		        		"Se actualizó correctamente el estado del usuario.", 
		        		"usuarios/".$pag, 
		        		"success"
		        	);	
				} else {
					$this->mensaje(
		        		"Error al actualizar el estado del usuario", 
		        		"Error al actualizar el estado del usuario", 
		        		"Error al actualizar el estado del usuario.", 
		        		"usuarios/".$pag, 
		        		"danger"
		        	);
				}
	       	}
		}
	}

	public function estadoCambiar($id,$pag=1)
	{
		//Leemos los datos de la tabla
		$data = $this->modelo->getId($id);
	    $estadosUsuario = $this->modelo->getCatalogo("estadosUsuario");
		$datos = [
		      "titulo" => "Modificar el estado de un usuario",
		      "subtitulo" => "Modificar el estado de un usuario",
		      "activo" => "usuarios",
		      "menu" => true,
		      "admon" => ADMON,
		      "estadosUsuario" => $estadosUsuario,
		      "pag" => $pag,
		      "errores" => [],
		      "data" => $data
		    ];
		    $this->vista("usuariosEstadoCambiarVista",$datos);
	}

  	public function modificar($id,$pag=1)
	{
		//Leemos los datos de la tabla
		$data = $this->modelo->getId($id);
		$tipoUsuarios = $this->modelo->getCatalogo("tipoUsuarios");
	    $estadosUsuario = $this->modelo->getCatalogo("estadosUsuario");
	    $genero = $this->modelo->getCatalogo("genero");
		$datos = [
		      "titulo" => "Modificar un usuario",
		      "subtitulo" => "Modificar un usuario",
		      "activo" => "usuarios",
		      "menu" => true,
		      "admon" => ADMON,
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