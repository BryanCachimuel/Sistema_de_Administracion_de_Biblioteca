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

    /* Libros - Autores */

    public function librosAutores($idLibro) {
		//Leemos los datos de la tabla
		$data = $this->modelo->getLibrosAutoresTabla($idLibro);
		$libro = $this->modelo->getLibroId($idLibro);
		$datos = [
			"titulo"=> "Autores",
			"subtitulo" => "Autor(es) del libro: ".$libro["titulo"],
			"admon" => "admon",
			"activo" => "libros",
			"data" => $data,
			"idLibro" => $idLibro,
			"menu" => true
		];
		$this->vista("librosAutoresCaratulaVista",$datos);
	}

	public function librosAutoresAlta($idLibro=""){
		//Definir los arreglos
		$data = array();
		$errores = array();
		 //Recibimos la información de la vista
	    if ($_SERVER['REQUEST_METHOD']=="POST") {
			//
			$idLibro = $_POST['idLibro'] ?? "";
			$pag = $_POST['pag'] ?? "1";
			$idAutor = Helper::cadena($_POST['idAutor'] ?? "");
			//
			// Validamos la información
			// 
			if($idAutor=="void"){
				array_push($errores,"El autor es requerido.");
			}
			if (empty($errores)) { 
				// Crear arreglo de datos
				//
				$data = [
				 "idLibro" => $idLibro,
				 "idAutor"=>$idAutor,
				];
				//Enviamos al modelo
				if ($this->modelo->librosAutoresAlta($data)) {
					//Envía correo
					$this->mensaje(
						"El autor fue añadido.", 
						"El autor fue añadido.", 
						"El autor fue añadido.", 
						"libros/librosAutores/".$idLibro."/".$pag, 
						"success"
					);
				} else {
					$this->mensaje(
						"Error al registrar un autor.", 
						"Error al registrar un autor.", 
						"Error al registrar el autor: ", 
						"libros/".$pag, 
						"danger"
					);
				}
			}
	    }
	    if(!empty($errores) || $_SERVER['REQUEST_METHOD']!="POST" ){
	    	//
	    	//Alta de un libro
	    	//
	    	$autores = $this->modelo->getAutores();
	    	$libro = $this->modelo->getLibroId($idLibro);
		    $datos = [
		      "titulo" => "Dar de alta a un autor",
		      "subtitulo" => "Dar de alta a un autor para ".$libro["titulo"],
		      "activo" => "libros",
		      "menu" => false,
		      "admon" => "admon",
		      "errores" => $errores,
		      "idLibro" => $idLibro,
		      "data" => $autores
		    ];
		    $this->vista("librosAutoresAltaVista",$datos);
	    }
  	}

    public function librosAutoresQuitar($idLibroAutor="",$pag=1) {
        // indetificador de la tabla libroAutor
        $data = $this->modelo->getIdLibrosAutores($idLibroAutor);
        $errores = [];
        $datos = [
            "titulo" => "Borrar un autor",
		    "subtitulo" => "Borrar un autor",
		    "activo" => "libros",
		    "menu" => false,
            "admon" => "admon",
		    "errores" => [],
            "pag" => $pag,
		    "baja" => true,
            "id" => $idLibroAutor,
            "data" => $data
        ];
        $this->vista("librosAutoresBorrarVista",$datos);
    }

    public function librosAutoresBajaLogica($idLibroAutor='',$pag=1,$idLibro=""){
		if (isset($idLibroAutor) && $idLibroAutor!="") {
			if ($this->modelo->librosAutoresBajaLogica($idLibroAutor)) {
				$this->mensaje(
					"Eliminó el autor del libro", 
					"Eliminó el autor del libro", 
					"Se eliminó correctamente el autor del libro.", 
					"libros/librosAutores/".$idLibro."/".$pag, 
					"success"
				);
			} else {
				$this->mensaje(
					"Error al borrar el autor del libro", 
					"Error al borrar el autor del libro", 
					"Error al borrar el autor del libro.", 
					"libros/".$pag, 
					"danger"
				);
			}
		}
	}

}
