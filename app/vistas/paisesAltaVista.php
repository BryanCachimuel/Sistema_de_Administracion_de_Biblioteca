<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>paises/alta/" method="POST">

    <div class="form-group text-left">
      <label for="pais">* <i class="fa-solid fa-earth-asia"></i> País:</label>
      <input type="text" name="pais" id="pais" class="form-control" required value="<?php print isset($datos['data']['pais'])?$datos['data']['pais']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">
      <input type="hidden" name="pag" id="id" value="<?php if (isset($datos['pag'])) { print $datos['pag']; } else { print "1"; } ?>">

      <?php
      if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>paises/bajaLogica/<?php print $datos['data']['id']."/".$datos["pag"]; ?>" class="btn btn-danger"><i class='fa-solid fa-trash-can'></i></a>
        <a href="<?php print RUTA; ?>paises" class="btn btn-danger"><i class="fa-solid fa-angles-left"></i> Regresar</a>
        <p><strong>Advertencia: una vez borrado el registro, no podrá recuperar la información</strong></p>
      <?php } else { ?> 
      <div class="mt-3">
        <input type="submit" value="Enviar" class="btn btn-success">
        <a href="<?php print RUTA.'paises/'.$datos["pag"]; ?>" class="btn btn-success"><i class="fa-solid fa-angles-left"></i> Regresar</a>
      </div>
    <?php } ?> 
    </div>
  </form>
<?php include_once("piepagina.php"); ?>