<?php include("encabezado.php"); ?>
<div class="table-responsive">
  <table class="table table-striped" width="100%">
    <thead>
      <tr>
        <th>id</th>
        <th>Editorial</th>
        <th>País</th>
        <th>Modificar</th>
        <th>Borrar</th>
      </tr>
    </thead>
    <tbody>
      <?php
      for ($i = 0; $i < count($datos['data']); $i++) {
        print "<tr>";
        print "<td class='text-left'>" . $datos["data"][$i]['id'] . "</td>";
        print "<td class='text-left'>" . $datos["data"][$i]['editorial'] . "</td>";
        print "<td class='text-left'>" . $datos["data"][$i]['pais'] . "</td>";
        print "<td><a href='" . RUTA . "editoriales/modificar/" . $datos["data"][$i]["id"] . "/" . $datos["pag"]["pagina"] . "' class='btn btn-info'>Modificar</a></td>";
        print "<td><a href='" . RUTA . "editoriales/borrar/" . $datos["data"][$i]["id"] . "/" . $datos["pag"]["pagina"] . "' class='btn btn-danger'>Borrar</a></td>";
        print "</tr>";
      }
      ?>
    </tbody>
  </table>
  <?php include("paginacion.php"); ?>
  <a href="<?php print RUTA; ?>editoriales/alta" class="btn btn-success">
    Dar de alta una editorial</a>
</div>
<?php include("piepagina.php"); ?>