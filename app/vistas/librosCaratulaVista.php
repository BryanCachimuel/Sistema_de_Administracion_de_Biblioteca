<?php include("encabezado.php"); ?>
  <div class="table-responsive">
  <table class="table table-striped" width="100%">
  <thead>
    <tr>
    <th>id</th>
    <th>Tema</th>
    <th>Título</th>
    <th>Idioma</th>
    <th>Copias</th>
    <th>Autor(es)</th>
    <th>Modificar</th>
    <th>Borrar</th>
  </tr>
  </thead>
  <tbody>
    <?php
    for($i=0; $i<count($datos['data']); $i++){
      print "<tr>";
      print "<td class='text-left'>".$datos["data"][$i]['id']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['tema']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['titulo']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['idioma']."</td>";
      print "<td><a href='".RUTA."libros/copias/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-warning'><i class='fa-solid fa-book'></i></a></td>";
      print "<td><a href='".RUTA."libros/librosAutores/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-warning'><i class='fa-solid fa-users-between-lines'></i></a></td>";
      print "<td><a href='".RUTA."libros/modificar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-info'><i class='fa-solid fa-pen-clip'></i></a></td>";
      print "<td><a href='".RUTA."libros/borrar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-danger'><i class='fa-solid fa-trash-can'></i></a></td>";
      print "</tr>";
    }
    ?>
  </tbody>
  </table>
<?php include("paginacion.php"); ?>
<a href="<?php print RUTA; ?>libros/alta" class="btn btn-success"><i class="fa-solid fa-circle-plus"></i> Dar de alta un libro</a></div>
<?php include("piepagina.php"); ?>