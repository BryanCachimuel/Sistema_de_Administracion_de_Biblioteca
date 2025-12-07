<?php  
/**
 * 
 */
class Categorias extends Controlador
{
	private $modelo = "";
	private $usuario = "";
	private $sesion;
	
	function __construct()
	{
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->modelo = $this->modelo("CategoriasModelo");
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
			"titulo" => "Categorías",
			"subtitulo" => "Categorías",
			"activo" => "categorias",
			"menu" => true,
			"admon" => ADMON,
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "categorias",
				"pagina" => $pagina
			],
			"data" => $data
		];
		$this->vista("categoriasCaratulaVista",$datos);
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
	      $clave = Helper::cadena($_POST['clave'] ?? "");
	      $categoria = Helper::cadena($_POST['categoria'] ?? "");
	      $pag = $_POST['pag'] ?? "1";
	      //
	      // Validamos la información
	      // 
	      if($clave==""){
	        array_push($errores,"La clave es requerida.");
	      }
	      if(empty($categoria)){
	        array_push($errores,"La categoría es requerida.");
	      }
	      if (empty($errores)) { 
			// Crear arreglo de datos
			//
			$data = [
			 "id" => $id,
			 "clave"=>$clave,
			 "categoria"=>$categoria
			];
	        //Enviamos al modelo
	        if(trim($id)===""){
	          //Alta
	          if ($this->modelo->alta($data)) {
	            $this->mensaje(
	          		"Alta de una categoría", 
	          		"Alta de una categoría", 
	          		"Se añadió correctamente la categoría: ".$categoria, 
	          		"categorias/".$pag, 
	          		"success"
	          	);
	          } else {
	          	$this->mensaje(
	          		"Error al añadir una categoría.", 
	          		"Error al añadir una categoría.", 
	          		"Error al modificar uuna categoría: ".$categoria, 
	          		"categorias/".$pag, 
	          		"danger"
	          	);
	          }
	        } else {
	          //Modificar
	          if ($this->modelo->modificar($data)) {
	            $this->mensaje(
	          		"Modificar una categoría", 
	          		"Modificar una categoría", 
	          		"Se modificó correctamente la categoría: ".$categoria,
	          		"categorias/".$pag, 
	          		"success"
	          	);
	          } else {
	          	$this->mensaje(
	          		"Error al modificar una categoría.", 
	          		"Error al modificar una categoría.", 
	          		"Error al modificar una categoría: ".$categoria, 
	          		"categorias/".$pag, 
	          		"danger"
	          	);
	          }
	        }
	      }
	    } 
	    if(!empty($errores) || $_SERVER['REQUEST_METHOD']!="POST" ){
	    	//Vista Alta
		    $datos = [
		      "titulo" => "Alta de una categoría",
		      "subtitulo" => "Alta de una categoría",
		      "activo" => "categorias",
		      "menu" => true,
		      "admon" => ADMON,
		      "pag" => $pag,
		      "errores" => $errores,
		      "data" => []
		    ];
		    $this->vista("categoriasAltaVista",$datos);
	    }
  	}

  	public function borrar($id="",$pag=1){
	    //Leemos los datos del registro del id
	    $data = $this->modelo->getId($id);
	    $ir_array = $this->modelo->getIntegridadReferencial($id);

	    if ($ir_array[0]==0) {
	    	//Vista baja
		    $datos = [
		      "titulo" => "Baja de una categoría|",
		      "subtitulo" => "Baja de la categoría",
		      "menu" => true,
		      "admon" => ADMON,
		      "errores" => [],
		      "pag" => $pag,
		      "activo" => 'categorias',
		      "data" => $data,
		      "baja" => true
		    ];
		    $this->vista("categoriasAltaVista",$datos);
		} else {
			$this->mensaje(
        		"Error al borrar la categoría", 
        		"Error al borrar la categoría", 
        		"No podemos eliminar la categoría porque tiene:<ul><li>".$ir_array[0]." temas.</li></ul>Primero debe eliminar esas referencias.", 
        		"categorias", 
        		"danger"
        	);
		}
	  }

	public function bajaLogica($id='',$pag=1){
	   if (isset($id) && $id!="") {
	     if ($this->modelo->bajaLogica($id)) {
        	$this->mensaje(
        		"Borrar una categoría", 
        		"Borrar una categoría", 
        		"Se borró correctamente la categoría.", 
        		"categorias/".$pag, 
        		"success"
        	);
        } else {
        	$this->mensaje(
        		"Error al borrar una categoría", 
        		"Error al borrar una categoría", 
        		"Error al borrar una categoría.", 
        		"categorias/".$pag, 
        		"danger"
        	);
        }
	   }
	}

  	public function modificar($id,$pag=1)
	{
		//Leemos los datos de la tabla
		$data = $this->modelo->getId($id);

		$datos = [
			"titulo" => "Modificar categoría",
			"subtitulo" =>"Modificar categoría",
			"menu" => true,
			"admon" => ADMON,
			"pag" => $pag,
			"activo" => "categorias",
			"data" => $data
		];
		$this->vista("categoriasAltaVista",$datos);
	}
}
?>