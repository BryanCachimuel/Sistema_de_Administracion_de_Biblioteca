<?php include_once("encabezado.php"); 

print '<div class="alert '.$datos["color"].'"mt-3>';
print '<h4>'.$datos["texto"].'</h4>';
print '</div>';
print '<a href="'.RUTA.$datos["url"].'" class="btn '.$datos["colorBoton"].'" >';
print $datos["textoBoton"].'</a>';
include_once("piePagina.php"); ?>