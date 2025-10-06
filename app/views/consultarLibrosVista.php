<?php include("encabezado.php"); ?>
  <div class="table-responsive">
  <table class="table table-striped" width="100%">
  <thead>
    <tr>
    <th>Id</th>
    <th>Tema</th>
    <th>Título</th>
    <th>Autores</th>
    <th>Copias</th>
  </tr>
  </thead>
  <tbody>
    <?php
    for($i=0; $i<count($datos['data']); $i++){
      print "<tr>";
      print "<td class='text-left'>".$datos["data"][$i]['id']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['tema']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['titulo']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['autor']."</td>";
      print "<td><a href='".RUTA."consultar/copias/".$datos["data"][$i]["id"]."' class='btn btn-warning'>Copias</a></td>";
      print "</tr>";
    }
    ?>
  </tbody>
  </table>
<a href="<?php print RUTA; ?>consultar/consultar" class="btn btn-success">
  Regresar</a>
  </div>
<?php include("piepagina.php"); ?>