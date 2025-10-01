<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php print "Biblioteca | " . $datos["titulo"]; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a href='<?php print RUTA . "tablero"; ?>' class="navbar-brand">Biblioteca</a>
        <?php
        if (isset($datos["menu"]) && $datos["menu"] == true) {
            if (isset($datos["admon"]) && $datos["admon"] == ADMON) {
                print "<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "autores' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "autores") print "active";
                print "'>Autores</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "libros' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "libros") print "active";
                print "'>Libros</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "usuarios' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "usuarios") print "active";
                print "'>Usuarios</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "categorias' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "categorias") print "active";
                print "'>Categorías</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "editoriales' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "editoriales") print "active";
                print "'>Editoriales</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "temas' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "temas") print "active";
                print "'>Temas</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "idiomas' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "idiomas") print "active";
                print "'>Idiomas</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "prestamos' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "prestamos") print "active";
                print "'>Préstamos</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "copias' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "copias") print "active";
                print "'>Copias</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "paises' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "paises") print "active";
                print "'>Países</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "tablero/respaldar' class='nav-link'>Respaldar</a>";
                print "</li>";
                //
                print "</ul>";
            } else {
                print "<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "consultas' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "consultas") print "active";
                print "'>Consultas</a>";
                print "</li>";
                print "</ul>";
            }
        }
        if (isset($_SESSION['usuario'])) {
            print "<ul class='nav navbar-nav ms-auto'>";
            //
            print "<li class='nav-item'>";
            print "<a href='" . RUTA . "tablero/perfil' class='nav-link'>";
            if (isset($datos["data"]["foto"]) && $datos["data"]["foto"] != "") {
                print "<img src='" . RUTA . "public/fotos/" . $datos["data"]["foto"] . "' width='40'/>";
            } else {
                print '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-square" viewBox="0 0 16 16">
  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
  <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
</svg>';
            }
            print "</a>";
            print "</li>";
            print "<li class='nav-item'>";
            print "<a href='" . RUTA . "tablero/logout' class='nav-link'>";
            print '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
  <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
</svg>';
            print "</a></li>";
            print "</ul>";
        }
        ?>
    </nav>
    <div class="container-fluid">
        <div class="row content">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <?php
                if (isset($datos["errores"])) {
                    if (count($datos["errores"]) > 0) {
                        print "<div class='alert alert-danger mt-3'><ul>";
                        foreach ($datos["errores"] as $valor) {
                            print "<li>" . $valor . "</li>";
                        }
                        print "</ul></div>";
                    }
                }
                ?>
                <div class="card p-4 mt-3 bg-light">
                    <div class="card-header text-center">
                        <h2><?php print $datos["subtitulo"]; ?></h2>
                    </div>
                    <div class="card-body">