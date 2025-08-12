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
		// definir arreglos
		$data = array();
		$errores = array();

		// recibir la información de la vista
		if($_SERVER['REQUEST_METHOD']!="POST") {
			$id = $_POST["id"]??"";
			$pais = Helper::cadena($_POST['pais']??"");
			Helper::mostrar($pais);
		}

		if(!empty($errores) || $_SERVER['REQUEST_METHOD']!="POST") {
			//Vista de alta
			$datos = [
				"titulo" => "Alta de un País",
				"subtitulo" => "Alta de un País",
				"activo" => "paises",
				"menu" => true,
				"admon" => "admon",
				"errores" => $errores,
				"data" => []
			];
			$this->vista("paisesAltaVista", $datos);
		}
	}

}
