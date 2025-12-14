<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>idiomas/alta/" method="POST">

    <div class="form-group text-left mb-3">
      <label for="idioma">* <i class="fa-solid fa-earth-americas"></i> Idioma:</label>
      <input type="text" name="idioma" id="idioma" class="form-control" required value="<?php print isset($datos['data']['idioma'])?$datos['data']['idioma']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">
      <input type="hidden" name="pag" id="id" value="<?php if (isset($datos['pag'])) { print $datos['pag']; } else { print "1"; } ?>">

      <?php
      if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>idiomas/bajaLogica/<?php print $datos['data']['id'].'/'.$datos['pag']; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA.'idiomas/'.$datos['pag'];?>" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información</b></p>
      <?php } else { ?> 
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA.'idiomas/'.$datos['pag']; ?>" class="btn btn-success">Regresar</a>
    <?php } ?> 

    </div>
  </form>
<?php include_once("piepagina.php"); ?>