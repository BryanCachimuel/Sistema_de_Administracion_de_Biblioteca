<?php
class Controlador {

    public function modelo($modelo='') {
        if(file_exists("../app/models/".$modelo.".php")){
            require_once("../app/models/".$modelo.".php");
            return new $modelo;
        } else {
            die("El modelo " .$modelo. " no existe");
        }
    }

    public function vista($vista='', $datos=[]) {
       if(file_exists("../app/views/".$vista.".php")){
            require_once("../app/views/".$vista.".php");
        } else {
            die("La vista " .$vista. " no existe");
        } 
    }

    public function mensaje($titulo="",$subtitulo,$texto,$url,$color,$url2="",$color2="",$texto2=""){
        $datos = [
            "titulo" => $titulo,
            "menu" => true,
            "errores" => [],
            "data" => [],
            "subtitulo" => $subtitulo,
            "texto" => $texto,
            "url" => $url,
            "color" => "alert-".$color,
            "colorBoton" => "btn-".$color,
            "textoBoton" => "Regresar",
            "url2" => $url2,
            "colorBoton2" => "btn-".$color2,
            "textoBoton2" => $texto2
        ];
        $this->vista("mensaje", $datos);
    }

}
