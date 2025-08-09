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

    public static function cadena($cadena) {
        // si se ingresan estas palabras se las reemplaza por las de la siguiente línea
        $buscar = array('^','delete','drop','truncate','exec','system');
        $reemplazar = array('-','dele*te','dr*op','trun*cate','ex*ec','syst*em');
        $cadena = trim(str_replace($buscar,$reemplazar,$cadena));
        $cadena = addslashes(htmlentities($cadena));
        return $cadena;
    }

    public static function fecha($cadena="") {
        // formato de fecha ISO AAAA-MM-DD
        $salida = false;
        if($cadena != "") {
            $fecha_array = explode("-", $cadena);
            $salida = checkdate($fecha_array[1], $fecha_array[2], $fecha_array[0]);
        }
        return $salida;
    }

    public static function correo($correo = "") {
        return filter_var($correo, FILTER_VALIDATE_EMAIL);
    } 


    public static function generarClave($lon){
      $llave = "";
      $cadena = "1234567890ABCDEFGHIJKLMNOPQRSTUVXYZabcdefghijklmnopqrstuvwxyz+*-_";
      $max = strlen($cadena)-1;
      for($i = 0; $i < $lon; $i++){
          $llave .= substr($cadena, mt_rand(0,$max), 1);
      }
      return $llave;
  }

}