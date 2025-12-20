<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>autores/alta/" method="POST">

    <div class="form-group text-left mb-3">
      <label for="nombre">* Nombre(s):</label>
      <input type="text" name="nombre" id="nombre" class="form-control"
      placeholder="Escribe el nombre del usuario." required value="<?php print isset($datos['data']['nombre'])?$datos['data']['nombre']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left mb-3">
      <label for="apellidoPaterno">* Apellido paterno:</label>
      <input type="text" name="apellidoPaterno" id="apellidoPaterno" class="form-control"
      placeholder="Escribe el apellido paterno del usuario." required value="<?php print isset($datos['data']['apellidoPaterno'])?$datos['data']['apellidoPaterno']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left mb-3">
      <label for="apellidoMaterno">Apellido materno:</label>
      <input type="text" name="apellidoMaterno" id="apellidoMaterno" class="form-control"
      placeholder="Escribe el apellido paterno del usuario." value="<?php print isset($datos['data']['apellidoMaterno'])?$datos['data']['apellidoMaterno']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left mb-3">
      <label for="genero">* Género:</label>
      <select class="form-control" name="genero" id="genero" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
      <option value="void">---Selecciona un género---</option>
        <?php
          for ($i=0; $i < count($datos["genero"]); $i++) { 
            print "<option value='".$datos["genero"][$i]["id"]."'";
            if(isset($datos["data"]["idGenero"]) && $datos["data"]["idGenero"]==$datos["genero"][$i]["id"]){
              print " selected ";
            }
            print ">".$datos["genero"][$i]["genero"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-left mb-3">
      <label for="idPais">* País de origen:</label>
      <select class="form-control" name="idPais" id="idPais" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
      <option value="void">---Selecciona el país de origen---</option>
        <?php
          for ($i=0; $i < count($datos["paises"]); $i++) { 
            print "<option value='".$datos["paises"][$i]["id"]."'";
            if(isset($datos["data"]["idPais"]) && $datos["data"]["idPais"]==$datos["paises"][$i]["id"]){
              print " selected ";
            }
            print ">".$datos["paises"][$i]["pais"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-left">
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">
      <input type="hidden" name="pag" id="id" value="<?php if (isset($datos['pag'])) { print $datos['pag']; } else { print "1"; } ?>">

      <?php
      if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>autores/bajaLogica/<?php print $datos['data']['id'].'/'.$datos['pag']; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA.'autores/'.$datos['pag'];?>" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información</b></p>
      <?php } else { ?> 
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA.'autores/'.$datos['pag']; ?>" class="btn btn-success">Regresar</a>
    <?php } ?> 
    </div>
  </form>
<?php include_once("piepagina.php"); ?>