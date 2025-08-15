<?php include("encabezado.php"); ?>

<div class="table-responsive">
    <table class="table table-striped" width="100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Categoría</th>
                <th>Modificar</th>
                <th>Borrar</th>
            </tr>
        </thead>
        <tbody>
            <?php
                for($i=0; $i<count($datos['data']); $i++){
                print "<tr>";
                print "<td class='text-left'>".$datos["data"][$i]['id']."</td>";
                print "<td class='text-left'>".$datos["data"][$i]['idioma']."</td>";
                print "<td><a href='".RUTA."categorias/modificar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-info'>Modificar</a></td>";
                print "<td><a href='".RUTA."categorias/borrar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-danger'>Borrar</a></td>";
                print "</tr>";
                }
            ?>
        </tbody>
    </table>
    <?php include("paginacion.php"); ?>
    <a href="<?php print RUTA; ?>categorias/alta" class="btn btn-success">Dar de alta una categoría</a>
</div>

<?php include("piePagina.php"); ?>