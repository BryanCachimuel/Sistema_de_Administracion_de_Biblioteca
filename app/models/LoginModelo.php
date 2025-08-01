<?php

class LoginModelo {

    private $db = "";

    function __construct() {
        $this->db = new MySQLdb();
    }

    public function buscarCorreo($usuario='') {
        if(empty($usuario)) return false;
        $sql = "SELECT * FROM usuarios WHERE correo='".$usuario."'";
        return $this->db->query($sql);
    }

    public function enviarCorreo($email=''){
        $data = [];
        if($email == ""){
            return false;
        }else{
            $data = ["id"=>1]; // $this->validarCorreo($email);
            if(!empty($data)){
                $id = $data["id"];
                $msg = "Entra a el siguiente enlace para cambiar tu contraseña de acceso al sistema de biblioteca...<br>";
				$msg.= "<a href='".RUTA."login/cambiarclave/".$id."'>Cambiar tu contraseña de acceso</a>";

                $headers = "MIME-Version: 1.0\r\n"; 
				$headers.= "Content-type:text/html; charset=UTF-8\r\n"; 
				$headers.= "From: Biblioteca\r\n"; 
				$headers.= "Reply-to: bryanloyo56@gmail.com\r\n";

                $asunto = "Cambiar Contraseña de Acceso";
                //var_dump($msg);
                //return true;
                return @mail($email,$asunto,$msg,$headers);
            }else{

            }
        }
    }
}