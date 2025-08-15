<?php

class Categorias extends Controlador {
	private $modelo = "";
	
	function __construct() {
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->sesion->finalizarLogin();
		}
		$this->modelo = $this->modelo("CategoriasModelo");
	}

	public function caratula($pagina=1) {
		$num = $this->modelo->getNumRegistros();
		$inicio = ($pagina-1)*TAMANO_PAGINA;
		$totalPaginas = ceil($num/TAMANO_PAGINA);
		$data = $this->modelo->getTabla($inicio,TAMANO_PAGINA);	
		$datos = [
			"titulo" => "Categorías",
			"subtitulo" => "Categorías",
			"activo" => "categorias",
			"menu" => true,
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "categorias",
				"pagina" => $pagina
			],
			"data" => $data
		];
		$this->vista("categoriasCaratulaVista",$datos);
	}

	public function alta() {
		//Definir los arreglos
	    $data = [];
	    $errores = array();
	    $pag = 1;
		 //Recibimos la información de la vista
	    if ($_SERVER['REQUEST_METHOD']=="POST") {

	      $id = $_POST['id'] ?? "";
          $clave = Helper::cadena($_POST['clave'] ?? "");
	      $categoria = Helper::cadena($_POST['categoria'] ?? "");
	      $pag = $_POST['pag'] ?? "1";

	      // Validamos la información
	      if($clave==""){
	        array_push($errores,"La clave es requerida.");
	      }
          if(empty($categoria)){
	        array_push($errores,"La categoria es requerida.");
	      }

	      if (empty($errores)) { 
			// Crear arreglo de datos
			//
			$data = [
			 "id" => $id,
			 "clave"=>$clave,
             "categoria"=>$categoria
			];      
	        //Enviamos al modelo
	        if(trim($id)===""){
	          //Alta
	          if ($this->modelo->alta($data)) {
	            $this->mensaje(
	          		"Alta de una categoría", 
	          		"Alta de una categoría", 
	          		"Se añadió correctamente la categoría: ".$categoria, 
	          		"categorias/".$pag, 
	          		"success"
	          	);
	          } else {
	          	$this->mensaje(
	          		"Error al añadir una categoría.", 
	          		"Error al añadir una categoría.", 
	          		"Error al modificar la categoría: ".$categoria, 
	          		"categorias/".$pag, 
	          		"danger"
	          	);
	          }
	        } else {
	          //Modificar
	          if ($this->modelo->modificar($data)) {
	            $this->mensaje(
	          		"Modificar el idioma", 
	          		"Modificar el idioma", 
	          		"Se modificó correctamente el idioma: ".$idioma,
	          		"idiomas/".$pag, 
	          		"success"
	          	);
	          } else {
	          	$this->mensaje(
	          		"Error al modificar el idioma.", 
	          		"Error al modificar el idioma.", 
	          		"Error al modificar el idioma: ".$idioma, 
	          		"idiomas/".$pag, 
	          		"danger"
	          	);
	          }
	        }
	      }
	    } 
	    if(!empty($errores) || $_SERVER['REQUEST_METHOD']!="POST" ){
	    	//Vista Alta
		    $datos = [
		      "titulo" => "Alta de una categoría",
		      "subtitulo" => "Alta de una categoría",
		      "activo" => "categorias",
		      "menu" => true,
		      "admon" => "admon",
		      "pag" => $pag,
		      "errores" => $errores,
		      "data" => []
		    ];
		    $this->vista("categoriasAltaVista",$datos);
	    }
  	}

  	public function borrar($id="",$pag=1) {
	  //Leemos los datos del registro del id
	    $data = $this->modelo->getIdiomaId($id);
    	//Vista baja
	    $datos = [
	      "titulo" => "Baja de un idioma",
	      "subtitulo" => "Baja del idioma",
	      "menu" => true,
	      "admon" => "admon",
	      "errores" => [],
	      "activo" => 'idiomas',
	      "pag" => $pag,
	      "data" => $data,
	      "baja" => true
	    ];
	    $this->vista("idiomasAltaVista",$datos);
	}

	public function bajaLogica($id='',$pag=1) {
	   if (isset($id) && $id!="") {
	     if ($this->modelo->bajaLogica($id)) {
        	$this->mensaje(
        		"Borrar el idioma", 
        		"Borrar el idioma", 
        		"Se borró correctamente el idioma.", 
        		"idiomas/".$pag, 
        		"success"
        	);
        } else {
        	$this->mensaje(
        		"Error al borrar el idioma", 
        		"Error al borrar el idioma", 
        		"Error al borrar el idioma.", 
        		"idiomas/".$pag, 
        		"danger"
        	);
        }
	   }
	}

  	public function modificar($id,$pag) {
		//Leemos los datos de la tabla
		$data = $this->modelo->getIdiomaId($id);

		$datos = [
			"titulo" => "Modificar idioma",
			"subtitulo" =>"Modificar idioma",
			"menu" => true, 
			"idiomas/" => $pag,
			"admon" => "admon",
			"pag" => $pag,
			"activo" => "idiomas",
			"data" => $data
		];
		$this->vista("idiomasAltaVista",$datos);
	}
}
