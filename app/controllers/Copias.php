<?php

class Copias extends Controlador {

    private $modelo = "";

    function __construct()
    {
        $this->sesion = new Sesion();
        if ($this->sesion->getLogin()) {
            $this->sesion->finalizarLogin();
        }
        $this->modelo = $this->modelo("CopiasModelo");
    }

    public function caratula($pagina = 1)
    {
        $num = $this->modelo->getNumRegistros();
        $inicio = ($pagina - 1) * TAMANO_PAGINA;
        $totalPaginas = ceil($num / TAMANO_PAGINA);
        $data = $this->modelo->getTabla($inicio, TAMANO_PAGINA);
        $datos = [
            "titulo" => "Copias",
            "subtitulo" => "Copias",
            "activo" => "copias",
            "menu" => true,
            "pag" => [
                "totalPaginas" => $totalPaginas,
                "regresa" => "copias",
                "pagina" => $pagina
            ],
            "data" => $data
        ];
        $this->vista("copiasCaratulaVista", $datos);
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
            $nombre = Helper::cadena($_POST['nombre'] ?? "");
            $apellidoPaterno = Helper::cadena($_POST['apellidoPaterno'] ?? "");
            $apellidoMaterno = Helper::cadena($_POST['apellidoMaterno'] ?? "");
            $idGenero = Helper::cadena($_POST['genero'] ?? "");
            $idPais = Helper::cadena($_POST['idPais'] ?? "");
            //
            // Validamos la información
            // 
            if (empty($nombre)) {
                array_push($errores, "El nombre es requerido.");
            }
            if (empty($apellidoPaterno)) {
                array_push($errores, "El apellido paterno es requerido.");
            }
            if ($idGenero == "void") {
                array_push($errores, "El género es obligatorio.");
            }
            if ($idPais == "void") {
                array_push($errores, "El país es obligatorio.");
            }
            if (empty($errores)) {
                // Crear arreglo de datos
                //
                $data = [
                    "id" => $id,
                    "idPais" => $idPais,
                    "idGenero" => $idGenero,
                    "nombre" => $nombre,
                    "apellidoPaterno" => $apellidoPaterno,
                    "apellidoMaterno" => $apellidoMaterno,
                    "estado" => ""
                ];
                //Enviamos al modelo
                if (trim($id) === "") {
                    //Alta
                    if ($this->modelo->alta($data)) {
                        $this->mensaje(
                            "Alta de un autor(a)",
                            "Alta de un autor(a)",
                            "Se añadió correctamente el autor(a): " . $nombre . " " . $apellidoPaterno,
                            "autores/" . $pag,
                            "success"
                        );
                    } else {
                        $this->mensaje(
                            "Error al añadir un autor(a).",
                            "Error al añadir un autor(a).",
                            "Error al modificar un autor(a): " . $nombre . " " . $apellidoPaterno,
                            "autores/" . $pag,
                            "danger"
                        );
                    }
                } else {
                    //Modificar
                    if ($this->modelo->modificar($data)) {
                        $this->mensaje(
                            "Modificar un autor(a)",
                            "Modificar un autor(a)",
                            "Se modificó correctamente un autor(a): " . $nombre . " " . $apellidoPaterno,
                            "autores/" . $pag,
                            "success"
                        );
                    } else {
                        $this->mensaje(
                            "Error al modificar un autor(a).",
                            "Error al modificar un autor(a).",
                            "Error al modificar un autor(a): " . $nombre . " " . $apellidoPaterno,
                            "autores/" . $pag,
                            "danger"
                        );
                    }
                }
            }
        }
        if (!empty($errores) || $_SERVER['REQUEST_METHOD'] != "POST") {
            //Vista Alta
            $paises = $this->modelo->getCatalogo("paises", "pais");
            $estadosCopias = $this->modelo->getCatalogo("estadosCopias");
            $editoriales = $this->modelo->getEditoriales();
            $libros = $this->modelo->getLibros();
            $datos = [
                "titulo" => "Alta de una copia",
                "subtitulo" => "Alta de una copia",
                "activo" => "copias",
                "menu" => true,
                "admon" => "admon",
                "paises" => $paises,
                "estadosCopias" => $estadosCopias,
                "libros" => $libros,
                "editoriales" => $editoriales,
                "pag" => $pag,
                "errores" => $errores,
                "data" => []
            ];
            $this->vista("copiasAltaVista", $datos);
        }
    }

    public function borrar($id = "", $pag = 1)
    {
        //Leemos los datos del registro del id
        $data = $this->modelo->getAutorId($id);
        $paises = $this->modelo->getCatalogo("paises");
        $genero = $this->modelo->getCatalogo("genero");
        //Vista baja
        $datos = [
            "titulo" => "Baja de un autor(a)",
            "subtitulo" => "Baja de un autor(a)",
            "menu" => true,
            "admon" => "admon",
            "errores" => [],
            "pag" => $pag,
            "paises" => $paises,
            "genero" => $genero,
            "activo" => 'autores',
            "data" => $data,
            "baja" => true
        ];
        $this->vista("autoresAltaVista", $datos);
    }


    public function bajaLogica($id = '', $pag = 1)
    {
        if (isset($id) && $id != "") {
            if ($this->modelo->bajaLogica($id)) {
                $this->mensaje(
                    "Borrar un autor(a)",
                    "Borrar un autor(a)",
                    "Se borró correctamente un autor(a).",
                    "autores/" . $pag,
                    "success"
                );
            } else {
                $this->mensaje(
                    "Error al borrar un autor(a)",
                    "Error al borrar un autor(a)",
                    "Error al borrar un autor(a).",
                    "autores/" . $pag,
                    "danger"
                );
            }
        }
    }

    public function modificar($id, $pag = 1)
    {
        //Leemos los datos de la tabla
        $data = $this->modelo->getAutorId($id);
        $paises = $this->modelo->getCatalogo("paises", "pais");
        $genero = $this->modelo->getCatalogo("genero");
        $datos = [
            "titulo" => "Modificar un autor(a)",
            "subtitulo" => "Modificar un autor(a)",
            "activo" => "autores",
            "menu" => true,
            "admon" => "admon",
            "paises" => $paises,
            "genero" => $genero,
            "pag" => $pag,
            "errores" => [],
            "data" => $data
        ];
        $this->vista("autoresAltaVista", $datos);
    }

   
}
