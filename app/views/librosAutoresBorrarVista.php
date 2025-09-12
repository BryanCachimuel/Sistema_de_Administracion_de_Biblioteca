<?php include_once("encabezado.php"); ?>
    <div class="form-group text-left">
      <label for="autor">Autor:</label>
      <input type="text" name="autor" id="autor" class="form-control" disabled
      value="<?php print $datos['data']['apellidoPaterno']." ".$datos['data']['apellidoMaterno'].", ".$datos['data']['nombre']; ?>">
    </div>

    <div class="form-group text-left">
      <label for="titulo">Título:</label>
      <input type="text" name="titulo" id="titulo" class="form-control" disabled
      value="<?php print $datos['data']['titulo']; ?>">
    </div>

    <div class="form-group text-left mt-3">
        <a href="<?php print RUTA; ?>libros/librosAutoresBajaLogica/<?php print $datos['id'].'/'.$datos['pag'].'/'.$datos['data']['idLibro']; ?>" class="btn btn-danger">Quitar el autor</a>
        <a href="<?php print RUTA.'libros/'.$datos['pag'];?>" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información</b></p> 
    </div>
<?php include_once("piepagina.php"); ?>