<?php

class Paises extends Controlador
{
	private $modelo = "";

	function __construct()
	{
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->sesion->finalizarLogin();
		}
		$this->modelo = $this->modelo("PaisesModelo");
	}

	public function caratula($pagina = 1)
	{
		$num = $this->modelo->getNumRegistros();
		$inicio = ($pagina - 1) * TAMANO_PAGINA;
		$totalPaginas = ceil($num / TAMANO_PAGINA);
		$data = $this->modelo->getTabla($inicio, TAMANO_PAGINA);
		$datos = [
			"titulo" => "Países",
			"subtitulo" => "Países",
			"activo" => "paises",
			"menu" => true,
			"admon" => ADMON,
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "paises",
				"pagina" => $pagina
			],
			"data" => $data
		];
		$this->vista("paisesCaratulaVista", $datos);
	}

	public function alta()
	{
		//Definir los arreglos
		$data = array();
		$errores = array();
		$pag = 1;

		//Recibimos la información de la vista
		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$id = $_POST['id'] ?? "";
			$pais = Helper::cadena($_POST['pais'] ?? "");
			$pag = $_POST['pag'] ?? "1";

			// Validamos la información
			if (empty($pais)) {
				array_push($errores, "El nombre del país es requerido.");
			}

			if (empty($errores)) {
				// Crear arreglo de datos
				//
				$data = [
					"id" => $id,
					"pais" => $pais
				];
				//Enviamos al modelo
				if (trim($id) === "") {
					//Alta
					if ($this->modelo->alta($data)) {
						$this->mensaje(
							"Alta de un país",
							"Alta de un país",
							"Se añadió correctamente el país: " . $pais,
							"paises/" . $pag,
							"success"
						);
					} else {
						$this->mensaje(
							"Error al añadir un país.",
							"Error al añadir un país.",
							"Error al modificar un país: " . $pais,
							"paises/" . $pag,
							"danger"
						);
					}
				} else {
					//Modificar
					if ($this->modelo->modificar($data)) {
						$this->mensaje(
							"Modificar el país",
							"Modificar el país",
							"Se modificó correctamente el país: " . $pais,
							"paises/" . $pag,
							"success"
						);
					} else {
						$this->mensaje(
							"Error al modificar el país.",
							"Error al modificar el país.",
							"Error al modificar el país: " . $pais,
							"paises/" . $pag,
							"danger"
						);
					}
				}
			}
		}
		if (!empty($errores) || $_SERVER['REQUEST_METHOD'] != "POST") {
			//Vista Alta
			$datos = [
				"titulo" => "Alta de un país",
				"subtitulo" => "Alta de un país",
				"activo" => "paises",
				"menu" => true,
				"admon" => ADMON,
				"pag" => $pag,
				"errores" => $errores,
				"data" => []
			];
			$this->vista("paisesAltaVista", $datos);
		}
	}

	public function borrar($id = "", $pag = 1)
	{
		//Leemos los datos del registro del id
		$data = $this->modelo->getId($id);
		$ir_array = $this->modelo->getIntegridadReferencial($id);

		if ($ir_array[0] == 0) {
			//Vista baja
			$datos = [
				"titulo" => "Baja de un país",
				"subtitulo" => "Baja del país",
				"menu" => true,
				"admon" => "admon",
				"errores" => [],
				"activo" => 'paises',
				"pag" => $pag,
				"data" => $data,
				"baja" => true
			];
			$this->vista("paisesAltaVista", $datos);
		}
		else {
			$this->mensaje(
				"Error al borrar el país",
				"Error al borrar el país",
				"No podemos eliminar el país porque tiene:<ul><li>".$ir_array[1]." autores.</li><li>".$ir_array[2]." editoriales.</li></ul>Primero debe eliminar esas referencias.", 
				"paises",
				"danger"
			);
		}
	}

	public function bajaLogica($id = '', $pag = 1)
	{
		if (isset($id) && $id != "") {
			if ($this->modelo->bajaLogica($id)) {
				$this->mensaje(
					"Borrar el país",
					"Borrar el país",
					"Se borró correctamente el país.",
					"paises/" . $pag,
					"success"
				);
			} else {
				$this->mensaje(
					"Error al borrar el país",
					"Error al borrar el país",
					"Error al borrar el país.",
					"paises/" . $pag,
					"danger"
				);
			}
		}
	}

	public function modificar($id, $pag)
	{
		//Leemos los datos de la tabla
		$data = $this->modelo->getPaisId($id);

		$datos = [
			"titulo" => "Modificar país",
			"subtitulo" => "Modificar país",
			"menu" => true,
			"pag" => $pag,
			"admon" => ADMON,
			"activo" => "paises",
			"data" => $data
		];
		$this->vista("paisesAltaVista", $datos);
	}
}
