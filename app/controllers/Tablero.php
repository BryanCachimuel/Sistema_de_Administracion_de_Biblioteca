<?php

class Tablero extends Controlador {

    private $usuario = "";
    private $modelo = "";
    private $sesion;

    function __construct() {
        // Creamos sesión
        $this->sesion = new Sesion();
        if($this->sesion->getLogin()) {
            $this->modelo = $this->modelo("TableroModelo");
            $this->usuario = $this->sesion->getUsuario();
        }else {
            header("location:".RUTA);
        }
    }

    public function caratula($value='') {
        $datos = [
            "titulo" => "Sistema de Biblioteca",
            "subtitulo" => $this->usuario["nombre"]." ".$this->usuario["apellidoPaterno"]." ".$this->usuario["apellidoMaterno"],
			"usuario"=>$this->usuario,
            "admon"=>ADMON,
			"data"=>[],
			"menu" => true
        ];
        $this->vista("tableroCaratulaVista",$datos);
    }

    public function logout() {
        if(isset($_SESSION['usuario'])) {
            $this->sesion->finalizarLogin();
        }
        header("location:".RUTA);
    }
}
