<?php include("encabezado.php"); ?>
  <div class="table-responsive">
  <table class="table table-striped" width="100%">
  <thead>
    <tr>
    <th>id</th>
    <th>Clave</th>
    <th>Titulo</th>
    <th>Edición</th>
    <th>Copia</th>
    <th>Estado</th>
    <th>Modificar</th>
    <th>Borrar</th>
  </tr>
  </thead>
  <tbody>
    <?php
    for($i=0; $i<count($datos['data']); $i++){
      print "<tr>";
      print "<td class='text-left'>".$datos["data"][$i]['id']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['clave']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['titulo']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['edicion']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['copia']."</td>";
      print "<td class='text-left ";
      if ($datos["data"][$i]['estado']==COPIA_DISPONIBLE) {
        print " text-success";
      } else if ($datos["data"][$i]['estado']==COPIA_PRESTADO) {
        print " text-info";
      } else {
        print " text-danger";
      }
      print "'>".$datos["data"][$i]['estadoCopia']."</td>";
      print "<td><a href='".RUTA."copias/modificar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-info";
      if ($datos["data"][$i]['estado']==COPIA_PRESTADO) {
        print " disabled";
      }
      print "'>Modificar</a></td>";
      print "<td><a href='".RUTA."copias/borrar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-danger";
      if ($datos["data"][$i]['estado']==COPIA_PRESTADO) {
          print " disabled";
      }
      print "'>Borrar</a></td>";
      print "</tr>";
    }
    ?>
  </tbody>
  </table>
<?php include("paginacion.php"); ?>
<a href="<?php print RUTA; ?>copias/alta" class="btn btn-success">
  Dar de alta una copia</a>
  <br>
  <p>* Las copias <b>prestadas</b> no pueden ser modificadas ni borradas.</p>
  </div>
<?php include("piepagina.php"); ?>