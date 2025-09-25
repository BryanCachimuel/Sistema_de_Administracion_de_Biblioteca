<?php
define("RUTA", "/biblioteca/");
define("LLAVE1","Hombresneciosque");
define("LLAVE2","acusaisalamujer");
define("CLAVE","mimamamemimamucho");
define("TAMANO_PAGINA",6);
define('PAGINAS_MAXIMAS',4);
//
define('ADMON',1);
define('PROFESOR',2);
define('ESTUDIANTE',3);
define('EXTERNO',4);
//
//Estados usuario
//
define('USUARIO_ACTIVO',1);
define('USUARIO_INACTIVO',2);
define('USUARIO_SUSPENDIDO',3);
//
//Estados copias
//
define('COPIA_DISPONIBLE',1);
define('COPIA_PRESTADO',2);
define('COPIA_REPARACION',3);
define('COPIA_PERDIDO',4);
define('COPIA_NO_DISPONIBLE',5);
//
require_once("libs/MySQLdb.php");
require_once("libs/Helper.php");
require_once("libs/Sesion.php");
require_once("libs/Llaves.php");
require_once("libs/Controlador.php");
require_once("libs/Control.php");
?>