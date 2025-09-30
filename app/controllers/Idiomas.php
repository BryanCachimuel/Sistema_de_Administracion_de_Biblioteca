<?php

class Idiomas extends Controlador
{
	private $modelo = "";

	function __construct()
	{
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->sesion->finalizarLogin();
		}
		$this->modelo = $this->modelo("IdiomasModelo");
	}

	public function caratula($pagina = 1)
	{
		$num = $this->modelo->getNumRegistros();
		$inicio = ($pagina - 1) * TAMANO_PAGINA;
		$totalPaginas = ceil($num / TAMANO_PAGINA);
		$data = $this->modelo->getTabla($inicio, TAMANO_PAGINA);
		$datos = [
			"titulo" => "Idiomas",
			"subtitulo" => "Idiomas",
			"activo" => "idiomas",
			"menu" => true,
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "idiomas",
				"pagina" => $pagina
			],
			"data" => $data
		];
		$this->vista("idiomasCaratulaVista", $datos);
	}

	public function alta()
	{
		//Definir los arreglos
		$data = [];
		$errores = array();
		$pag = 1;
		//Recibimos la información de la vista
		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$id = $_POST['id'] ?? "";
			$idioma = Helper::cadena($_POST['idioma'] ?? "");
			$pag = $_POST['pag'] ?? "1";

			// Validamos la información
			if (empty($idioma)) {
				array_push($errores, "El idioma es requerido.");
			}

			if (empty($errores)) {
				// Crear arreglo de datos
				//
				$data = [
					"id" => $id,
					"idioma" => $idioma
				];
				//Enviamos al modelo
				if (trim($id) === "") {
					//Alta
					if ($this->modelo->alta($data)) {
						$this->mensaje(
							"Alta de un idioma",
							"Alta de un idioma",
							"Se añadió correctamente el idioma: " . $idioma,
							"idiomas/" . $pag,
							"success"
						);
					} else {
						$this->mensaje(
							"Error al añadir un idioma.",
							"Error al añadir un idioma.",
							"Error al modificar el idioma: " . $idioma,
							"idiomas/" . $pag,
							"danger"
						);
					}
				} else {
					//Modificar
					if ($this->modelo->modificar($data)) {
						$this->mensaje(
							"Modificar el idioma",
							"Modificar el idioma",
							"Se modificó correctamente el idioma: " . $idioma,
							"idiomas/" . $pag,
							"success"
						);
					} else {
						$this->mensaje(
							"Error al modificar el idioma.",
							"Error al modificar el idioma.",
							"Error al modificar el idioma: " . $idioma,
							"idiomas/" . $pag,
							"danger"
						);
					}
				}
			}
		}
		if (!empty($errores) || $_SERVER['REQUEST_METHOD'] != "POST") {
			//Vista Alta
			$datos = [
				"titulo" => "Alta de un idioma",
				"subtitulo" => "Alta de un idioma",
				"activo" => "idiomas",
				"menu" => true,
				"admon" => "admon",
				"pag" => $pag,
				"errores" => $errores,
				"data" => []
			];
			$this->vista("idiomasAltaVista", $datos);
		}
	}

	public function borrar($id = "", $pag = 1)
	{
		//Leemos los datos del registro del id
		$data = $this->modelo->getIdiomaId($id);
		$ir_array = $this->modelo->getIntegridadReferencial($id);

		if ($ir_array[0] == 0) {
			//Vista baja
			$datos = [
				"titulo" => "Baja de un idioma",
				"subtitulo" => "Baja del idioma",
				"menu" => true,
				"admon" => "admon",
				"errores" => [],
				"activo" => 'idiomas',
				"pag" => $pag,
				"data" => $data,
				"baja" => true
			];
			$this->vista("idiomasAltaVista", $datos);
		}
		else {
			$this->mensaje(
				"Error al borrar el idioma",
				"Error al borrar el idioma",
				"No podemos eliminar el idioma porque tiene: <ul><li>".$ir_array[0]." libros. <li></ul>Primero debe eliminar esas referencias",
				"idiomas",
				"danger"
			);
		}
	}

	public function bajaLogica($id = '', $pag = 1)
	{
		if (isset($id) && $id != "") {
			if ($this->modelo->bajaLogica($id)) {
				$this->mensaje(
					"Borrar el idioma",
					"Borrar el idioma",
					"Se borró correctamente el idioma.",
					"idiomas/" . $pag,
					"success"
				);
			} else {
				$this->mensaje(
					"Error al borrar el idioma",
					"Error al borrar el idioma",
					"Error al borrar el idioma.",
					"idiomas/" . $pag,
					"danger"
				);
			}
		}
	}

	public function modificar($id, $pag)
	{
		//Leemos los datos de la tabla
		$data = $this->modelo->getIdiomaId($id);

		$datos = [
			"titulo" => "Modificar idioma",
			"subtitulo" => "Modificar idioma",
			"menu" => true,
			"idiomas/" => $pag,
			"admon" => "admon",
			"pag" => $pag,
			"activo" => "idiomas",
			"data" => $data
		];
		$this->vista("idiomasAltaVista", $datos);
	}
}
