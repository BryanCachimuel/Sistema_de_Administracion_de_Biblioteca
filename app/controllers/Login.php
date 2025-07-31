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

    /* ?? -> validación de null */
    public function olvidoVerificar() {
        $errores = [];
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $usuario = $_POST['usuario']??""; 

            // validación de que el correo no debe estar vacío
            if(empty($usuario)){
                array_push($errores, "El correo electrónico es requerido");
            }

            // validar el correo si esta bien descrito de acuerdo a sus estandares
            if(filter_var($usuario, FILTER_VALIDATE_EMAIL) == false){
                 array_push($errores, "El correo electrónico no está bien escrito");
            }

            if(empty($errores)){
                Helper::mostrar($usuario);
            }
            Helper::mostrar($errores);

        }
       $datos = [
        "titulo" => "Olvido de Contraseña",
        "subtitulo" => "¿Olvidaste tu contraseña?"
       ];
       $this->vista("loginOlvidoVista", $datos);
    }
}