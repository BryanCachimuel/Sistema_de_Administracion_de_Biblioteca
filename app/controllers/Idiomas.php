<?php

class Idiomas extends Controlador {
	private $modelo = "";
	
	function __construct() {
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->sesion->finalizarLogin();
		}
		$this->modelo = $this->modelo("IdiomasModelo");
	}

	public function caratula($pagina=1) {
		$num = $this->modelo->getNumRegistros();
		$inicio = ($pagina-1)*TAMANO_PAGINA;
		$totalPaginas = ceil($num/TAMANO_PAGINA);
		$data = $this->modelo->getTabla($inicio,TAMANO_PAGINA);	
		$datos = [
			"titulo" => "Idiomas",
			"subtitulo" => "Idiomas",
			"activo" => "idiomas",
			"menu" => true,
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "idiomas",
				"pagina" => $pagina
			],
			"data" => $data
		];
		$this->vista("idiomasCaratulaVista",$datos);
	}

	public function alta() {
	 
	   
  	}

  	public function borrar($id="",$pag=1) {
	  
	}

	public function bajaLogica($id='',$pag=1) {
	  
	}

  	public function modificar($id,$pag) {
		
	}
}
