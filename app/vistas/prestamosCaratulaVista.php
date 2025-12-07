<?php include("encabezado.php"); ?>
  <div class="table-responsive">
  <table class="table table-striped" width="100%">
  <thead>
    <tr>
    <th>Clave</th>
    <th>Título</th>
    <th>Usuario</th>
    <th>Fecha inicio</th>
    <th>Fecha final</th>
  </tr>
  </thead>
  <tbody>
    <?php
    for($i=0; $i<count($datos['data']); $i++){
      print "<tr>";
      print "<td class='text-left'>".$datos["data"][$i]['clave']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['titulo']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['usuario']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]["prestamo"]."</td>";
      print "<td class='text-left'>".$datos["data"][$i]["devolucion"]."</td>";
      print "</tr>";
    }
    ?>
  </tbody>
  </table>
<?php include("paginacion.php"); ?>
<a href="<?php print RUTA; ?>prestamos/alta" class="btn btn-success">
  Dar de alta un préstamo</a>
  <a href="<?php print RUTA; ?>prestamos/devolver" class="btn btn-success">
  Devolver un libro</a>
  </div>
<?php include("piepagina.php"); ?>