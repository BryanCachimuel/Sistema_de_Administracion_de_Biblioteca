<?php
class Helper {

    public static function mostrar($data='', $detener=true) {
        print "<pre>";
        var_dump($data);
        print "</pre>";
        if($detener) {
            exit;
        }
    }

    public static function encriptar($data) {
        return base64_encode(LLAVE1.$data.LLAVE2);
    }

    public static function desencriptar($data) {
        $cadena = base64_decode($data);
        $cadena = str_replace(LLAVE1,"",$cadena);
        return str_replace(LLAVE2,"",$cadena);
    }

}