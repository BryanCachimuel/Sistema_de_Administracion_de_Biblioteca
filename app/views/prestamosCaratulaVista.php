<?php include("encabezado.php"); ?>
<div class="table-responsive">
  <table class="table table-striped" width="100%">
    <thead>
      <tr class="text-center">
        <th>Clave</th>
        <th>Título</th>
        <th>Usuario</th>
        <th>Fecha Inicio</th>
        <th>Fecha Final</th>
      </tr>
    </thead>
    <tbody class="text-center">
       <?php
        for($i=0; $i<count($datos['data']); $i++){
        print "<tr>";
        print "<td>".$datos["data"][$i]['clave']."</td>";
        print "<td>".$datos["data"][$i]['titulo']."</td>";
        print "<td>".$datos["data"][$i]['usuario']."</td>";
        print "<td>".$datos["data"][$i]['prestamo']."</td>";
        print "<td>".$datos["data"][$i]['devolución']."</td>";
        print "</tr>";
        }
    ?>
    </tbody>
  </table>
  <?php include("paginacion.php"); ?>
  <a href="<?php print RUTA; ?>prestamos/alta" class="btn btn-success">
    Dar de alta un prestamo</a>
</div>
<?php include("piepagina.php"); ?>