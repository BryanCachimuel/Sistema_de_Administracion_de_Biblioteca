<?php include("encabezado.php");?>
<form action="<?php print RUTA; ?>login/registroConfirmar/" method="POST">
    <div class="form-group text-left">
		<label for="clave">* Clave:</label>
		<input type="password" name="clave" id="clave" class="form-control" placeholder="Escribe la contraseña de acceso que se te envió por correo electrónico." value="" required>
	</div>
	<div class="form-group text-left mt-2">
		<input type="hidden" name="id" id="id" class="form-control" value="<?php if(isset($datos["data"])){ print $datos["data"]; } else { print '';} ?>">
		<input type="submit" class="btn btn-success">
	</div>
</form>
<?php include("piePagina.php");?>