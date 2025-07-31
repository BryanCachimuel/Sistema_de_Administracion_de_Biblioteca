<?php include("encabezado.php"); ?>

<form action="" method="POST">

    <div class="form-group text-left">
        <label for="usuario">* Usuario:</label>
        <input type="text" class="form-control" name="usuario" placeholder="Escribe tu usuario (correo electrónico)">
    </div>

    <div class="form-group text-left">
        <label for="clave">* Clave:</label>
        <input type="password" class="form-control" name="clave" placeholder="Escribe tu clave de acceso">
    </div>

    <div class="form-group text-left mt-2">
        <input type="checkbox" name="recordar">
        <label for="recordar">Recordar</label>
    </div>

    <div class="form-group text-left mt-2">
        <input type="submit" value="Iniciar Sesión" class="btn btn-success">
    </div>

    <a href="login/olvido">¿Olvidaste tu clave de acceso?</a><br>
    <a href="#">Registrarse</a>
</form>

<?php include("piePagina.php"); ?>