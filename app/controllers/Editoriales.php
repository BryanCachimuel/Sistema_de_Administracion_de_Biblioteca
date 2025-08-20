<?php

class Editoriales extends Controlador {
	private $modelo = "";
	
	function __construct() {
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

	public function alta() {
		//Definir los arreglos
	    $data = [];
	    $errores = array();
	    $pag = 1;
		 //Recibimos la información de la vista
	    if ($_SERVER['REQUEST_METHOD']=="POST") {

	      $id = $_POST['id'] ?? "";
          $idCategoria = Helper::cadena($_POST['idCategoria'] ?? "");
	      $tema = Helper::cadena($_POST['tema'] ?? "");
	      $pag = $_POST['pag'] ?? "1";

	      // Validamos la información
	      if($idCategoria=="void"){
	        array_push($errores,"La categoria es requerida.");
	      }
          if(empty($tema)){
	        array_push($errores,"El tema es requerido.");
	      }

	      if (empty($errores)) { 
			// Crear arreglo de datos
			//
			$data = [
			 "id" => $id,
			 "idCategoria"=>$idCategoria,
             "tema"=>$tema
			];    
	        //Enviamos al modelo
	        if(trim($id)===""){
	          //Alta
	          if ($this->modelo->alta($data)) {
	            $this->mensaje(
	          		"Alta de un tema", 
	          		"Alta de un tema", 
	          		"Se añadió correctamente el tema: ".$tema, 
	          		"temas/".$pag, 
	          		"success"
	          	);
	          } else {
	          	$this->mensaje(
	          		"Error al añadir el tema.", 
	          		"Error al añadir el tema.", 
	          		"Error al modificar el tema: ".$tema, 
	          		"temas/".$pag, 
	          		"danger"
	          	);
	          }
	        } else {
	          //Modificar
	          if ($this->modelo->modificar($data)) {
	            $this->mensaje(
	          		"Modificar un tema", 
	          		"Modificar un tema", 
	          		"Se modificó correctamente el tema: ".$tema,
	          		"temas/".$pag, 
	          		"success"
	          	);
	          } else {
	          	$this->mensaje(
	          		"Error al modificar un tema.", 
	          		"Error al modificar un tema.", 
	          		"Error al modificar el tema: ".$tema, 
	          		"temas/".$pag, 
	          		"danger"
	          	);
	          }
	        }
	      }
	    } 
	    if(!empty($errores) || $_SERVER['REQUEST_METHOD']!="POST" ){
	    	//Vista Alta
			$categorias = $this->modelo->getCategorias();
		    $datos = [
		      "titulo" => "Alta de un tema",
		      "subtitulo" => "Alta de un tema",
		      "activo" => "temas",
		      "menu" => true,
		      "admon" => "admon",
			  "categorias" => $categorias,
		      "pag" => $pag,
		      "errores" => $errores,
		      "data" => []
		    ];
		    $this->vista("temasAltaVista",$datos);
	    }
  	}

  	public function borrar($id="",$pag=1) {
		//Leemos los datos del registro del id
	    $data = $this->modelo->getTemasId($id);
		$categorias = $this->modelo->getCategorias();
    	//Vista baja
	    $datos = [
	      "titulo" => "Baja de un tema",
	      "subtitulo" => "Baja de un tema",
	      "menu" => true,
	      "admon" => "admon",
	      "errores" => [],
	      "activo" => 'temas',
	      "pag" => $pag,
		  "categorias" => $categorias,
	      "data" => $data,
	      "baja" => true
	    ];
	    $this->vista("temasAltaVista",$datos);
	}

	public function bajaLogica($id='',$pag=1) {
	   if (isset($id) && $id!="") {
	     if ($this->modelo->bajaLogica($id)) {
        	$this->mensaje(
        		"Borrar un tema", 
        		"Borrar un tema", 
        		"Se borró correctamente el tema.", 
        		"temas/".$pag, 
        		"success"
        	);
        } else {
        	$this->mensaje(
        		"Error al borrar un tema", 
        		"Error al borrar un tema", 
        		"Error al borrar un tema.", 
        		"temas/".$pag, 
        		"danger"
        	);
        }
	   }
	}

  	public function modificar($id,$pag=1) {
		//Leemos los datos de la tabla
		$data = $this->modelo->getTemasId($id);
		$categorias = $this->modelo->getCategorias();
		$datos = [
			"titulo" => "Modificar un tema",
			"subtitulo" =>"Modificar un tema",
			"menu" => true, 
			"admon" => "admon",
			"pag" => $pag,
			"categorias" => $categorias,
			"activo" => "temas",
			"data" => $data
		];
		$this->vista("temasAltaVista",$datos);
	}
}
