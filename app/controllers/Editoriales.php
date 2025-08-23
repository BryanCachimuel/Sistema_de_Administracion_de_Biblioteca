<?php  
/**
 * 
 */
class Editoriales extends Controlador
{
	private $modelo = "";
	
	function __construct()
	{
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->sesion->finalizarLogin();
		}
		$this->modelo = $this->modelo("EditorialesModelo");
	}

	public function caratula($pagina=1) {
		$num = $this->modelo->getNumRegistros();
		$inicio = ($pagina-1)*TAMANO_PAGINA;
		$totalPaginas = ceil($num/TAMANO_PAGINA);
		$data = $this->modelo->getTabla($inicio,TAMANO_PAGINA);	
		$datos = [
			"titulo" => "Editoriales",
			"subtitulo" => "Editoriales",
			"activo" => "editoriales",
			"menu" => true,
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
		  $editorial = Helper::cadena($_POST['editorial'] ?? "");
	      $idPais = Helper::cadena($_POST['idPais'] ?? "");
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
			 "editorial"=>$editorial,
			 "idPais"=>$idPais,
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
		      "admon" => "admon",
		      "paises" => $paises,
		      "pag" => $pag,
		      "errores" => $errores,
		      "data" => []
		    ];
		    $this->vista("editorialesAltaVista",$datos);
	    }
  	}

  	public function borrar($id="",$pag=1) {
	    //Leemos los datos del registro del id
	    $data = $this->modelo->getEditorialId($id);
	    $paises = $this->modelo->getPaises();
    	//Vista baja
	    $datos = [
	      "titulo" => "Baja de una editorial",
	      "subtitulo" => "Baja de una editorial",
	      "menu" => true,
	      "admon" => "admon",
	      "errores" => [],
	      "pag" => $pag,
	      "paises" => $paises,
	      "activo" => 'editoriales',
	      "data" => $data,
	      "baja" => true
	    ];
	    $this->vista("editorialesAltaVista",$datos);
	  }

	public function bajaLogica($id='',$pag=1) {
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
        		"Error al borrar una editorial.", 
        		"editoriales/".$pag, 
        		"danger"
        	);
        }
	   }
	}

  	public function modificar($id,$pag=1) {
		//Leemos los datos de la tabla
		$data = $this->modelo->getEditorialId($id);
		$paises = $this->modelo->getPaises();
		$datos = [
			"titulo" => "Modificar una editorial",
			"subtitulo" =>"Modificar una editorial",
			"menu" => true,
			"admon" => "admon",
			"pag" => $pag,
			"paises" => $paises,
			"activo" => "editoriales",
			"data" => $data
		];
		$this->vista("editorialesAltaVista",$datos);
	}
}
?>