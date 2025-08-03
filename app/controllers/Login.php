<?php

class Login extends Controlador
{

    private $modelo = "";

    function __construct() {
        $this->sesion = new Sesion();
        if($this->sesion->getLogin()) {
            $this->sesion->finalizarLogin();
        }
        $this->modelo = $this->modelo("LoginModelo");
    }

    public function caratula() {
        if (isset($_COOKIE['datos'])) {
            $datos_array = explode("|",$_COOKIE['datos']);
            $usuario = $datos_array[0];
            $clave = Helper::desencriptar($datos_array[1]);
            $data = [
                "usuario" => $usuario,
                "clave" => $clave
            ];
        }else {
            $data = [];
        }
        $datos = [
            "titulo" => "Entrada a la Biblioteca",
            "subtitulo" => "Sistema de Biblioteca",
            "data" => $data
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
                    // la negación debe ser cambiada cuando se valide el proceso de envió de correos
                    if (!$this->modelo->enviarCorreo($usuario)) {
                        $datos = [
                            "titulo" => "Cambio de contraseña de acceso",
                            "menu" => false,
                            "errores" => [],
                            "data" => [],
                            "subtitulo" => "Cambio de contraseña de acceso",
                            "texto" => "Se ha enviado un correo a <b>".$usuario."</b> para que puedas cambiar tu contraseña de acceso. Cualquier duda te puedes comunicar con nosotros. No olvides revisar tu bandeja de spam.",
                            "color" => "alert-success",
                            "url" => "login",
                            "colorBoton" => "btn-success",
                            "textoBoton" => "Regresar"
                        ];
                        $this->vista("mensaje", $datos);
                    } else {
                        $datos = [
                            "titulo" => "Error al cambiar la contraseña de acceso",
                            "menu" => false,
                            "errores" => [],
                            "data" => [],
                            "subtitulo" => "Error al cambiar la contraseña de acceso",
                            "texto" => "Error al enviar un correo a <b>".$usuario."</b> para que puedas cambiar tu contraseña de acceso. Cualquier duda te puedes comunicar con nosotros. Inténtalo mas tarde.",
                            "color" => "alert-danger",
                            "url" => "login",
                            "colorBoton" => "btn-danger",
                            "textoBoton" => "Regresar"
                        ];
                        $this->vista("mensaje", $datos);
                    }
                    exit();
                } else {
                    array_push($errores, "No existe el correo electrónico en la base de datos");
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

    public function cambiarClave($id='') {
        $id = Helper::desencriptar($id);
        $errores = [];
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $clave1 = $_POST['clave'] ?? "";
            $clave2 = $_POST['verifica'] ?? "";
            $id = $_POST['id'] ?? "";
            
            if(empty($clave1)){
                array_push($errores,"La contraseña de acceso es requerida");
            }
            if(empty($clave2)){
                array_push($errores,"La contraseña de acceso de verificación es requerida");
            }
            if($clave1 != $clave2){
                array_push($errores,"Las contraseñas de acceso no coinciden");
            }
            if(count($errores) == 0) {
                $clave = hash_hmac("sha512", $clave1, CLAVE);
                $data = ["clave"=>$clave, "id"=>$id];
                if($this->modelo->actualizarClaveAcceso($data)) {
                    $datos = [
                        "titulo" => "Cambio de contraseña de acceso",
                        "menu" => false,
                        "errores" => [],
                        "data" => [],
                        "subtitulo" => "Cambio de contraseña de acceso",
                        "texto" => "La contraseña de acceso se modificó correctamente",
                        "color" => "alert-success",
                        "url" => "login",
                        "colorBoton" => "btn-success",
                        "textoBoton" => "Regresar"
                    ];
                    $this->vista("mensaje", $datos);
                }else {
                    $datos = [
                        "titulo" => "Cambio de contraseña de acceso",
                        "menu" => false,
                        "errores" => [],
                        "data" => [],
                        "subtitulo" => "Cambio de contraseña de acceso",
                        "texto" => "Existio un error al actualizar la contraseña de acceso. Favor de intentarlo más tarde o reportarlo a soporte técnico",
                        "color" => "alert-danger",
                        "url" => "login",
                        "colorBoton" => "btn-danger",
                        "textoBoton" => "Regresar"
                    ];
                    $this->vista("mensaje", $datos);
                }
                exit();
            }
        }
        $datos = [
            "titulo" => "Cambiar Contraseña",
            "subtitulo" => "Cambiar Contraseña",
            "errores" => $errores,
            "data" => $id
        ];
        $this->vista("loginCambiarVista", $datos);
    }

    public function verificar() {
        $errores = [];
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $id = $_POST["id"] ?? "";
            $usuario = $_POST['usuario'] ?? "";
            $clave = $_POST['clave'] ?? "";
            $recordar = isset($_POST['recordar'])?"on":"off";
            // recordar
            $valor = $usuario."|".Helper::encriptar($clave);
            if($recordar == "on") {
                $fecha = time()+(60*60*24*7);
            }else {
                 $fecha = time() - 1;
            }
            setcookie("datos",$valor,$fecha,RUTA);

            if(empty($clave)){
                array_push($errores, "La clave de acceso es requerida");
            }

            if(empty($usuario)) {
                array_push($errores, "La usuario es requerido");
            }

            if(count($errores) == 0) {
                $clave = hash_hmac("sha512", $clave, CLAVE);
                $data = $this->modelo->buscarCorreo($usuario);

                if($data && $data["clave"] == $clave) {
                    $sesion = new Sesion();
                    $sesion->iniciarLogin($data);
                    header("location:".RUTA."tablero");
                    Helper::mostrar($sesion->getLogin());
                }else {
                    $datos = [
                        "titulo" => "Sistema de Biblioteca",
                        "menu" => false,
                        "errores" => [],
                        "data" => [],
                        "subtitulo" => "Sistema de Biblioteca",
                        "texto" => "Existió un error al entrar al sistema. Favor de intentar nuevamente",
                        "color" => "alert-danger",
                        "url" => "login",
                        "colorBoton" => "btn-danger",
                        "textoBoton" => "Regresar"
                    ];
                    $this->vista("mensaje",$datos);
                }
                exit;
            }
        }
    }
}
