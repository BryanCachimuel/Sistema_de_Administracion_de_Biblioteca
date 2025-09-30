<?php

class Login extends Controlador
{
	private $modelo = "";

	function __construct()
	{
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->sesion->finalizarLogin();
		}
		$this->modelo = $this->modelo("LoginModelo");
	}

	public function caratula()
	{
		if (isset($_COOKIE['datos'])) {
			$datos_array = explode("|", $_COOKIE['datos']);
			$usuario = $datos_array[0];
			$clave = Helper::desencriptar($datos_array[1]);
			$data = [
				"usuario" => $usuario,
				"clave" => $clave
			];
		} else {
			$data = [];
		}
		$datos = [
			"titulo" => "Entrada a la biblioteca",
			"subtitulo" => "Sistema de biblioteca",
			"data" => $data
		];
		$this->vista("loginCaratulaVista", $datos);
	}

	public function registrar()
	{
		//Definir los arreglos
		$data = array();
		$errores = array();

		// se recibe la información de la vista
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$idTipoUsuario = Helper::cadena($_POST['idTipoUsuario'] ?? "");
			$correo = Helper::cadena($_POST['correo'] ?? "");
			$verificarCorreo = Helper::cadena($_POST['verificarCorreo'] ?? "");
			$nombre = Helper::cadena($_POST['nombre'] ?? "");
			$apellidoPaterno = Helper::cadena($_POST['apellidoPaterno'] ?? "");
			$apellidoMaterno = Helper::cadena($_POST['apellidoMaterno'] ?? "");
			$genero = Helper::cadena($_POST['genero'] ?? "");
			$telefono = Helper::cadena($_POST['telefono'] ?? "");
			$fechaNacimiento = Helper::cadena($_POST['fechaNacimiento'] ?? "");
			$estado = USUARIO_INACTIVO;

			// validar la información
			if (Helper::correo($correo) == false) {
				array_push($errores, "El correo no tiene un formato correcto");
			}
			if (empty($correo)) {
				array_push($errores, "El correo es requerido");
			}
			if ($this->modelo->buscarCorreo($correo)) {
				array_push($errores, "El correo ya existe en la base de datos");
			}

			if (Helper::correo($verificarCorreo) == false) {
				array_push($errores, "El correo de verificación no tiene el formato correcto");
			}
			if ($correo != $verificarCorreo) {
				array_push($errores, "Los correos no coinciden");
			}

			if (empty($nombre)) {
				array_push($errores, "El nombre es requerido");
			}

			if (empty($apellidoPaterno)) {
				array_push($errores, "El apellido paterno es requerido");
			}

			if (Helper::fecha($fechaNacimiento) == false) {
				array_push($errores, "El formato de la fecha de nacimiento no es correcto");
			}

			if (empty($errores)) {
				// crear arreglo de datos
				$clave = Helper::generarClave(10);
				$data = [
					"idTipoUsuario" => $idTipoUsuario,
					"correo" => $correo,
					"nombre" => $nombre,
					"clave" => $clave,
					"apellidoPaterno" => $apellidoPaterno,
					"apellidoMaterno" => $apellidoMaterno,
					"genero" => $genero,
					"telefono" => $telefono,
					"fechaNacimiento" => $fechaNacimiento,
					"estado" => USUARIO_INACTIVO
				];
				//Enviamos al modelo
				//Alta
				if ($this->modelo->registrar($data)) {

					if ($this->modelo->enviarCorreoRegistro($data, $clave)) {
						$this->mensaje("Registro del usuario", "Registro del usuario", "Se envió un correo a " . $data["correo"] . " favor de verificarlo, también el buzón de 'span'.", "login", "success");
					} else {
						$this->mensaje("Registro del usuario", "Registro del usuario", "Error al enviar el correo a " . $data["correo"] . " favor de verificarlo.", "login", "danger");
					}
				} else {
					$this->mensaje(
						"Error al registrar un usuario.",
						"Error al registrar un usuario.",
						"Error al registrar el usuario: " . $nombre . " " . $apellidoPaterno,
						"login",
						"danger"
					);
				}
			}
		}

		if (!empty($errores) || $_SERVER['REQUEST_METHOD'] != "POST") {
			//Vista Auto registro
			$genero = $this->modelo->getCatalogo("genero");
			$datos = [
				"titulo" => "Auto registro de un usuario",
				"subtitulo" => "Auto registro de un usuario",
				"activo" => "login",
				"menu" => false,
				"admon" => "admon",
				"genero" => $genero,
				"estado" => USUARIO_INACTIVO,
				"errores" => $errores,
				"data" => []
			];
			$this->vista("loginRegistrarUsuarioVista", $datos);
		}
	}

	public function registroConfirmar($data = '')
	{
		$id = Helper::desencriptar($data);
		$errores = [];
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$id = $_POST["id"] ?? "";
			$clave = $_POST['clave'] ?? "";

			if (empty($id)) {
				array_push($errores, "El número de usuario es requerido.");
			}
			if (empty($clave)) {
				array_push($errores, "La clave de acceso es requerida.");
			}
			if (count($errores) == 0) {
				// clave sin encriptar
				$data = $this->modelo->getUsuarioId($id);
				if ($data) {
					if ($data["clave"] == $clave) {
						$clave = hash_hmac("sha512", $clave, CLAVE);
						if ($this->modelo->usuarioAutorizar($id, $clave)) {
							$this->mensaje("Actualizar Registro", "Actualizar Registro", "El registro se actualizo correctamente, bienvenido(a)", "login", "success");
						} else {
							$this->mensaje("Error al actualizar el usuario", "Error al actualizar el usuario", "Error al actualizar el usuario", "login", "danger");
						}
					} else {
						$this->mensaje("Error al actualizar el usuario", "Error al actualizar el usuario", "La contraseña de acceso no coincide", "login", "danger");
					}
				} else {
					$this->mensaje("Error al actualizar el usuario", "Error al actualizar el usuario", "Existio un error al actualizar la contraseña de acceso. Favor intentarlo más tarde o cuminicarse a soporte técnico", "login", "danger");
				}
				exit;
			}
		}
		$datos = [
			"titulo" => "Confirmar registro",
			"subtitulo" => "Confirmar registro",
			"errores" => $errores,
			"menu" => false,
			"data" => $id
		];
		$this->vista("loginRegistroConfirmarVista", $datos);
	}

	public function olvidoVerificar()
	{
		$errores = [];
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$usuario = $_POST['usuario'] ?? "";
			if (empty($usuario)) {
				array_push($errores, "El correo electrónico es requerido.");
			}
			if (filter_var($usuario, FILTER_VALIDATE_EMAIL) == false) {
				array_push($errores, "El correo electrónico no está bien escrito.");
			}
			if (empty($errores)) {
				//
				if ($this->modelo->buscarCorreo($usuario)) {
					if (!$this->modelo->enviarCorreo($usuario)) {
						$datos = [
							"titulo" => "Cambio de clave de acceso",
							"menu" => false,
							"errores" => [],
							"data" => [],
							"subtitulo" => "Cambio de clave de acceso",
							"texto" => "Se ha enviado un correo a <b>" . $usuario . "</b> para que puedas cambiar tu clave de acceso. Cualquier duda te puedes comunicar con nosotros. No olvides revisar tu bandeja de spam.",
							"color" => "alert-success",
							"url" => "login",
							"colorBoton" => "btn-success",
							"textoBoton" => "Regresar"
						];
						$this->vista("mensaje", $datos);
					} else {
						$datos = [
							"titulo" => "Error al cambiar la clave de acceso",
							"menu" => false,
							"errores" => [],
							"data" => [],
							"subtitulo" => "Error al cambiar la clave de acceso",
							"texto" => "Error al enviar el correo a <b>" . $usuario . "</b> para que puedas cambiar tu clave de acceso. Cualquier duda te puedes comunicar con nosotros. Inténtalo más tarde.",
							"color" => "alert-danger",
							"url" => "login",
							"colorBoton" => "btn-danger",
							"textoBoton" => "Regresar"
						];
						$this->vista("mensaje", $datos);
					}
					exit;
				} else {
					array_push($errores, "No existe el correo electrónico en la base de datos.");
				}
			}
		}
		$datos = [
			"titulo" => "Olvido de contraseña",
			"subtitulo" => "¿Olvidaste la contraseña?",
			"errores" => $errores,
			"data" => []
		];
		$this->vista("loginOlvidoVista", $datos);
	}

	public function cambiarClave($id = '')
	{
		$id = Helper::desencriptar($id);
		$errores = [];
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$clave1 = $_POST['clave'] ?? "";
			$clave2 = $_POST['verifica'] ?? "";
			$id = $_POST['id'] ?? "";
			//
			if (empty($clave1)) {
				array_push($errores, "La clave de acceso es requerida.");
			}
			if (empty($clave2)) {
				array_push($errores, "La clave de acceso de verificación es requerida.");
			}
			if ($clave1 != $clave2) {
				array_push($errores, "Las claves de acceso no coinciden.");
			}
			//
			if (count($errores) == 0) {
				$clave = hash_hmac("sha512", $clave1, CLAVE);
				$data = ["clave" => $clave, "id" => $id];
				if ($this->modelo->actualizarClaveAcceso($data)) {
					$datos = [
						"titulo" => "Cambio de clave de acceso",
						"menu" => false,
						"errores" => [],
						"data" => [],
						"subtitulo" => "Cambio de clave de acceso",
						"texto" => "La clave de acceso se modificó correctamente.",
						"color" => "alert-success",
						"url" => "login",
						"colorBoton" => "btn-success",
						"textoBoton" => "Regresar"
					];
					$this->vista("mensaje", $datos);
				} else {
					$datos = [
						"titulo" => "Cambio de clave de acceso",
						"menu" => false,
						"errores" => [],
						"data" => [],
						"subtitulo" => "Cambio de clave de acceso",
						"texto" => "Existió un error al actualizar la clave de acceso. Favor de intentarlo más tarde o reportarlo a soporte técnico.",
						"color" => "alert-danger",
						"url" => "login",
						"colorBoton" => "btn-danger",
						"textoBoton" => "Regresar"
					];
					$this->vista("mensaje", $datos);
				}
				exit;
			}
		}
		$datos = [
			"titulo" => "Cambiar contraseña",
			"subtitulo" => "Cambiar contraseña",
			"errores" => $errores,
			"data" => $id
		];
		$this->vista("loginCambiarVista", $datos);
	}

	public function verificar()
	{
		$errores = [];
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$id = $_POST["id"] ?? "";
			$usuario = $_POST['usuario'] ?? "";
			$clave = $_POST['clave'] ?? "";
			$recordar = isset($_POST['recordar']) ? "on" : "off";
			//Recordar
			$valor = $usuario . "|" . Helper::encriptar($clave);
			if ($recordar == "on") {
				$fecha = time() + (60 * 60 * 24 * 7);
			} else {
				$fecha = time() - 1;
			}
			setcookie("datos", $valor, $fecha, RUTA);
			//
			if (empty($clave)) {
				array_push($errores, "La clave de acceso es requerida.");
			}
			if (empty($usuario)) {
				array_push($errores, "El usuario es requerido.");
			}
			// clave de acceso temporal
			if (strlen($clave) == 10) {
				$data = $this->modelo->buscarCorreo($usuario);
				$id = $data["id"];
				$estado = $data["estado"];
				if (empty($id)) {
					$this->mensaje(
						"Error en el acceso",
						"Error en el acceso",
						"Favor de verificar el usuario",
						"login",
						"danger"
					);
				} else {
					if ($data["clave"] == $clave) {
						$datos = [
							"titulo" => "Añadir contraseña",
							"subtitulo" => "Añadir contraseña",
							"menu" => false,
							"admon" => "admon",
							"errores" => [],
							"data" => Helper::encriptar($id)
							//"data" => $id
						];
						$this->vista("loginCambiarVista",$datos);
					} else {
						$this->mensaje(
							"Error en el acceso",
							"Error en el acceso",
							"Favor de verificar el usuario",
							"login",
							"danger"
						);
					}
				}
				exit;
			}
			if (count($errores) == 0) {
				$clave = hash_hmac("sha512", $clave, CLAVE);
				$data = $this->modelo->buscarCorreo($usuario);
				if ($data && $data["clave"] == $clave) {
					$sesion = new Sesion();
					$sesion->iniciarLogin($data);
					header("location:" . RUTA . "tablero");
				} else {
					$datos = [
						"titulo" => "Sistema de biblioteca",
						"menu" => false,
						"errores" => [],
						"data" => [],
						"subtitulo" => "Sistema de biblioteca",
						"texto" => "Existió un error al entrar al sistema. Favor de intentarlo nuevamente.",
						"color" => "alert-danger",
						"url" => "login",
						"colorBoton" => "btn-danger",
						"textoBoton" => "Regresar"
					];
					$this->vista("mensaje", $datos);
				}
				exit;
			}
		}
	}
}
