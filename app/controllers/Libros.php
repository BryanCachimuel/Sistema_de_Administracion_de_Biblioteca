<?php

/**
 * 
 */
class Libros extends Controlador {

    private $modelo = "";

    function __construct()
    {
        $this->sesion = new Sesion();
        if ($this->sesion->getLogin()) {
            $this->sesion->finalizarLogin();
        }
        $this->modelo = $this->modelo("LibrosModelo");
    }

    public function caratula($pagina = 1)
    {
        $num = $this->modelo->getNumRegistros();
        $inicio = ($pagina - 1) * TAMANO_PAGINA;
        $totalPaginas = ceil($num / TAMANO_PAGINA);
        $data = $this->modelo->getTabla($inicio, TAMANO_PAGINA);
        $datos = [
            "titulo" => "Libros",
            "subtitulo" => "Libros",
            "activo" => "libros",
            "menu" => true,
            "pag" => [
                "totalPaginas" => $totalPaginas,
                "regresa" => "libros",
                "pagina" => $pagina
            ],
            "data" => $data
        ];
        $this->vista("librosCaratulaVista", $datos);
    }

    public function alta()
    {
        //Definir los arreglos
        $data = [];
        $errores = array();
        $pag = 1;

        //Recibimos la información de la vista
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //
            $id = $_POST['id'] ?? "";
            $pag = $_POST['pag'] ?? "1";
            $idTema = Helper::cadena($_POST['idTema'] ?? "");
            $idIdioma = Helper::cadena($_POST['idIdioma'] ?? "");
            $titulo = Helper::cadena($_POST['titulo'] ?? "");
            
            // Validamos la información
            if (empty($titulo)) {
                array_push($errores, "El título es requerido.");
            }

            if ($idTema == "void") {
                array_push($errores, "El tema es requerido.");
            }
            if ($idIdioma == "void") {
                array_push($errores, "El idioma es requerido.");
            }
            if (empty($errores)) {
                // Crear arreglo de datos
                $data = [
                    "id" => $id,
                    "idIdioma" => $idIdioma,
                    "idTema" => $idTema,
                    "titulo" => $titulo,
                    "estado" => ""
                ];
                //Enviamos al modelo
                if (trim($id) === "") {
                    //Alta
                    if ($this->modelo->alta($data)) {
                        $this->mensaje(
                            "Alta de un libro",
                            "Alta de un libro",
                            "Se añadió correctamente el libro: " . $titulo,
                            "libros/" . $pag,
                            "success"
                        );
                    } else {
                        $this->mensaje(
                            "Error al añadir un libro.",
                            "Error al añadir un libro.",
                            "Error al modificar un libro: " . $titulo,
                            "libros/" . $pag,
                            "danger"
                        );
                    }
                } else {
                    //Modificar
                    if ($this->modelo->modificar($data)) {
                        $this->mensaje(
                            "Modificar un libro",
                            "Modificar un libro",
                            "Se modificó correctamente un libro: " . $titulo,
                            "libros/" . $pag,
                            "success"
                        );
                    } else {
                        $this->mensaje(
                            "Error al modificar un libro.",
                            "Error al modificar un libro.",
                            "Error al modificar un libro: " . $titulo,
                            "libros/" . $pag,
                            "danger"
                        );
                    }
                }
            }
        }
        // preparación de la vista
        if (!empty($errores) || $_SERVER['REQUEST_METHOD'] != "POST") {
            $idiomas = $this->modelo->getCatalogo("idiomas", "idioma");
            $temas = $this->modelo->getCatalogo("temas","tema");
            $datos = [
                "titulo" => "Alta de un libro",
                "subtitulo" => "Alta de un libro",
                "activo" => "libros",
                "menu" => true,
                "admon" => "admon",
                "idiomas" => $idiomas,
                "temas" => $temas,
                "pag" => $pag,
                "errores" => $errores,
                "data" => []
            ];
            $this->vista("librosAltaVista", $datos);
        }
    }

    public function borrar($id = "", $pag = 1)
    {
        //Leemos los datos del registro del id
        $data = $this->modelo->getLibroId($id);
        $idiomas = $this->modelo->getCatalogo("idiomas", "idioma");
        $temas = $this->modelo->getCatalogo("temas","tema");
        //Vista baja
        $datos = [
            "titulo" => "Baja de un libro",
            "subtitulo" => "Baja de un libro",
            "menu" => true,
            "admon" => "admon",
            "errores" => [],
            "pag" => $pag,
            "idiomas" => $idiomas,
            "temas" => $temas,
            "activo" => 'libros',
            "data" => $data,
            "baja" => true
        ];
        $this->vista("librosAltaVista", $datos);
    }


    public function bajaLogica($id = '', $pag = 1)
    {
        if (isset($id) && $id != "") {
            if ($this->modelo->bajaLogica($id)) {
                $this->mensaje(
                    "Borrar un libro",
                    "Borrar un libro",
                    "Se borró correctamente un libro.",
                    "libros/" . $pag,
                    "success"
                );
            } else {
                $this->mensaje(
                    "Error al borrar un libro",
                    "Error al borrar un libro",
                    "Error al borrar un libro.",
                    "libros/" . $pag,
                    "danger"
                );
            }
        }
    }

    public function modificar($id, $pag = 1)
    {
        //Leemos los datos de la tabla
        $data = $this->modelo->getLibroId($id);
        $idiomas = $this->modelo->getCatalogo("idiomas", "idioma");
        $temas = $this->modelo->getCatalogo("temas","tema");
        $datos = [
            "titulo" => "Modificar un libro",
            "subtitulo" => "Modificar un libro",
            "activo" => "libros",
            "menu" => true,
            "admon" => "admon",
            "idiomas" => $idiomas,
            "temas" => $temas,
            "pag" => $pag,
            "errores" => [],
            "data" => $data
        ];
        $this->vista("librosAltaVista", $datos);
    }

    /* Autores - Libros */
    public function autoresLibros($idAutor) {
        // leemos los datos de la tabla
        $data = $this->modelo->getLibrosAutoresTabla($idAutor);
        $autor = $this->modelo->getAutorId($idAutor);
        $nombre = $autor["nombre"]." ".$autor["apellidoPaterno"]." ".$autor["apellidoMaterno"];
        $datos = [
            "titulo"=> "Libros",
            "subtitulo"=> "Libros de: ".$nombre,
            "admon"=> "admon",
            "activo"=> "autores",
            "data"=> $data,
            "idAutor"=> $idAutor,
            "menu"=> true
        ];
        $this->vista("autoresLibrosCaratulaVista",$datos);
    }

    public function autoresLibrosAlta($idAutor="") {
        // definir los arreglos
        $data = array();
        $errores = array();
        if(!empty($errores) || $_SERVER['REQUEST_METHOD']!="POST") {
            // alta de un libro
            $libros = $this->modelo->getLibros();
            $autor = $this->modelo->getAutorId();
            $nombre = $autor["nombre"]." ".$autor["apellidoPaterno"]." ".$autor["apellidoMaterno"];
            $datos = [
                "titulo"=> "Dar de alta a un libro",
                "subtitulo"=> "Dar de alta a un libro para: ".$nombre,
                "activo"=> "autores",
                "menu"=> false,
                "admon"=> "admon",
                "errores"=> $errores,
                "idAutor"=> $idAutor,
                "data"=> $libros, 
            ];
            $this->vista("autoresLibrosCaratulaVista",$datos);
        }
    }
}
