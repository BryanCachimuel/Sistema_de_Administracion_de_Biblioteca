<?php

class LoginModelo extends Llaves{

    protected $db = "";

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

    public function actualizarClaveAcceso($data='') {
		if ($data!="") {
			$sql = "UPDATE usuarios SET clave=:clave WHERE id=:id";
			return $this->db->queryNoSelect($sql,$data);
		}
		return false;
	}

    public function getUsuarioId($id='') {
		if(empty($id)) return false;
		$sql = "SELECT * FROM usuarios WHERE id='".$id."'";
		return $this->db->query($sql);
	}


    public function registrar($data){

		if(empty($data)) return false;
        $sql = "INSERT INTO usuarios VALUES(0,"; //1. id 
        $sql.= "'".$data['idTipoUsuario']."', "; //2. tipo
        $sql.= "'".$data['nombre']."', ";    	//3. nombre
        $sql.= "'".$data['apellidoPaterno']."', "; //4. apellido paterno
        $sql.= "'".$data['apellidoMaterno']."', "; //5. Apellido Materno	   
        $sql.= "'".$data['correo']."', ";    	//6. correo
        $sql.= "'".$data['clave']."', ";     	//7. clave de acceso
        $sql.= "'".$data['genero']."', ";    	//8. genero
        $sql.= "'".$data['telefono']."', ";    	//9. telefono
        $sql.= "'".$data['fechaNacimiento']."', ";  //10. fecha nacimieto
        $sql.= "'".$data['estado']."', ";    	//11. estado
        //
        $sql.= "'0', ";                          //12. baja lógica
        $sql.= "'', ";                           //13. fecha login
        $sql.= "NOW(),";                         //14. fecha alta-creado
        $sql.= "'', ";                           //15. fecha baja
        $sql.= "'')";                            //16. fecha modificado                        
        return $this->db->queryNoSelect($sql);
	 }

    public function usuarioAutorizar($id='',$clave='') {
		if($id=="") return false;
		$sql = "UPDATE usuarios SET ";
		$sql.= "estado='".USUARIO_ACTIVO."',";
		$sql.= "clave='".$clave."',";
		$sql.= "modifica_dt=NOW() ";
		$sql.= "WHERE id=".$id;
		return $this->db->queryNoSelect($sql);
	}


     public function enviarCorreoRegistro($data="",$clave="") {
        if(!empty($data)) {
            $datos = $this->buscarCorreo($data["correo"]);
            $id = Helper::encriptar($datos["id"]);
            $msg = "Entre en el siguiente enlace para confirmar su acceso al sistema de la biblioteca. Tu clave de acceso es: ".$clave."<br>";
            $msg.= "<a href='".RUTA."login/registroConfirmar/".$id."'>Confirmar su registro</a>";
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type:text/html; charset=UTF-8\r\n";
            $headers .= "FROM: Biblioteca\r\n";
            $headers .= "Reply-to: bryanloyo56@gmail.com\r\n";
            $asunto = "Confirmar su registro";
            var_dump($msg);
            //exit;
            return @mail($email,$asunto,$msg,$headers);
        }else {
            return false;
        }
     }


}