<?php

class Consultar extends Controlador {

    protected $usuario = "";
    protected $modelo = "";
    protected $sesion;

    function __construct() {
        // Creamos sesión
        $this->sesion = new Sesion();
        if($this->sesion->getLogin()) {
            $this->modelo = $this->modelo("ConsultarModelo");
            $this->usuario = $this->sesion->getUsuario();
        }else {
            header("location:".RUTA);
        }
    }

    public function caratula($value='') {
        $prestamos = $this->modelo->getPrestamos($this->usuario["id"]);
		$datos = [
			"titulo" => "Sistema de biblioteca",
			"subtitulo" => $this->usuario["nombre"]." ".$this->usuario["apellidoPaterno"]." ".$this->usuario["apellidoMaterno"],
			"usuario"=>$this->usuario,
			"prestamos"=>$prestamos,
			"admon" => $this->usuario["tipoUsuario"],
			"data"=>[],
			"menu" => true
		];
		$this->vista("consultarCaratulaVista",$datos);
    }

    public function consultar() {
        // leer los datos de la tabla
        $temas = $this->modelo->getTemas();
        $datos = [
            "titulo"=> "Consultas",
            "subtitulo"=> "Consultas",
            "admon"=> false,
            "temas"=> $temas,
            "menu"=>true
        ];
        $this->vista("consultarConsultarVista",$datos);
    }

    public function consulta() {
        $errores = [];
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $idTema = Helper::cadena($_POST['idTema']??"");
            $nombre = Helper::cadena($_POST['nombre']??"");
            $apellidoPaterno = Helper::cadena($_POST['apellidoPaterno']??"");
            $apellidoMaterno = Helper::cadena($_POST['apellidoMaterno']??"");
            $titulo = Helper::cadena($_POST['titulo']);

            if(empty($nombre) && empty($apellidoPaterno) && empty($apellidoMaterno) && empty($titulo) && $idTema == "void") {
                $this->caratula();
            } else {
                $data = [
                    "idTema" => $idTema,
                    "nombre" => $nombre,
                    "apellidoPaterno" => $apellidoPaterno,
                    "apellidoMaterno" => $apellidoMaterno,
                    "titulo" => $titulo
                ];
                $data = $this->modelo->getLibros($data);

                $datos = [
                    "titulo" => "Consultas",
                    "subtitulo" => "Consultas",
                    "admon" => false,
                    "data" => $data,
                    "menu" => true
                ];
                $this->vista("consultarLibrosVista", $datos);
            }
        }
    }

    public function copias($idLibro='') {
        $libro = $this->modelo->getLibro($idLibro);
        $autores = $this->modelo->getAutores($idLibro);
        $copias = $this->modelo->getCopias($idLibro);
        $datos = [
            "titulo"=> "Consultas",
			"subtitulo" => $libro["categoria"].">".$libro["tema"].">".$libro["titulo"],
			"admon" => false,
			"libros" => $libro,
			"autores" => $autores,
			"copias" => $copias,
			"menu" => true
        ];
        $this->vista("consultarCopiasVista",$datos);
    }

    public function logout() {
        if(isset($_SESSION['usuario'])) {
            $this->sesion->finalizarLogin();
        }
        header("location:".RUTA);
    }
}
