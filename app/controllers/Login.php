<?php

class Login extends Controlador{

    private $modelo = "";

    function __construct() {
        $this->modelo = $this->modelo("LoginModelo");
    }

    public function caratula($value='') {
       $datos = [];
       $this->vista("loginCaratulaVista", $datos);
    }
}