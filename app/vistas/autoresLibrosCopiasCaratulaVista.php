<?php include("encabezado.php"); ?>
  <div class="table-responsive">
  <table class="table table-striped" width="100%">
  <thead>
    <tr>
    <th>Id</th>
    <th>#</th>
    <th>Clave</th>
    <th>Edición</th>
    <th>Año</th>
    <th>Estado</th>
  </tr>
  </thead>
  <tbody>
    <?php
    for($i=0; $i<count($datos['data']); $i++){
      print "<tr>";
      print "<td class='text-left'>".$datos["data"][$i]['id']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['copia']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['clave']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['edicion']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['anio']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['estado']."</td>";
      print "</tr>";
    }
    ?>
  </tbody>
  </table>
  <a href="<?php print RUTA.$datos["activo"]; ?>" class="btn btn-success">Regresar</a>
  </div>
<?php include("piepagina.php"); ?>