<?php include("encabezado.php"); ?>
  <div class="table-responsive">
  <ul>
  <?php  
  for ($i=0; $i < count($datos["autores"]); $i++) { 
      print "<li>".$datos["autores"][$i]["autor"]."</li>"; 
  }
  ?>
  </ul>
  <table class="table table-striped" width="100%">
  <thead>
    <tr>
    <th>Id</th>
    <th>Clave</th>
    <th>Copias</th>
    <th>Año</th>
    <th>Edición</th>
    <th class='text-center'>Estado</th>
  </tr>
  </thead>
  <tbody>
    <?php
    for($i=0; $i<count($datos['copias']); $i++){
      print "<tr>";
      print "<td class='text-left'>".$datos["copias"][$i]['id']."</td>";
      print "<td class='text-left'>".$datos["copias"][$i]['clave']."</td>";
      print "<td class='text-left'>".$datos["copias"][$i]['copia']."</td>";
      print "<td class='text-left'>".$datos["copias"][$i]['anio']."</td>";
      print "<td class='text-left'>".$datos["copias"][$i]['edicion']."</td>";
      if ($datos["copias"][$i]['estado']==COPIA_DISPONIBLE) {
        print "<td class='text-center text-success'>".$datos["copias"][$i]['estadoCopia']."</td>";
      } else if ($datos["copias"][$i]['estado']==COPIA_PRESTADO) {
        print "<td class='text-center text-info'>".$datos["copias"][$i]['estadoCopia']."</td>";
      } else {
        print "<td class='text-center text-danger'>".$datos["copias"][$i]['estadoCopia']."</td>";
      }
      
      print "</tr>";
    }
    ?>
  </tbody>
  </table>
<a href="<?php print RUTA; ?>consultar/consultar" class="btn btn-success">
  Regresar</a>
  </div>
<?php include("piepagina.php"); ?>