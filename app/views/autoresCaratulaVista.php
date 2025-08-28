<?php include("encabezado.php"); ?>
<div class="table-responsive">
  <table class="table table-striped" width="100%">
    <thead>
      <tr class="text-center">
        <th>id</th>
        <th>Nombre</th>
        <th>Apellido Paterno</th>
        <th>Apellido Materno</th>
        <th>País</th>
        <th>Libros</th>
        <th>Modificar</th>
        <th>Borrar</th>
      </tr>
    </thead>
    <tbody class="text-center">
       <?php
        for($i=0; $i<count($datos['data']); $i++){
        print "<tr>";
        print "<td class='text-left'>".$datos["data"][$i]['id']."</td>";
        print "<td class='text-left'>".$datos["data"][$i]['nombre']."</td>";
        print "<td class='text-left'>".$datos["data"][$i]['apellidoPaterno']."</td>";
        print "<td class='text-left'>".$datos["data"][$i]['apellidoMaterno']."</td>";
        print "<td><a href='".RUTA."autores/libros/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-warning'>Libros</a></td>";
        print "<td><a href='".RUTA."autores/modificar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-info'>Modificar</a></td>";
        print "<td><a href='".RUTA."autores/borrar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-danger'>Borrar</a></td>";
        print "</tr>";
        }
    ?>
    </tbody>
  </table>
  <?php include("paginacion.php"); ?>
  <a href="<?php print RUTA; ?>autores/alta" class="btn btn-success">
    Dar de alta un autor o autora</a>
</div>
<?php include("piepagina.php"); ?>