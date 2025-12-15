<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>usuarios/alta/" method="POST">

    <div class="form-group text-left">
      <label for="correo">* <i class="fa-regular fa-envelope"></i> Correo (usuario):</label>
      <input type="email" name="correo" id="correo" class="form-control" required value="<?php print isset($datos['data']['correo'])?$datos['data']['correo']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="nombre">* <i class="fa-regular fa-id-badge"></i> Nombre(s):</label>
      <input type="text" name="nombre" id="nombre" class="form-control"
      placeholder="Escribe el nombre del usuario." required value="<?php print isset($datos['data']['nombre'])?$datos['data']['nombre']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="apellidoPaterno">* <i class="fa-regular fa-id-badge"></i> Apellido paterno:</label>
      <input type="text" name="apellidoPaterno" id="apellidoPaterno" class="form-control"
      placeholder="Escribe el apellido paterno del usuario." required value="<?php print isset($datos['data']['apellidoPaterno'])?$datos['data']['apellidoPaterno']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="apellidoMaterno"><i class="fa-regular fa-id-badge"></i> Apellido materno:</label>
      <input type="text" name="apellidoMaterno" id="apellidoMaterno" class="form-control"
      placeholder="Escribe el apellido paterno del usuario." value="<?php print isset($datos['data']['apellidoMaterno'])?$datos['data']['apellidoMaterno']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="genero">* <i class="fa-solid fa-people-arrows"></i> Género:</label>
      <select class="form-control" name="genero" id="genero" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
      <option value="void">---Selecciona un género---</option>
        <?php
          for ($i=0; $i < count($datos["genero"]); $i++) { 
            print "<option value='".$datos["genero"][$i]["id"]."'";
            if(isset($datos["data"]["genero"]) && $datos["data"]["genero"]==$datos["genero"][$i]["id"]){
              print " selected ";
            }
            print ">".$datos["genero"][$i]["genero"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-left">
      <label for="telefono"><i class="fa-solid fa-mobile-screen"></i> Teléfono:</label>
      <input type="text" name="telefono" id="telefono" class="form-control"
      placeholder="Escribe el telefono del usuario." value="<?php print isset($datos['data']['telefono'])?$datos['data']['telefono']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="fechaNacimiento"><i class="fa-regular fa-calendar-days"></i> Fecha nacimiento:</label>
      <input type="date" name="fechaNacimiento" id="fechaNacimiento" class="form-control"
      placeholder="Seleccione la fecha de nacimiento del usuario." value="<?php print isset($datos['data']['fechaNacimiento'])?$datos['data']['fechaNacimiento']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="idTipoUsuario">* <i class="fa-solid fa-person-circle-check"></i> Tipo de usuario:</label>
      <select class="form-control" name="idTipoUsuario" id="idTipoUsuario" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
      <option value="void">---Selecciona un tipo de usuario---</option>
        <?php
          for ($i=0; $i < count($datos["tipoUsuarios"]); $i++) { 
            print "<option value='".$datos["tipoUsuarios"][$i]["id"]."'";
            if(isset($datos["data"]["idTipoUsuario"]) && $datos["data"]["idTipoUsuario"]==$datos["tipoUsuarios"][$i]["id"]){
              print " selected ";
            }
            print ">".$datos["tipoUsuarios"][$i]["tipoUsuario"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-left">
      <label for="estado">* <i class="fa-solid fa-chart-bar"></i> Estado usuario:</label>
      <select class="form-control" name="estado" id="estado" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
      <option value="void">---Selecciona un estado de usuario---</option>
        <?php
          for ($i=0; $i < count($datos["estadosUsuario"]); $i++) { 
            print "<option value='".$datos["estadosUsuario"][$i]["id"]."'";
            if(isset($datos["data"]["estado"]) && $datos["data"]["estado"]==$datos["estadosUsuario"][$i]["id"]){
              print " selected ";
            }
            print ">".$datos["estadosUsuario"][$i]["estado"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-left">
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">
      <input type="hidden" name="pag" id="id" value="<?php if (isset($datos['pag'])) { print $datos['pag']; } else { print "1"; } ?>">

      <?php
      if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>usuarios/bajaLogica/<?php print $datos['data']['id'].'/'.$datos['pag']; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA.'usuarios/'.$datos['pag'];?>" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información</b></p>
      <?php } else { ?> 
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA.'usuarios/'.$datos['pag']; ?>" class="btn btn-success">Regresar</a>
    <?php } ?> 
    </div>
  </form>
<?php include_once("piepagina.php"); ?>