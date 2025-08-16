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
	          		"Modificar la categoría", 
	          		"Modificar la categoría", 
	          		"Se modificó correctamente la categoría: ".$categoria,
	          		"categorias/".$pag, 
	          		"success"
	          	);
	          } else {
	          	$this->mensaje(
	          		"Error al modificar la categoría.", 
	          		"Error al modificar la categoría.", 
	          		"Error al modificar la categoría: ".$categoria, 
	          		"categorias/".$pag, 
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
	    $data = $this->modelo->getCategoriaId($id);
    	//Vista baja
	    $datos = [
	      "titulo" => "Baja de una categoría",
	      "subtitulo" => "Baja de la categoría",
	      "menu" => true,
	      "admon" => "admon",
	      "errores" => [],
	      "activo" => 'categorias',
	      "pag" => $pag,
	      "data" => $data,
	      "baja" => true
	    ];
	    $this->vista("categoriasAltaVista",$datos);
	}

	public function bajaLogica($id='',$pag=1) {
	   if (isset($id) && $id!="") {
	     if ($this->modelo->bajaLogica($id)) {
        	$this->mensaje(
        		"Borrar la categoría", 
        		"Borrar la categoría", 
        		"Se borró correctamente la categoría.", 
        		"categorias/".$pag, 
        		"success"
        	);
        } else {
        	$this->mensaje(
        		"Error al borrar la categoría", 
        		"Error al borrar la categoría", 
        		"Error al borrar la categoría.", 
        		"categorias/".$pag, 
        		"danger"
        	);
        }
	   }
	}

  	public function modificar($id,$pag=1) {
		//Leemos los datos de la tabla
		$data = $this->modelo->getCategoriaId($id);

		$datos = [
			"titulo" => "Modificar categoría",
			"subtitulo" =>"Modificar categoría",
			"menu" => true, 
			"admon" => "admon",
			"pag" => $pag,
			"activo" => "categorias",
			"data" => $data
		];
		$this->vista("categoriasAltaVista",$datos);
	}
}
