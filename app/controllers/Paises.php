<?php

class Paises extends Controlador
{
	private $modelo = "";

	function __construct()
	{
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->sesion->finalizarLogin();
		}
		$this->modelo = $this->modelo("PaisesModelo");
	}

	public function caratula()
	{
		$data = $this->modelo->getTabla();
		$datos = [
			"titulo" => "Paises",
			"subtitulo" => "Paises",
			"activo" => "paises",
			"menu" => true,
			"data" => $data
		];
		$this->vista("paisesCaratulaVista", $datos);
	}

	public function alta() {
	   //Definir los arreglos
	    $data = array();
	    $errores = array();

	    //Recibimos la información de la vista
	    if ($_SERVER['REQUEST_METHOD']=="POST") {
	      //
	      $id = $_POST['id'] ?? "";
	      $pais = Helper::cadena($_POST['pais'] ?? "");
	      //
	      // Validamos la información
	      // 
	      if(empty($pais)){
	        array_push($errores,"EL nombre del país es requerido.");
	      }

	      if (empty($errores)) { 
			// Crear arreglo de datos
			//
			$data = [
			 "id" => $id,
			 "pais"=>$pais
			];      
	        //Enviamos al modelo
	        if(trim($id)===""){
	          //Alta
	          if ($this->modelo->alta($data)) {
	            $this->mensaje(
	          		"Alta de un país", 
	          		"Alta de un país", 
	          		"Se añadió correctamente el país: ".$pais, 
	          		"paises", 
	          		"success"
	          	);
	          } else {
	          	$this->mensaje(
	          		"Error al añadir un país.", 
	          		"Error al añadir un país.", 
	          		"Error al modificar un país: ".$pais, 
	          		"paises", 
	          		"danger"
	          	);
	          }
	        } else {
	          //Modificar
	          if ($this->modelo->modificar($data)) {
	            $this->mensaje(
	          		"Modificar el país", 
	          		"Modificar el país", 
	          		"Se modificó correctamente el país: ".$pais,
	          		"paises", 
	          		"success"
	          	);
	          } else {
	          	$this->mensaje(
	          		"Error al modificar el país.", 
	          		"Error al modificar el país.", 
	          		"Error al modificar el país: ".$pais, 
	          		"paises", 
	          		"danger"
	          	);
	          }
	        }
	      }
	    } 
	    if(!empty($errores) || $_SERVER['REQUEST_METHOD']!="POST" ){
	    	//Vista Alta
		    $datos = [
		      "titulo" => "Alta de un país",
		      "subtitulo" => "Alta de un país",
		      "activo" => "paises",
		      "menu" => true,
		      "admon" => "admon",
		      "errores" => $errores,
		      "data" => []
		    ];
		    $this->vista("paisesAltaVista",$datos);
	    }
  	}

	public function borrar($id="") {
		// leemos los datos del registro del id
		$data = $this->modelo->getPaisId($id);
		// vista baja
		$datos = [
			"titulo" => "Baja de un País",
			"subtitulo" => "Baja del País",
			"menu" => true,
			"admon" => "admon",
			"errores" => [],
			"activo" => "paises",
			"data" => $data,
			"baja" => true
		];
		$this->vista("paisesAltaVista", $datos);
	}

	public function bajaLogica($id="") {
		if(isset($id) && $id != "") {
			if($this->modelo->bajaLogica($id)) {
				$this->mensaje(
	          		"Borrar el país.", 
	          		"Borrar el país.", 
	          		"Se borro correctamente el país", 
	          		"paises", 
	          		"success"
	          	);
			}else {
				$this->mensaje(
	          		"Error al borrar el país.", 
	          		"Error al borrar el país.", 
	          		"Error al borrar el país.", 
	          		"paises", 
	          		"danger"
	          	);
			}
		}
	}

	public function modificar($id) {
		// leemos los datos de la tabla
		$data = $this->modelo->getPaisId($id);
		$datos = [
			"titulo" => "Modificar País",
			"subtitulo" => "Modificar País",
			"menu" => true,
			"admon" => "admon",
			"activo" => "paises",
			"data" => $data
		];
		$this->vista("paisesAltaVista", $datos);
	}

}
