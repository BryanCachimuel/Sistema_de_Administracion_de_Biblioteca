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
			"titulo" => "PaÍses",
			"subtitulo" => "PaÍses",
			"activo" => "paises",
			"menu" => true,
			"data" => $data
		];
		$this->vista("paisesCaratulaVista", $datos);
	}

}
