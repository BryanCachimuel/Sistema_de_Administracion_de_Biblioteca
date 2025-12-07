<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>libros/alta/" method="POST">

    <div class="form-group text-left">
      <label for="idTema">* Tema:</label>
      <select class="form-control" name="idTema" id="idTema" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
      <option value="void">---Selecciona un tema---</option>
        <?php
          for ($i=0; $i < count($datos["temas"]); $i++) { 
            print "<option value='".$datos["temas"][$i]["id"]."'";
            if(isset($datos["data"]["idTema"]) && $datos["data"]["idTema"]==$datos["temas"][$i]["id"]){
              print " selected ";
            }
            print ">".$datos["temas"][$i]["tema"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-left">
      <label for="idIdioma">* Idioma principal del libro:</label>
      <select class="form-control" name="idIdioma" id="idIdioma" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
      <option value="void">---Selecciona un idioma---</option>
        <?php
          for ($i=0; $i < count($datos["idiomas"]); $i++) { 
            print "<option value='".$datos["idiomas"][$i]["id"]."'";
            if(isset($datos["data"]["idIdioma"]) && $datos["data"]["idIdioma"]==$datos["idiomas"][$i]["id"]){
              print " selected ";
            }
            print ">".$datos["idiomas"][$i]["idioma"]."</option>";
          } 
        ?>
      </select>
    </div>


    <div class="form-group text-left">
      <label for="titulo">* Título:</label>
      <input type="text" name="titulo" id="titulo" class="form-control"
      placeholder="Escribe el título del libro." required value="<?php print isset($datos['data']['titulo'])?$datos['data']['titulo']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">
      <input type="hidden" name="pag" id="id" value="<?php if (isset($datos['pag'])) { print $datos['pag']; } else { print "1"; } ?>">

      <?php
      if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>libros/bajaLogica/<?php print $datos['data']['id'].'/'.$datos['pag']; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA.'libros/'.$datos['pag'];?>" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información</b></p>
      <?php } else { ?> 
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA.'libros/'.$datos['pag']; ?>" class="btn btn-success">Regresar</a>
    <?php } ?> 
    </div>
  </form>
<?php include_once("piepagina.php"); ?>