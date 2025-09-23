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
        $errores = [];
        $pag = 1;

        //Recibimos la información de la vista
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //
            $id = $_POST['id'] ?? "";
            $pag = $_POST['pag'] ?? "1";
            $clave = Helper::cadena($_POST['clave'] ?? "");
            $idLibro = Helper::cadena($_POST['idLibro'] ?? "");
            $copia = Helper::cadena($_POST['copia'] ?? "");
            $anio = Helper::cadena($_POST['anio'] ?? "");
            $isdn = Helper::cadena($_POST['isdn'] ?? "");
            $edicion = Helper::cadena($_POST['edicion'] ?? "");
            $paginas = Helper::cadena($_POST['paginas'] ?? "");
            $idEditorial = Helper::cadena($_POST['idEditorial'] ?? "");
            $idPais = Helper::cadena($_POST['idPais'] ?? "");
            $estado = Helper::cadena($_POST['estado'] ?? "");
            //
            // Validamos la información
            // 
            if (empty($clave)) {
                array_push($errores, "La clave es requerida.");
            }
            if ($idLibro == "void") {
                array_push($errores, "El libro es requerido.");
            }
            if ($idEditorial == "void") {
                array_push($errores, "La editorial es requerida.");
            }
            if ($idPais == "void") {
                array_push($errores, "El país es requerido.");
            }
            if (empty($errores)) {
                // Crear arreglo de datos
                //
                $data = [
                    "id" => $id,
                    "idLibro" => $idLibro,
                    "idEditorial" => $idEditorial,
                    "idPais" => $idPais,
                    "clave" => $clave,
                    "copia" => $copia,
                    "anio" => $anio,
                    "isdn" => $isdn,
                    "edicion" => $edicion,
                    "paginas" => $paginas,
                    "estado" => $estado
                ];
                //Enviamos al modelo
                if (trim($id) === "") {
                    //Alta
                    if ($this->modelo->alta($data)) {
                        $this->mensaje(
                            "Alta de una copia",
                            "Alta de una copia",
                            "Se añadió correctamente la copia: " . $clave,
                            "copias/" . $pag,
                            "success"
                        );
                    } else {
                        $this->mensaje(
                            "Error al añadir una copia",
                            "Error al añadir una copia",
                            "Error al modificar una copia: " . $clave,
                            "copias/" . $pag,
                            "danger"
                        );
                    }
                } else {
                    //Modificar
                    if ($this->modelo->modificar($data)) {
                        $this->mensaje(
                            "Modificar una copia",
                            "Modificar una copia",
                            "Se modificó correctamente la copia: " . $clave." ".$copia,
                            "copias/" . $pag,
                            "success"
                        );
                    } else {
                        $this->mensaje(
                            "Error al modificar una copia",
                            "Error al modificar una copia",
                            "Error al modificar una copia: " . $clave,
                            "copias/" . $pag,
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
        $data = $this->modelo->getCopiasId($id);
        $paises = $this->modelo->getCatalogo("paises","pais");
        $estadosCopias = $this->modelo->getCatalogo("estadosCopias");
        $editoriales = $this->modelo->getEditoriales();
        $libros = $this->modelo->getLibros();
        //Vista baja
        $datos = [
            "titulo" => "Baja de una copia",
            "subtitulo" => "Baja de una copia",
            "menu" => true,
            "admon" => "admon",
            "errores" => [],
            "pag" => $pag,
            "paises" => $paises,
            "estadosCopias" => $estadosCopias,
            "editoriales" => $editoriales,
            "libros" => $libros,
            "activo" => 'copias',
            "data" => $data,
            "baja" => true
        ];
        $this->vista("copiasAltaVista", $datos);
    }


    public function bajaLogica($id = '', $pag = 1)
    {
        if (isset($id) && $id != "") {
            if ($this->modelo->bajaLogica($id)) {
                $this->mensaje(
                    "Borrar una copia",
                    "Borrar una copia",
                    "Se borró correctamente una copia.",
                    "copias/" . $pag,
                    "success"
                );
            } else {
                $this->mensaje(
                    "Error al borrar una copia",
                    "Error al borrar una copia",
                    "Error al borrar una copia",
                    "copias/" . $pag,
                    "danger"
                );
            }
        }
    }

    public function modificar($id, $pag = 1)
    {
        //Leemos los datos de la tabla
        $data = $this->modelo->getCopiasId($id);
        $paises = $this->modelo->getCatalogo("paises","pais");
        $estadosCopias = $this->modelo->getCatalogo("estadosCopias");
        $editoriales = $this->modelo->getEditoriales();
        $libros = $this->modelo->getLibros();
        $datos = [
            "titulo" => "Modificar una copia",
            "subtitulo" => "Modificar una copia",
            "activo" => "copias",
            "menu" => true,
            "admon" => "admon",
            "paises" => $paises,
            "estadosCopias" => $estadosCopias,
            "editoriales" => $editoriales,
            "libros" => $libros,
            "pag" => $pag,
            "errores" => [],
            "data" => $data
        ];
        $this->vista("copiasAltaVista", $datos);
    }

   
}
