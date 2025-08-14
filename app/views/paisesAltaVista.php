<?php include_once("encabezado.php"); ?>

  <form action="<?php print RUTA; ?>paises/alta/" method="POST">

    <div class="form-group text-left">
      <label for="pais">* País:</label>
      <input type="text" name="pais" id="pais" class="form-control" required value="<?php print isset($datos['data']['pais'])?$datos['data']['pais']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left mt-3">
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">
      <input type="hidden" name="pag" id="id" value="<?php if (isset($datos['pag'])) { print $datos['pag']; } else { print "1"; } ?>">
      
      <?php
      if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>paises/bajaLogica/<?php print $datos['data']['id']."/".$datos["pag"]; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA; ?>paises" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información</b></p>
      <?php } else { ?> 
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA.'paises/'.$datos["pag"]; ?>" class="btn btn-success">Regresar</a>
    <?php } ?> 
    </div>
  </form>

<?php include_once("piepagina.php"); ?>