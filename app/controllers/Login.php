<?php

class Login extends Controlador{

    private $modelo = "";

    function __construct() {
        $this->modelo = $this->modelo("LoginModelo");
    }

    public function caratula() {
       $datos = [
        "titulo" => "Entrada a la Biblioteca",
        "subtitulo" => "Sistema de Biblioteca"
       ];
       $this->vista("loginCaratulaVista", $datos);
    }

    public function olvido() {
       $datos = [
        "titulo" => "Olvido de Contraseña",
        "subtitulo" => "¿Olvidaste tu contraseña?"
       ];
       $this->vista("loginOlvidoVista", $datos);
    }
}