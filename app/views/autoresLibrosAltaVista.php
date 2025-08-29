<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>autores/autoresLibrosAlta/" method="POST">

    <div class="form-group text-left">
      <label for="idLibro">* Libro:</label>
      <select class="form-control" name="idLibro" id="idLibro" 
      <?php if (isset($datos["baja"])) { print " disabled "; } ?>
      >
      <option value="void">---Selecciona un libro---</option>
        <?php
          for ($i=0; $i < count($datos["data"]); $i++) { 
            print "<option value='".$datos["data"][$i]["id"]."'";
              if(isset($datos["data"]["idLibro"]) && $datos["data"]["idLibro"]==$datos["libros"][$i]["id"]){
                print " selected ";
              }
            print ">".$datos["data"][$i]["titulo"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-left">
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['idAutor'])) { print $datos['idAutor']; } else { print ""; }?>">

      <?php
       if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>autores/bajaLogica/<?php print $datos['data']['idAutor']; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA; ?>autores" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información</b></p>
      <?php } else { ?> 
      <input type="submit" value="Añadir libro" class="btn btn-success">
      <a href="<?php print RUTA; ?>autores" class="btn btn-info">Regresar</a>
      <?php } ?> 
    </div>
  </form>
<?php include_once("piepagina.php"); ?>