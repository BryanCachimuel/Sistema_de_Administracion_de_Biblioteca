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
    <th class='text-center'>Días restantes</th>
  </tr>
  </thead>
  <tbody>
    <?php
    for($i=0; $i<count($datos['prestamos']); $i++){
      print "<tr>";
      print "<td class='text-left'>".$datos["prestamos"][$i]['clave']."</td>";
      print "<td class='text-left'>".$datos["prestamos"][$i]['titulo']."</td>";
      print "<td class='text-left'>".$datos["prestamos"][$i]['usuario']."</td>";
      print "<td class='text-left'>".$datos["prestamos"][$i]["fechaInicio"]."</td>";
      print "<td class='text-left'>".$datos["prestamos"][$i]["fechaFin"]."</td>";
      print "<td class='text-center ";
      if ($datos["prestamos"][$i]["dif"]>0) {
      	print "text-success";
      } else {
      	print "text-danger";
      }
      print "'>".$datos["prestamos"][$i]["dif"]."</td>";
      print "</tr>";
    }
    ?>
  </tbody>
  </table>
</div>
<?php include("piepagina.php"); ?>