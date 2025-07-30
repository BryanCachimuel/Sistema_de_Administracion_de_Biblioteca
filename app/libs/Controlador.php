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

}
