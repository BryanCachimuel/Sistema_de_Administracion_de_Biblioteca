<?php include("encabezado.php"); ?>
<div class="table-responsive">
    <table class="table table-striped" width="100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Aprellidos</th>
                <th>Nombres</th>
                <th>Quitar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $i < count($datos['data']); $i++) {
                print "<tr>";
                print "<td class='text-left'>" . $datos["data"][$i]['id'] . "</td>";
                print "<td class='text-left'>" . $datos["data"][$i]['apellidos'] . "</td>";
                print "<td class='text-left'>" . $datos["data"][$i]['nombre'] . "</td>";
                print "<td><a href='" . RUTA . "libros/librosAutoresQuitar/" . $datos["data"][$i]["id"] . "' class='btn btn-danger'>Quitar</a></td>";
                print "</tr>";
            }
            ?>
        </tbody>
    </table>
    <?php print "<a href='".RUTA."libros/librosAutoresAlta/".$datos["idLibro"]."' class='btn btn-success'>Relaciona un autor</a>"; ?>
    <a href="<?php print RUTA; ?>libros" class="btn btn-info">Regresar</a>
</div>
<?php include("piepagina.php"); ?>