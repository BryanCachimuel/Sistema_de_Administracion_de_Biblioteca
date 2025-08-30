<?php include("encabezado.php"); ?>
<div class="table-responsive">
  <table class="table table-striped" width="100%">
    <thead>
      <tr class="text-center">
        <th>id</th>
        <th>Tema</th>
        <th>Título</th>
        <th>Idioma</th>
        <th>Autor(es)</th>
        <th>Modificar</th>
        <th>Borrar</th>
      </tr>
    </thead>
    <tbody class="text-center">
       <?php
        for($i=0; $i<count($datos['data']); $i++){
        print "<tr>";
        print "<td>".$datos["data"][$i]['id']."</td>";
        print "<td>".$datos["data"][$i]['tema']."</td>";
        print "<td>".$datos["data"][$i]['titulo']."</td>";
        print "<td>".$datos["data"][$i]['idioma']."</td>";
        print "<td><a href='".RUTA."libros/librosAutores/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-warning'>Autores</a></td>";
        print "<td><a href='".RUTA."libros/modificar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-info'>Modificar</a></td>";
        print "<td><a href='".RUTA."libros/borrar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-danger'>Borrar</a></td>";
        print "</tr>";
        }
    ?>
    </tbody>
  </table>
  <?php include("paginacion.php"); ?>
  <a href="<?php print RUTA; ?>libros/alta" class="btn btn-success">
    Dar de alta un libro</a>
</div>
<?php include("piepagina.php"); ?>