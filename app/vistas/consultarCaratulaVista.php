<?php include("encabezado.php"); ?>
<div class="table-responsive">
  <table class="table table-striped" width="100%">
  <thead>
    <tr>
    <th>Clave</th>
    <th>Título</th>
    <th>Fecha inicio</th>
    <th>Fecha final</th>
  </tr>
  </thead>
  <tbody>
    <?php
    for($i=0; $i<count($datos['prestamos']); $i++){
      print "<tr>";
      print "<td class='text-left'>".$datos["prestamos"][$i]['clave']."</td>";
      print "<td class='text-left'>".$datos["prestamos"][$i]['titulo']."</td>";
      print "<td class='text-left'>".$datos["prestamos"][$i]["fechaInicio"]."</td>";
      print "<td class='text-left'>".$datos["prestamos"][$i]["fechaFin"]."</td>";
      print "</tr>";
    }
    ?>
  </tbody>
  </table>
</div>
<?php include("piepagina.php"); ?>