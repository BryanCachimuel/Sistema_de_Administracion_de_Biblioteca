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
		if (isset($_COOKIE['datos'])) {
			$datos_array = explode("|", $_COOKIE['datos']);
			$usuario = $datos_array[0];
			$clave = Helper::desencriptar($datos_array[1]);
			$data = [
				"usuario" => $usuario,
				"clave" => $clave
			];
		} else {
			$data = [];
		}
		$datos = [
			"titulo" => "Paises",
			"subtitulo" => "Paises",
			"data" => $data
		];
		$this->vista("paisesCaratulaVista", $datos);
	}

}
