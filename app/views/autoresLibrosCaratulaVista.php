<?php include("encabezado.php"); ?>
<div class="table-responsive">
    <table class="table table-striped" width="100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Tema</th>
                <th>Título</th>
                <th>Copias</th>
                <th>Quitar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $i < count($datos['data']); $i++) {
                print "<tr>";
                print "<td class='text-left'>" . $datos["data"][$i]['idLibro'] . "</td>";
                print "<td class='text-left'>" . $datos["data"][$i]['tema'] . "</td>";
                print "<td class='text-left'>" . $datos["data"][$i]['titulo'] . "</td>";
                print "<td><a href='" . RUTA . "autores/copias/" . $datos["data"][$i]["idLibro"] . "' class='btn btn-warning'>Copias</a></td>";
                print "<td><a href='" . RUTA . "autores/autoresLibrosQuitar/" . $datos["data"][$i]["id"] . "' class='btn btn-danger'>Quitar</a></td>";
                print "</tr>";
            }
            ?>
        </tbody>
    </table>
    <?php print "<a href='" . RUTA . "autores/autoresLibrosAlta/" . $datos["idAutor"] . "' class='btn btn-success'>Dar de alta un libro</a>"; ?>
    <a href="<?php print RUTA; ?>autores" class="btn btn-info">Regresar</a>
</div>
<?php include("piepagina.php"); ?>