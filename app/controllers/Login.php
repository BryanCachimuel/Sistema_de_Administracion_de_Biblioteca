<?php

class Login extends Controlador
{

    private $modelo = "";

    function __construct()
    {
        $this->modelo = $this->modelo("LoginModelo");
    }

    public function caratula()
    {
        $datos = [
            "titulo" => "Entrada a la Biblioteca",
            "subtitulo" => "Sistema de Biblioteca"
        ];
        $this->vista("loginCaratulaVista", $datos);
    }

    /* ?? -> validación de null */
    public function olvidoVerificar()
    {
        $errores = [];
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $usuario = $_POST['usuario'] ?? "";

            // validación de que el correo no debe estar vacío
            if (empty($usuario)) {
                array_push($errores, "El correo electrónico es requerido");
            }

            // validar el correo si esta bien descrito de acuerdo a sus estandares
            if (filter_var($usuario, FILTER_VALIDATE_EMAIL) == false) {
                array_push($errores, "El correo electrónico no está bien escrito");
            }

            if (empty($errores)) {
                // enviando los datos
                if ($this->modelo->buscarCorreo($usuario)) {
                    if ($this->modelo->enviarCorreo($usuario)) {
                        $datos = [
                            "titulo" => "Cambio de contraseña de acceso",
                            "menu" => false,
                            "errores" => [],
                            "data" => [],
                            "subtitulo" => "Cambio de contraseña de acceso",
                            "texto" => "Se ha enviado un correo a <b>".$usuario."</b> para que puedas cambiar tu contraseña de acceso. Cualquier duda te puedes comunicar con nosotros. No olvides revisar tu bandeja de spam.",
                            "color" => "alert-warning",
                            "url" => "login",
                            "colorBoton" => "btn-warning",
                            "textoBoton" => "Regresar"
                        ];
                        $this->vista("mensaje", $datos);
                        exit();
                    } else {
                        Helper::mostrar("No se envió el correo");
                    }
                } else {
                    Helper::mostrar("No se encontró el correo");
                }
            }
        }
        $datos = [
            "titulo" => "Olvido de Contraseña",
            "subtitulo" => "¿Olvidaste tu contraseña?",
            "errores" => $errores,
            "data" => []
        ];
        $this->vista("loginOlvidoVista", $datos);
    }
}
