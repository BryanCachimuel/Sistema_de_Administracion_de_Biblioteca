<?php

class Temas extends Controlador {
	private $modelo = "";
	
	function __construct() {
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->sesion->finalizarLogin();
		}
		$this->modelo = $this->modelo("TemasModelo");
	}

	public function caratula($pagina=1) {
		$num = $this->modelo->getNumRegistros();
		$inicio = ($pagina-1)*TAMANO_PAGINA;
		$totalPaginas = ceil($num/TAMANO_PAGINA);
		$data = $this->modelo->getTabla($inicio,TAMANO_PAGINA);	
		$datos = [
			"titulo" => "Temas",
			"subtitulo" => "Temas",
			"activo" => "temas",
			"menu" => true,
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "temas",
				"pagina" => $pagina
			],
			"data" => $data
		];
		$this->vista("temasCaratulaVista",$datos);
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
			Helper::mostrar($data);   
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

	}

	public function bajaLogica($id='',$pag=1) {
	   
	}

  	public function modificar($id,$pag=1) {
		
	}
}
