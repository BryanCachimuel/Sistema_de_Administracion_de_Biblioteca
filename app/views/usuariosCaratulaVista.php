<?php include("encabezado.php"); ?>
<div class="table-responsive">
  <table class="table table-striped" width="100%">
    <thead>
      <tr class="text-center">
        <th>id</th>
        <th>Tipo Usuario</th>
        <th>Nombre</th>
        <th>Estado</th>
        <th>Modificar</th>
        <th>Borrar</th>
      </tr>
    </thead>
    <tbody class="text-center">
       <?php
        for($i=0; $i<count($datos['data']); $i++){
        print "<tr>";
        print "<td class='text-left'>".$datos["data"][$i]['id']."</td>";
        print "<td class='text-left'>".$datos["data"][$i]['tipoUsuario']."</td>";
        print "<td class='text-left'>".$datos["data"][$i]['nombre']."</td>";
        print "<td class='text-center'><a href='".RUTA."usuarios/estadoCambiar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-warning'>".$datos["data"][$i]['estado']."</a></td>";
        print "<td><a href='".RUTA."usuarios/modificar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-info'>Modificar</a></td>";
        print "<td><a href='".RUTA."usuarios/borrar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-danger'>Borrar</a></td>";
        print "</tr>";
        }
    ?>
    </tbody>
  </table>
  <?php include("paginacion.php"); ?>
  <a href="<?php print RUTA; ?>usuarios/alta" class="btn btn-success">
    Dar de alta un usuario</a>
</div>
<?php include("piepagina.php"); ?>