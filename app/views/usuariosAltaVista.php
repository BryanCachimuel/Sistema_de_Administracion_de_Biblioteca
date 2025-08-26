<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>usuarios/alta/" method="POST">

    <div class="form-group text-left">
      <label for="correo">* Correo (usuario):</label>
      <input type="email" name="correo" id="correo" class="form-control" required >
    </div>

    <div class="form-group text-left">
      <label for="nombre">* Nombre(s):</label>
      <input type="text" name="nombre" id="nombre" class="form-control"
      placeholder="Escribe el nombre del usuario." required >
    </div>

    <div class="form-group text-left">
      <label for="apellidoPaterno">* Apellido paterno:</label>
      <input type="text" name="apellidoPaterno" id="apellidoPaterno" class="form-control"
      placeholder="Escribe el apellido paterno del usuario." required >
    </div>

    <div class="form-group text-left">
      <label for="apellidoMaterno">Apellido materno:</label>
      <input type="text" name="apellidoMaterno" id="apellidoMaterno" class="form-control"
      placeholder="Escribe el apellido paterno del usuario.">
    </div>

    <div class="form-group text-left">
      <label for="genero">* Género:</label>
      <select class="form-control" name="genero" id="genero">
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
      <label for="telefono">Teléfono:</label>
      <input type="text" name="telefono" id="telefono" class="form-control"
      placeholder="Escribe el telefono del usuario." >
    </div>

    <div class="form-group text-left">
      <label for="fechaNacimiento">Fecha nacimiento:</label>
      <input type="date" name="fechaNacimiento" id="fechaNacimiento" class="form-control"
      placeholder="Seleccione la fecha de nacimiento del usuario." >
    </div>

    <div class="form-group text-left">
      <label for="idTipoUsuario">* Tipo de usuario:</label>
      <select class="form-control" name="idTipoUsuario" id="idTipoUsuario">
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

    <div class="form-group text-left mb-3">
      <label for="estado">* Estado usuario:</label>
      <select class="form-control" name="estado" id="estado">
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
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA; ?>usuarios" class="btn btn-info">Regresar</a>
    </div>
  </form>
<?php include_once("piepagina.php"); ?>