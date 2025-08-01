<?php
// control de las rutas mediante una constante
define("RUTA", "/biblioteca/");

// Llaves para encriptación de datos del usuario
define("LLAVE1","Hombresneciosque");
define("LLAVE2","acusaisalamujer");

require_once("libs/MySQLdb.php");
require_once("libs/Helper.php");
require_once("libs/Controlador.php");
require_once("libs/Control.php");