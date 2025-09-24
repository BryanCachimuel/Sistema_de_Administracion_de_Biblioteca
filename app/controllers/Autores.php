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

        if ($_SERVER['REQUEST_METHOD']=="POST") {
			//
			$idLibro = Helper::cadena($_POST['idLibro'] ?? "");
			$pag = $_POST['pag'] ?? "1";
			$idAutor = $_POST['idAutor'] ?? "";
			//
			// Validamos la información
			// 
			if($idLibro=="void"){
				array_push($errores,"El libro es requerido.");
			}
			if (empty($errores)) { 
				// Crear arreglo de datos
				//
				$data = [
				 "idLibro" => $idLibro,
				 "idAutor"=>$idAutor,
				];
				//Enviamos al modelo
				if ($this->modelo->autoresLibrosAlta($data)) {
					//Envía correo
					$this->mensaje(
						"El libro fue añadido.", 
						"El libro fue añadido.", 
						"El libro fue añadido.", 
						"autores/autoresLibros/".$idAutor."/".$pag, 
						"success"
					);
				} else {
					$this->mensaje(
						"Error al registrar el libro.", 
						"Error al registrar el libro.", 
						"Error al registrar el libro: ", 
						"autores/".$pag, 
						"danger"
					);
				}
			}
	    }
        if(!empty($errores) || $_SERVER['REQUEST_METHOD']!="POST") {
            // alta de un libro
            $libros = $this->modelo->getLibros();
            $autor = $this->modelo->getAutorId($idAutor);
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

     public function autoresLibrosQuitar($idLibroAutor="",$pag=1) {
        // indetificador de la tabla libroAutor
        $data = $this->modelo->getIdLibrosAutores($idLibroAutor);
        $datos = [
            "titulo" => "Quitar una relación de autor-libro",
		    "subtitulo" => "Quitar una relación de autor-libro",
		    "activo" => "autores",
		    "menu" => false,
            "admon" => "admon",
		    "errores" => [],
            "pag" => $pag,
		    "baja" => true,
            "id" => $idLibroAutor,
            "data" => $data
        ];
        $this->vista("autoresLibrosQuitarVista",$datos);
    }

    public function autoresLibrosBajaLogica($idLibroAutor='',$pag=1,$idLibro=""){
		if (isset($idLibroAutor) && $idLibroAutor!="") {
			if ($this->modelo->autoresLibrosBajaLogica($idLibroAutor)) {
				$this->mensaje(
					"Eliminó el libro del autor", 
					"Eliminó el libro del autor", 
					"Se eliminó correctamente el libro del autor", 
					"autores/autoresLibros/".$idLibro."/".$pag, 
					"success"
				);
			} else {
				$this->mensaje(
					"Error al borrar el libro del autor", 
					"Error al borrar el libro del autor", 
					"Error al borrar el libro del autor", 
					"autores/".$pag, 
					"danger"
				);
			}
		}
	}

   
    /* Copias */
  	public function copias($idLibro) {
  		//
  		if($idLibro=="") return false;
  		$libro = $this->modelo->getLibro($idLibro);
  		$copias = $this->modelo->copiasLibroTabla($idLibro);
  		$datos = [
		     "titulo" => "Copias de un libro",
		     "subtitulo" => "Copias del libro: ".$libro["titulo"],
		     "activo" => "autores",
		     "menu" => false,
		     "admon" => "admon",
		     "libro" => $idLibro,
		     "errores" => [],
		     "data" => $copias
		];
		$this->vista("autoresLibrosCopiasCaratulaVista",$datos);
	}

}
