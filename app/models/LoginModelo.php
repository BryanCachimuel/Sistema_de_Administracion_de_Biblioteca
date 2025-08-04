<?php

class LoginModelo {

    private $db = "";

    function __construct() {
        $this->db = new MySQLdb();
    }

    public function buscarCorreo($usuario='') {
        if(empty($usuario)) return false;
        $sql = "SELECT id, nombre, apellidoPaterno, apellidoMaterno, clave, correo FROM usuarios WHERE correo='".$usuario."'";
        return $this->db->query($sql);
    }

    public function enviarCorreo($email=''){
        $data = [];
        if($email == ""){
            return false;
        }else{
            $data = $this->buscarCorreo($email);
            if(!empty($data)){
                $id = Helper::encriptar($data["id"]);
                $msg = "Entra a el siguiente enlace para cambiar tu contraseña de acceso al sistema de biblioteca...<br>";
				$msg.= "<a href='".RUTA."login/cambiarClave/".$id."'>Cambiar tu contraseña de acceso</a>";

                $headers = "MIME-Version: 1.0\r\n"; 
				$headers.= "Content-type:text/html; charset=UTF-8\r\n"; 
				$headers.= "From: Biblioteca\r\n"; 
				$headers.= "Reply-to: bryanloyo56@gmail.com\r\n";

                $asunto = "Cambiar Contraseña de Acceso";
                Helper::mostrar($msg);
                return true;
                //return @mail($email,$asunto,$msg,$headers);
            }else{

            }
        }
    }

    public function actualizarClaveAcceso($data='',$tipo=''){
        if($data != "") {
            if($tipo == "p") {
                $sql = "UPDATE profesores SET clave=:clave WHERE id=:id";
            }else if($tipo == "a") {
                $sql = "UPDATE alumnos SET clave=:clave WHERE id=:id";
            }else {
                return false;
            }
            return $this->db->queryNoSelect($sql,$data);
        }
        return false;
    }
}