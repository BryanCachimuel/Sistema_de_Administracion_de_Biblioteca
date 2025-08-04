<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print "Biblioteca | ".$datos["titulo"]; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</head>

<body>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a href="<?php print RUTA.'tablero'; ?>" class="navbar-brand">Biblioteca</a>
        <?php
            if(isset($datos["menu"]) && $datos["menu"] == true) {
                print "<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";
                //
                print "<li class='nav-item'>";
                print "<a href='".RUTA."autores' class='nav-link ";
                if(isset($datos["activo"]) && $datos["activo"] == "autores") print "active";
                print "'>Autores</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                 print "<a href='".RUTA."libros' class='nav-link ";
                if(isset($datos["activo"]) && $datos["activo"] == "libros") print "active";
                print "'>Libros</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='".RUTA."usuarios' class='nav-link ";
                if(isset($datos["activo"]) && $datos["activo"] == "usuarios") print "active";
                print "'>Usuarios</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='".RUTA."categorias' class='nav-link ";
                if(isset($datos["activo"]) && $datos["activo"] == "categorias") print "active";
                print "'>Categorías</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='".RUTA."editoriales' class='nav-link ";
                if(isset($datos["activo"]) && $datos["activo"] == "editoriales") print "active";
                print "'>Editoriales</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='".RUTA."temas' class='nav-link ";
                if(isset($datos["activo"]) && $datos["activo"] == "temas") print "active";
                print "'>Temas</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='".RUTA."idiomas' class='nav-link ";
                if(isset($datos["activo"]) && $datos["activo"] == "idiomas") print "active";
                print "'>Idiomas</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='".RUTA."prestamos' class='nav-link ";
                if(isset($datos["activo"]) && $datos["activo"] == "prestamos") print "active";
                print "'>Prestamos</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='".RUTA."copias' class='nav-link ";
                if(isset($datos["activo"]) && $datos["activo"] == "copias") print "active";
                print "'>Copias</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='".RUTA."paises' class='nav-link ";
                if(isset($datos["activo"]) && $datos["activo"] == "paises") print "active";
                print "'>Países</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='".RUTA."tablero/respaldar' class='nav-link'>Respaldar</a>";
                print "</li>";
                print "</ul>";
            }
        ?>
    </nav>

    <div class="container-fluid">
        <div class="row content">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                
                <!-- Manejo de los errores -->
                <?php 
                    if(isset($datos["errores"])){
                        if(count($datos["errores"])>0){
                            print "<div class='alert alert-danger mt-3'><ul>";
                            foreach ($datos["errores"] as $valor) {
                                print "<li>".$valor."</li>";
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