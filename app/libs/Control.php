<?php
class Control {
    private $controlador = "Login";
    private $metodo = "caratula";
    private $parametros = [1,2,3];

    function __construct() {
        $url = $this->separarURL();
        
        if($url != "" && file_exists("../app/controllers/".ucwords($url[0]).".php")) {
            $this->controlador = ucwords($url[0]);
            // se elimina el primer elemento del url
            unset($url[0]);
        }

        // cargar la clase controlador
        require_once("../app/controllers/".ucwords($this->controlador).".php");
        
        // instancia de la clase
        $this->controlador = new $this->controlador;

        // método
        if(isset($url[1])) {
            if(method_exists($this->controlador, $url[1])) {
                $this->metodo = $url[1];
                unset($url[1]);
            }
        }

        // parámetros
        $this->parametros = $url ? array_values($url) : [];

        // ejecutar método
        call_user_func_array([$this->controlador, $this->metodo], $this->parametros);
    }

    public function separarURL() {
        $url = "";
        if(isset($_GET['url'])) {
            // eliminar el caracter final
            $url = rtrim($_GET['url'], "/");
            $url = rtrim($_GET['url'], "\\");

            // sanitizar
            $url = filter_var($url, FILTER_SANITIZE_URL);

            // se regresa dentro de la url
            $url = explode("/", $url);
        }
        return $url;
    }
}