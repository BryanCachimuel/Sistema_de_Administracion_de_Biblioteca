<?php include_once("encabezado.php"); ?>

  <form action="<?php print RUTA; ?>categorias/alta/" method="POST">

    <div class="form-group text-left">
      <label for="categoria">* Categoria:</label>
      <input type="text" name="categoria" id="categoria" class="form-control" required value="<?php print isset($datos['data']['categoria'])?$datos['data']['categoria']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left mt-3">
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">
      <input type="hidden" name="pag" id="id" value="<?php if (isset($datos['pag'])) { print $datos['pag']; } else { print "1"; } ?>">
      
      <?php
      if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>categorias/bajaLogica/<?php print $datos['data']['id']."/".$datos["pag"]; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA.'categorias/'.$datos['pag'];?>" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información</b></p>
      <?php } else { ?> 
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA.'categorias/'.$datos["pag"]; ?>" class="btn btn-success">Regresar</a>
    <?php } ?> 
    </div>
  </form>

<?php include_once("piepagina.php"); ?>