<?php

class Consultar extends Controlador {

    private $usuario = "";
    private $modelo = "";
    private $sesion;

    function __construct() {
        // Creamos sesión
        $this->sesion = new Sesion();
        if($this->sesion->getLogin()) {
            $this->modelo = $this->modelo("ConsultarModelo");
            $this->usuario = $this->sesion->getUsuario();
        }else {
            header("location:".RUTA);
        }
    }

    public function caratula($value='') {
        $prestamos = $this->modelo->getPrestamos($this->usuario["id"]);
		$datos = [
			"titulo" => "Sistema de biblioteca",
			"subtitulo" => $this->usuario["nombre"]." ".$this->usuario["apellidoPaterno"]." ".$this->usuario["apellidoMaterno"],
			"usuario"=>$this->usuario,
			"prestamos"=>$prestamos,
			"admon"=>false,
			"data"=>[],
			"menu" => true
		];
		$this->vista("consultarCaratulaVista",$datos);
    }

    public function logout() {
        if(isset($_SESSION['usuario'])) {
            $this->sesion->finalizarLogin();
        }
        header("location:".RUTA);
    }
}
