<?php include("encabezado.php"); ?>

<form action="<?php print RUTA; ?>login/olvidoVerificar" method="POST">

    <div class="form-group text-left">
        <label for="correo">* Correo:</label>
        <input type="email" class="form-control" name="correo" placeholder="Escribe tu correo electrónico">
    </div>

    <div class="form-group text-left mt-2">
        <input type="submit" value="Enviar" class="btn btn-success">
        <a href="<?php print RUTA; ?>login/caratula" type="button" class="btn btn-info">Regresar</a>
    </div>
</form>

<?php include("piePagina.php"); ?>