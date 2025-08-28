<?php

/**
 * 
 */
class Autores extends Controlador
{

    private $modelo = "";

    function __construct()
    {
        $this->sesion = new Sesion();
        if ($this->sesion->getLogin()) {
            $this->sesion->finalizarLogin();
        }
        $this->modelo = $this->modelo("AutoresModelo");
    }

    public function caratula($pagina = 1)
    {
        $num = $this->modelo->getNumRegistros();
        $inicio = ($pagina - 1) * TAMANO_PAGINA;
        $totalPaginas = ceil($num / TAMANO_PAGINA);
        $data = $this->modelo->getTabla($inicio, TAMANO_PAGINA);
        $datos = [
            "titulo" => "Autores",
            "subtitulo" => "Autores",
            "activo" => "autores",
            "menu" => true,
            "pag" => [
                "totalPaginas" => $totalPaginas,
                "regresa" => "autores",
                "pagina" => $pagina
            ],
            "data" => $data
        ];
        $this->vista("autoresCaratulaVista", $datos);
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
                            "Se modificó correctamente un autor(a): " . $nombre." ".$apellidoPaterno,
                            "autores/" . $pag,
                            "success"
                        );
                    } else {
                        $this->mensaje(
                            "Error al modificar un autor(a).",
                            "Error al modificar un autor(a).",
                            "Error al modificar un autor(a): " . $nombre." ".$apellidoPaterno,
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
            $genero = $this->modelo->getCatalogo("genero");
            $datos = [
                "titulo" => "Alta de un autor(a)",
                "subtitulo" => "Alta de un autor(a)",
                "activo" => "autores",
                "menu" => true,
                "admon" => "admon",
                "paises" => $paises,
                "genero" => $genero,
                "pag" => $pag,
                "errores" => $errores,
                "data" => []
            ];
            $this->vista("autoresAltaVista", $datos);
        }
    }



    public function borrar($id = "", $pag = 1)
    {
        //Leemos los datos del registro del id
        $data = $this->modelo->getId($id);
        $tipoUsuarios = $this->modelo->getCatalogo("tipoUsuarios");
        $estadosUsuario = $this->modelo->getCatalogo("estadosUsuario");
        $genero = $this->modelo->getCatalogo("genero");
        //Vista baja
        $datos = [
            "titulo" => "Baja de un usuario",
            "subtitulo" => "Baja de un usuario",
            "menu" => true,
            "admon" => "admon",
            "errores" => [],
            "pag" => $pag,
            "tipoUsuarios" => $tipoUsuarios,
            "estadosUsuario" => $estadosUsuario,
            "genero" => $genero,
            "activo" => 'usuarios',
            "data" => $data,
            "baja" => true
        ];
        $this->vista("usuariosAltaVista", $datos);
    }

    public function bajaLogica($id = '', $pag = 1)
    {
        if (isset($id) && $id != "") {
            if ($this->modelo->bajaLogica($id)) {
                $this->mensaje(
                    "Borrar un usuario",
                    "Borrar un usuario",
                    "Se borró correctamente un usuario.",
                    "usuarios/" . $pag,
                    "success"
                );
            } else {
                $this->mensaje(
                    "Error al borrar un usuario",
                    "Error al borrar un usuario",
                    "Error al borrar un usuario.",
                    "usuarios/" . $pag,
                    "danger"
                );
            }
        }
    }

    public function estadoActualizar()
    {
        $errores = [];
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //
            $id = $_POST['id'] ?? "";
            $pag = $_POST['pag'] ?? "1";
            $estado = $_POST['estado'] ?? "void";
            if ($estado == "void") {
                array_push($errores, "El género es obligatorio.");
            }
            if ($id == 1) {
                $this->mensaje(
                    "Error al actualizar el estado del usuario",
                    "Error al actualizar el estado del usuario",
                    "No se puede cambiar el estado del administrador original.",
                    "usuarios/" . $pag,
                    "danger"
                );
                array_push($errores, "No se puede cambiar el estado del administrador original.");
            }
            if (empty($errores)) {
                if ($this->modelo->estadoActualizar($id, $estado)) {
                    $this->mensaje(
                        "Actualizar el estado del usuario",
                        "Actualizar el estado del usuario",
                        "Se actualizó correctamente el estado del usuario.",
                        "usuarios/" . $pag,
                        "success"
                    );
                } else {
                    $this->mensaje(
                        "Error al actualizar el estado del usuario",
                        "Error al actualizar el estado del usuario",
                        "Error al actualizar el estado del usuario.",
                        "usuarios/" . $pag,
                        "danger"
                    );
                }
            }
        }
    }

    public function estadoCambiar($id, $pag = 1)
    {
        //Leemos los datos de la tabla
        $data = $this->modelo->getId($id);
        $estadosUsuario = $this->modelo->getCatalogo("estadosUsuario");
        $datos = [
            "titulo" => "Modificar el estado de un usuario",
            "subtitulo" => "Modificar el estado de un usuario",
            "activo" => "usuarios",
            "menu" => true,
            "admon" => "admon",
            "estadosUsuario" => $estadosUsuario,
            "pag" => $pag,
            "errores" => [],
            "data" => $data
        ];
        $this->vista("usuariosEstadoCambiarVista", $datos);
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
