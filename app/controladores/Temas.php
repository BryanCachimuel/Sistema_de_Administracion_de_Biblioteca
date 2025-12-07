<?php  
/**
 * 
 */
class Temas extends Controlador
{
	private $modelo = "";
	private $usuario = "";
	private $sesion;
	
	function __construct()
	{
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->modelo = $this->modelo("TemasModelo");
			$this->usuario = $this->sesion->getUsuario();
		} else {
			header("location:".RUTA);
		}
	}

	public function caratula($pagina=1)
	{
		$num = $this->modelo->getNumRegistros();
		$inicio = ($pagina-1)*TAMANO_PAGINA;
		$totalPaginas = ceil($num/TAMANO_PAGINA);
		$data = $this->modelo->getTabla($inicio,TAMANO_PAGINA);	
		$datos = [
			"titulo" => "Temas",
			"subtitulo" => "Temas",
			"activo" => "temas",
			"menu" => true,
			"admon" => ADMON,
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "temas",
				"pagina" => $pagina
			],
			"data" => $data
		];
		$this->vista("temasCaratulaVista",$datos);
	}

	public function alta(){
	   //Definir los arreglos
	    $data = [];
	    $errores = array();
	    $pag = 1;

	    //Recibimos la información de la vista
	    if ($_SERVER['REQUEST_METHOD']=="POST") {
	      //
	      $id = $_POST['id'] ?? "";
	      $idCategoria = Helper::cadena($_POST['idCategoria'] ?? "");
	      $tema = Helper::cadena($_POST['tema'] ?? "");
	      $pag = $_POST['pag'] ?? "1";
	      //
	      // Validamos la información
	      // 
	      if($idCategoria=="void"){
	        array_push($errores,"La categoría es requerida.");
	      }
	      if(empty($tema)){
	        array_push($errores,"El tema es requerido.");
	      }
	      if (empty($errores)) { 
			// Crear arreglo de datos
			//
			$data = [
			 "id" => $id,
			 "idCategoria"=>$idCategoria,
			 "tema"=>$tema
			];
	        //Enviamos al modelo
	        if(trim($id)===""){
	          //Alta
	          if ($this->modelo->alta($data)) {
	            $this->mensaje(
	          		"Alta de un tema", 
	          		"Alta de un tema", 
	          		"Se añadió correctamente el tema: ".$tema, 
	          		"temas/".$pag, 
	          		"success"
	          	);
	          } else {
	          	$this->mensaje(
	          		"Error al añadir un tema.", 
	          		"Error al añadir un tema.", 
	          		"Error al modificar un tema: ".$tema, 
	          		"temas/".$pag, 
	          		"danger"
	          	);
	          }
	        } else {
	          //Modificar
	          if ($this->modelo->modificar($data)) {
	            $this->mensaje(
	          		"Modificar un tema", 
	          		"Modificar un tema", 
	          		"Se modificó correctamente el tema: ".$tema,
	          		"temas/".$pag, 
	          		"success"
	          	);
	          } else {
	          	$this->mensaje(
	          		"Error al modificar un tema.", 
	          		"Error al modificar un tema.", 
	          		"Error al modificar un tema: ".$tema, 
	          		"temas/".$pag, 
	          		"danger"
	          	);
	          }
	        }
	      }
	    } 
	    if(!empty($errores) || $_SERVER['REQUEST_METHOD']!="POST" ){
	    	//Vista Alta
	    	$categorias = $this->modelo->getCategorias();
		    $datos = [
		      "titulo" => "Alta de un tema",
		      "subtitulo" => "Alta de un tema",
		      "activo" => "temas",
		      "menu" => true,
		      "admon" => ADMON,
		      "categorias" => $categorias,
		      "pag" => $pag,
		      "errores" => $errores,
		      "data" => []
		    ];
		    $this->vista("temasAltaVista",$datos);
	    }
  	}

  	public function borrar($id="",$pag=1){
	    //Leemos los datos del registro del id
	    $data = $this->modelo->getId($id);
	    $categorias = $this->modelo->getCategorias();
	    $ir_array = $this->modelo->getIntegridadReferencial($id);

	    if ($ir_array[0]==0) {
		    $datos = [
		      "titulo" => "Baja de un tema",
		      "subtitulo" => "Baja de un tema",
		      "menu" => true,
		      "admon" => ADMON,
		      "errores" => [],
		      "pag" => $pag,
		      "categorias" => $categorias,
		      "activo" => 'temas',
		      "data" => $data,
		      "baja" => true
		    ];
		    $this->vista("temasAltaVista",$datos);
		} else {
			$this->mensaje(
        		"Error al borrar el tema", 
        		"Error al borrar el tema", 
        		"No podemos eliminar el tema porque tiene:<ul><li>".$ir_array[0]." libros.</li></ul>Primero debe eliminar esas referencias.", 
        		"temas", 
        		"danger"
        	);
		}
	  }

	public function bajaLogica($id='',$pag=1){
	   if (isset($id) && $id!="") {
	     if ($this->modelo->bajaLogica($id)) {
        	$this->mensaje(
        		"Borrar un tema", 
        		"Borrar un tema", 
        		"Se borró correctamente el tema.", 
        		"temas/".$pag, 
        		"success"
        	);
        } else {
        	$this->mensaje(
        		"Error al borrar un tema", 
        		"Error al borrar un tema", 
        		"Error al borrar un tema.", 
        		"temas/".$pag, 
        		"danger"
        	);
        }
	   }
	}

  	public function modificar($id,$pag=1)
	{
		//Leemos los datos de la tabla
		$data = $this->modelo->getId($id);
		$categorias = $this->modelo->getCategorias();
		$datos = [
			"titulo" => "Modificar un tema",
			"subtitulo" =>"Modificar un tema",
			"menu" => true,
			"admon" => ADMON,
			"pag" => $pag,
			"categorias" => $categorias,
			"activo" => "temas",
			"data" => $data
		];
		$this->vista("temasAltaVista",$datos);
	}
}
?>