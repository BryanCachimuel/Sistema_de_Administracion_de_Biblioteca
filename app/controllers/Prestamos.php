<?php

/**
 * 
 */
class Prestamos extends Controlador {

    private $modelo = "";

    function __construct()
    {
        $this->sesion = new Sesion();
        if ($this->sesion->getLogin()) {
            $this->sesion->finalizarLogin();
        }
        $this->modelo = $this->modelo("PrestamosModelo");
    }

    public function caratula($pagina = 1)
    {
        $num = $this->modelo->getNumRegistros();
        $inicio = ($pagina - 1) * TAMANO_PAGINA;
        $totalPaginas = ceil($num / TAMANO_PAGINA);
        $data = $this->modelo->getTabla($inicio, TAMANO_PAGINA);
        $datos = [
            "titulo" => "Préstamos",
            "subtitulo" => "Préstamos",
            "activo" => "prestamos",
            "menu" => true,
            "pag" => [
                "totalPaginas" => $totalPaginas,
                "regresa" => "prestamos",
                "pagina" => $pagina
            ],
            "data" => $data
        ];
        $this->vista("prestamosCaratulaVista", $datos);
    }

   public function alta(){
	   //Definir los arreglos
	    $data = [];
	    $errores = array();
	    $pag = 1;

	    //Recibimos la información de la vista
	    if ($_SERVER['REQUEST_METHOD']=="POST") {
	      //
	      $id = trim($_POST['id'] ?? "");
	      $pag = $_POST['pag'] ?? "1";
	      $idUsuario = Helper::cadena($_POST['idUsuario'] ?? "");
	      $idCopia = Helper::cadena($_POST['idCopia'] ?? "");
	      $prestamo = Helper::cadena($_POST['prestamo'] ?? "");
	      $devolucion = Helper::cadena($_POST['devolucion'] ?? "");
	      //
	      // Validamos la información
	      // 
	      if(empty($idUsuario) || $idUsuario=="void"){
	        array_push($errores,"El id del usuario es requerido.");
	      }
	      if (empty($idCopia) || $idCopia=="void") {
	      	array_push($errores,"El id de la copia es requerido.");
	      }
	      if (empty($prestamo)) {
	      	array_push($errores,"La fecha de prestamo es requerida.");
	      }
	      if (empty($devolucion)) {
	      	array_push($errores,"La fecha de devolucion es requerida.");
	      }
	      if (empty($errores)) { 
			// Crear arreglo de datos
			//
			$data = [
			 "id" => $id,
			 "idCopia"=> $idCopia,
		     "idUsuario"=> $idUsuario,
		     "prestamo"=> $prestamo,
		     "devolucion" => $devolucion
			];
	        //Enviamos al modelo
	        if(trim($id)===""){
	          //Alta
	          if ($this->modelo->alta($data)) {
	          	if ($this->modelo->copiasModificar($data["idCopia"])) {
		            $this->mensaje(
		          		"La copia fue registrada.", 
		          		"La copia fue registrada.", 
		          		"La copia fue registrada.", 
		          		"prestamos/".$pag, 
		          		"success"
		          	);
		        } else {
		          	$this->mensaje(
		          		"Error al modifica el estado de la copia.", 
		          		"Error al modifica el estado de la copia.",  
		          		"Error al modifica el estado de la copia.", 
		          		"prestamos/".$pag, 
		          		"danger"
		          	);
		          }
	          } else {
	          	$this->mensaje(
	          		"Error al registrar el préstamo.", 
	          		"Error al registrar el préstamo.",  
	          		"Error al registrar el préstamo.", 
	          		"prestamos/".$pag, 
	          		"danger"
	          	);
	          }
	        } else {
	          //Modificar
	          if ($this->modelo->modificar($data)) {
	            $this->mensaje(
	          		"Modificar un libro", 
	          		"Modificar un libro", 
	          		"Se modificó correctamente el libro: ".$titulo,
	          		"libros/".$pag, 
	          		"success"
	          	);
	          } else {
	          	$this->mensaje(
	          		"Error al modificar un libro.", 
	          		"Error al modificar un libro.", 
	          		"Error al modificar un libro: ".$titulo, 
	          		"libros/".$pag, 
	          		"danger"
	          	);
	          }
	        }
	      }
	    }
	    //Preparación de la vista
	    if(!empty($errores) || $_SERVER['REQUEST_METHOD']!="POST" ){
	    	$usuarios = $this->modelo->getUsuarios();
	    	$copias = $this->modelo->getCopiasDisponibles();
	    	$prestamo_dt = new DateTime();
	    	$devolucion_dt = new DateTime();
	    	$p = "+".PRESTAMO." days";
	    	$devolucion_dt->modify($p);
	    	$prestamo = $prestamo_dt->format('Y-m-d');
	    	$devolucion = $devolucion_dt->format('Y-m-d');
		    $datos = [
		      "titulo" => "Prestar un libro",
		      "subtitulo" => "Prestar un libro",
		      "activo" => "prestamos",
		      "menu" => true,
		      "admon" => "admon",
		      "usuarios" => $usuarios,
		      "copias" => $copias,
		      "errores" => $errores,
		      "pag" => $pag,
		      "data" => [
		      	"prestamo" => $prestamo,
		      	"devolucion" => $devolucion
		      ]
		    ];
		    $this->vista("prestamosAltaVista",$datos);
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

}
