<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>libros/librosAutoresAlta/" method="POST">

    <div class="form-group text-left">
      <label for="idAutor">* Autor:</label>
      <select class="form-control" name="idAutor" id="idAutor" 
      <?php if (isset($datos["baja"])) { print " disabled "; } ?>
      >
      <option value="void">---Selecciona un autor(a)---</option>
        <?php
          for ($i=0; $i < count($datos["data"]); $i++) { 
            print "<option value='".$datos["data"][$i]["id"]."'";
              if(isset($datos["data"]["idAutor"]) && $datos["data"]["idAutor"]==$datos["autores"][$i]["id"]){
                print " selected ";
              }
            print ">".$datos["data"][$i]["autor"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-left">
      <input type="hidden" name="idLibro" id="idLibro" value="<?php if (isset($datos['idLibro'])) { print $datos['idLibro']; } else { print ""; }?>">

      <?php
       if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>libros/bajaLogicaLibroAutor/<?php print $datos['data']['idLibro']; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA; ?>libros" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información</b></p>
      <?php } else { ?> 
      <input type="submit" value="Anexar un autor" class="btn btn-success">
      <a href="<?php print RUTA; ?>libros" class="btn btn-info">Regresar</a>
      <?php } ?> 
    </div>
  </form>
<?php include_once("piepagina.php"); ?>