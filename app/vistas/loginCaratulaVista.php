<?php include("encabezado.php"); ?>
	<form action="<?php print RUTA; ?>login/verificar" method="POST">
		<div class="form-group text-left">
			<label for="usuario">* Usuario:</label>
			<input type="text" name="usuario" class="form-control" placeholder="Escribe tu usuario (correo electrónico)" value="<?php print isset($datos['data']['usuario'])?$datos['data']['usuario']:''; ?>">
		</div>
		<div class="form-group text-left">
			<label for="clave">* Clave de acceso:</label>
			<input type="password" name="clave" class="form-control" placeholder="Escribe tu clave de acceso" value="<?php print isset($datos['data']['clave'])?$datos['data']['clave']:''; ?>">
		</div>
		<div class="form-group text-left mt-2">
			<input type="checkbox" name="recordar" <?php print isset($datos['data']['usuario'])?'checked':''; ?> >
			<label for="recordar">Recordar</label>
		</div>
		<div class="form-group text-left mt-2">
			<input type="submit" value="Enviar" class="btn btn-success">
		</div>
		<a href="<?php print RUTA; ?>login/olvidoVerificar">¿Olvidaste tu clave de acceso?</a><br>
		<a href="<?php print RUTA; ?>login/registrar">Registrarse</a>
	</form>
<?php include("piepagina.php"); ?>