<?php

/**
 * 
 */
class Prestamos extends Controlador
{

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
			"admon" => ADMON,
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "prestamos",
				"pagina" => $pagina
			],
			"data" => $data
		];
		$this->vista("prestamosCaratulaVista", $datos);
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
			$id = trim($_POST['id'] ?? "");
			$pag = $_POST['pag'] ?? "1";
			$idUsuario = Helper::cadena($_POST['idUsuario'] ?? "");
			$idCopia = Helper::cadena($_POST['idCopia'] ?? "");
			$prestamo = Helper::cadena($_POST['prestamo'] ?? "");
			$devolucion = Helper::cadena($_POST['devolucion'] ?? "");
			//
			// Validamos la información
			// 
			if (empty($idUsuario) || $idUsuario == "void") {
				array_push($errores, "El id del usuario es requerido.");
			}
			if (empty($idCopia) || $idCopia == "void") {
				array_push($errores, "El id de la copia es requerido.");
			}
			if (empty($prestamo)) {
				array_push($errores, "La fecha de prestamo es requerida.");
			}
			if (empty($devolucion)) {
				array_push($errores, "La fecha de devolucion es requerida.");
			}
			if (empty($errores)) {
				// Crear arreglo de datos
				//
				$data = [
					"id" => $id,
					"idCopia" => $idCopia,
					"idUsuario" => $idUsuario,
					"prestamo" => $prestamo,
					"devolucion" => $devolucion
				];
				//Enviamos al modelo
				if (trim($id) === "") {
					//Alta
					if ($this->modelo->alta($data)) {
						if ($this->modelo->copiasModificar($data["idCopia"])) {
							$this->mensaje(
								"La copia fue registrada.",
								"La copia fue registrada.",
								"La copia fue registrada.",
								"prestamos/" . $pag,
								"success"
							);
						} else {
							$this->mensaje(
								"Error al modifica el estado de la copia.",
								"Error al modifica el estado de la copia.",
								"Error al modifica el estado de la copia.",
								"prestamos/" . $pag,
								"danger"
							);
						}
					} else {
						$this->mensaje(
							"Error al registrar el préstamo.",
							"Error al registrar el préstamo.",
							"Error al registrar el préstamo.",
							"prestamos/" . $pag,
							"danger"
						);
					}
				}
			}
		}
		//Preparación de la vista
		if (!empty($errores) || $_SERVER['REQUEST_METHOD'] != "POST") {
			$usuarios = $this->modelo->getUsuarios();
			$copias = $this->modelo->getCopiasDisponibles();
			$prestamo_dt = new DateTime();
			$devolucion_dt = new DateTime();
			$p = "+" . PRESTAMO . " days";
			$devolucion_dt->modify($p);
			$prestamo = $prestamo_dt->format('Y-m-d');
			$devolucion = $devolucion_dt->format('Y-m-d');
			$datos = [
				"titulo" => "Prestar un libro",
				"subtitulo" => "Prestar un libro",
				"activo" => "prestamos",
				"menu" => true,
				"admon" => ADMON,
				"usuarios" => $usuarios,
				"copias" => $copias,
				"errores" => $errores,
				"pag" => $pag,
				"data" => [
					"prestamo" => $prestamo,
					"devolucion" => $devolucion
				]
			];
			$this->vista("prestamosAltaVista", $datos);
		}
	}

	public function devolver()
	{
		//Leemos los datos de la tabla
		$data = [];
		$errores = [];
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$copia = Helper::cadena($_POST['copia'] ?? "");
			$numCopia = Helper::cadena($_POST['num'] ?? "");
			$idEstado = Helper::cadena($_POST['idEstado'] ?? "");

			// validado de información
			if (empty($copia)) {
				array_push($errores, "La copia es requerida");
			} else {
				$estadoCopia = $this->modelo->getEstadoCopia($copia, $numCopia);
				if ($estadoCopia == false) {
					array_push($errores, "No existe la copia de este libro");
				} else if ($estadoCopia["estado"] != COPIA_PRESTADO) {
					array_push($errores, "Esta copia no está prestada");
				}
			}
			if ($idEstado == COPIA_PRESTADO) {
				array_push($errores, "No puede regresar un libro con ese estado");
			}
			if (empty($errores)) {
				$data = [
					"idCopia" => $estadoCopia["id"],
					"copia" => $copia,
					"numCopia" => $numCopia,
					"idEstado" => $idEstado
				];
				if ($this->modelo->copiasDevolver($data)) {
					if ($this->modelo->prestamosDevolver($data)) {
						$this->mensaje(
							"La copia fue actualizada",
							"La copia fue actualizada",
							"La copia fue actualizada",
							"prestamos/devolver/",
							"success"
						);
					} else {
						$this->mensaje(
							"Error al actualizar el préstamo",
							"Error al actualizar el préstamo",
							"Error al actualizar el préstamo",
							"prestamos",
							"danger"
						);
					}
				} else {
					$this->mensaje(
						"Error al actualizar la copia",
						"Error al actualizar la copia",
						"Error al actualizar la copia",
						"prestamos",
						"danger"
					);
				}
			}
		}
		if (!empty($errores) || $_SERVER['REQUEST_METHOD'] != "POST") {
			$estados = $this->modelo->getCatalogo("estadosCopias");
			$datos = [
				"titulo" => "Regresar un libro",
				"subtitulo" => "Regresar un libro",
				"activo" => "prestamos",
				"menu" => true,
				"admon" => ADMON,
				"estados" => $estados,
				"errores" => [],
				"data" => []
			];
			$this->vista("prestamosDevolverVista", $datos);
		}
	}
}
