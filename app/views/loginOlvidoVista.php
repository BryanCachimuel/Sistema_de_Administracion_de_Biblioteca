<?php include("encabezado.php"); ?>

<form action="<?php print RUTA; ?>login/olvidoVerificar" method="POST" autocomplete="off">

    <div class="form-group text-left">
        <label for="usuario">* <i class="fa-regular fa-envelope"></i> Correo:</label>
        <input type="email" class="form-control" name="usuario" placeholder="Escribe tu correo electrónico" required>
    </div>

    <div class="form-group text-left mt-2">
        <input type="submit" value="Enviar" class="btn btn-success">
        <a href="<?php print RUTA; ?>login/caratula" type="button" class="btn btn-info"><i class="fa-solid fa-angles-left"></i> Regresar</a>
    </div>
</form>

<?php include("piePagina.php"); ?>