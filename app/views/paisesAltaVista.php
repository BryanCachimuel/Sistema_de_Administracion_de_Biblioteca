<?php include_once("encabezado.php"); ?>

  <form action="<?php print RUTA; ?>paises/alta/" method="POST">

    <div class="form-group text-left">
      <label for="pais">* País:</label>
      <input type="text" name="pais" id="pais" class="form-control" required value="<?php print isset($datos['data']['pais'])?$datos['data']['pais']:''; ?>">
    </div>

    <div class="form-group text-left mt-3">
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">
      
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA; ?>paises" class="btn btn-info">Regresar</a>
    </div>
  </form>

<?php include_once("piepagina.php"); ?>