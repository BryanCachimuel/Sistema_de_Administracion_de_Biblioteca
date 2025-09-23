<?php include("encabezado.php"); ?>
<div class="table-responsive">
  <table class="table table-striped" width="100%">
    <thead>
      <tr class="text-center">
        <th>id</th>
        <th>Clave</th>
        <th>Título</th>
        <th>Edición</th>
        <th>Copia</th>
        <th>Estado</th>
        <th>Modificar</th>
        <th>Borrar</th>
      </tr>
    </thead>
    <tbody class="text-center">
       <?php
        for($i=0; $i<count($datos['data']); $i++){
        print "<tr>";
        print "<td>".$datos["data"][$i]['id']."</td>";
        print "<td>".$datos["data"][$i]['clave']."</td>";
        print "<td>".$datos["data"][$i]['titulo']."</td>";
        print "<td>".$datos["data"][$i]['edicion']."</td>";
        print "<td>".$datos["data"][$i]['copia']."</td>";
        print "<td>".$datos["data"][$i]['estadoCopia']."</td>";
        print "<td><a href='".RUTA."copias/modificar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-info'>Modificar</a></td>";
        print "<td><a href='".RUTA."copias/borrar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-danger'>Borrar</a></td>";
        print "</tr>";
        }
    ?>
    </tbody>
  </table>
  <?php include("paginacion.php"); ?>
  <a href="<?php print RUTA; ?>copias/alta" class="btn btn-success">
    Dar de alta una copia</a>
</div>
<?php include("piepagina.php"); ?>