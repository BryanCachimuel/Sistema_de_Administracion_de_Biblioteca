<?php
// control de las rutas mediante una constante
define("RUTA", "/biblioteca/");

// Llaves para encriptación de datos del usuario
define("LLAVE1","Hombresneciosque");
define("LLAVE2","acusaisalamujer");
define("CLAVE","clavesecretamaxima");

// paginanción
define("TAMANO_PAGINA",6);
define("PAGINAS_MAXIMAS",4);

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
//Estado copias
//
define('DISPONIBLE',1);
define('PRESTADO',2);
define('REPARACION',3);
define('PERDIDO',4);
define('NO_DISPONIBLE',5);

require_once("libs/MySQLdb.php");
require_once("libs/Helper.php");
require_once("libs/Sesion.php");
require_once("libs/Llaves.php");
require_once("libs/Controlador.php");
require_once("libs/Control.php");