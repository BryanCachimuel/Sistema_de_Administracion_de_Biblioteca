<?php  
/**
 * 
 */
class Editoriales extends Controlador
{
	private $modelo = "";
	private $usuario = "";
	private $sesion;
	
	function __construct()
	{
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->modelo = $this->modelo("EditorialesModelo");
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
			"titulo" => "Editoriales",
			"subtitulo" => "Editoriales",
			"activo" => "editoriales",
			"menu" => true,
			"admon" => ADMON,
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "editoriales",
				"pagina" => $pagina
			],
			"data" => $data
		];
		$this->vista("editorialesCaratulaVista",$datos);
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
	      $idPais = Helper::cadena($_POST['idPais'] ?? "");
	      $editorial = Helper::cadena($_POST['editorial'] ?? "");
	      $pagina = Helper::cadena($_POST['pagina'] ?? "");
	      $pag = $_POST['pag'] ?? "1";
	      //
	      // Validamos la información
	      // 
	      if($idPais=="void"){
	        array_push($errores,"El país es requerido.");
	      }
	      if(empty($editorial)){
	        array_push($errores,"El nombre de la editorial es requerido.");
	      }
	      if (empty($errores)) { 
			// Crear arreglo de datos
			//
			$data = [
			 "id" => $id,
			 "idPais"=>$idPais,
			 "editorial"=>$editorial,
			 "pagina" => $pagina,
			 "estado" => 0
			];
	        //Enviamos al modelo
	        if(trim($id)===""){
	          //Alta
	          if ($this->modelo->alta($data)) {
	            $this->mensaje(
	          		"Alta de una editorial", 
	          		"Alta de una editorial", 
	          		"Se añadió correctamente la editorial: ".$editorial, 
	          		"editoriales/".$pag, 
	          		"success"
	          	);
	          } else {
	          	$this->mensaje(
	          		"Error al añadir una editorial.", 
	          		"Error al añadir una editorial.", 
	          		"Error al modificar una editorial: ".$editorial, 
	          		"editoriales/".$pag, 
	          		"danger"
	          	);
	          }
	        } else {
	          //Modificar
	          if ($this->modelo->modificar($data)) {
	            $this->mensaje(
	          		"Modificar una editorial", 
	          		"Modificar una editorial", 
	          		"Se modificó correctamente la editorial: ".$editorial,
	          		"editoriales/".$pag, 
	          		"success"
	          	);
	          } else {
	          	$this->mensaje(
	          		"Error al modificar una editorial.", 
	          		"Error al modificar una editorial.", 
	          		"Error al modificar una editorial: ".$editorial, 
	          		"editoriales/".$pag, 
	          		"danger"
	          	);
	          }
	        }
	      }
	    } 
	    if(!empty($errores) || $_SERVER['REQUEST_METHOD']!="POST" ){
	    	//Vista Alta
	    	$paises = $this->modelo->getPaises();
		    $datos = [
		      "titulo" => "Alta de una editorial",
		      "subtitulo" => "Alta de una editorial",
		      "activo" => "editoriales",
		      "menu" => true,
		      "admon" => ADMON,
		      "paises" => $paises,
		      "pag" => $pag,
		      "errores" => $errores,
		      "data" => []
		    ];
		    $this->vista("editorialesAltaVista",$datos);
	    }
  	}

  	public function borrar($id="",$pag=1){
	    //Leemos los datos del registro del id
	    $data = $this->modelo->getId($id);
	    $paises = $this->modelo->getPaises();
	    $ir_array = $this->modelo->getIntegridadReferencial($id);

	    if ($ir_array[0]==0) {
	    	//Vista baja
		    $datos = [
		      "titulo" => "Baja de una editorial",
		      "subtitulo" => "Baja de una editorial",
		      "menu" => true,
		      "admon" => ADMON,
		      "errores" => [],
		      "pag" => $pag,
		      "paises" => $paises,
		      "activo" => 'editoriales',
		      "data" => $data,
		      "baja" => true
		    ];
		    $this->vista("editorialesAltaVista",$datos);
		  } else {
	    	$this->mensaje(
        		"Error al borrar una editorial", 
        		"Error al borrar una editorial", 
        		"No podemos eliminar el editorial porque tiene:<ul><li>".$ir_array[0]." copias.</li></ul>Primero debe eliminar esas referencias.", 
        		"editoriales", 
        		"danger"
        	);
	    }
	  }

	public function bajaLogica($id='',$pag=1){
	   if (isset($id) && $id!="") {
	     if ($this->modelo->bajaLogica($id)) {
        	$this->mensaje(
        		"Borrar una editorial", 
        		"Borrar una editorial", 
        		"Se borró correctamente la editorial.", 
        		"editoriales/".$pag, 
        		"success"
        	);
        } else {
        	$this->mensaje(
        		"Error al borrar una editorial", 
        		"Error al borrar una editorial", 
        		"Error al borrar uuna editorial.", 
        		"editoriales/".$pag, 
        		"danger"
        	);
        }
	   }
	}

  	public function modificar($id,$pag=1)
	{
		//Leemos los datos de la tabla
		$data = $this->modelo->getId($id);
		$paises = $this->modelo->getPaises();
		$datos = [
			"titulo" => "Modificar una editorial",
			"subtitulo" =>"Modificar una editorial",
			"menu" => true,
			"admon" => ADMON,
			"pag" => $pag,
			"paises" => $paises,
			"activo" => "editoriales",
			"data" => $data
		];
		$this->vista("editorialesAltaVista",$datos);
	}
}
?>