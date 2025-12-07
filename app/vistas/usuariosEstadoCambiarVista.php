<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>usuarios/estadoActualizar/" method="POST">

    <div class="form-group text-left">
      <label for="nombre">* Nombre(s):</label>
      <input type="text" name="nombre" id="nombre" class="form-control"
       value="<?php print isset($datos['data']['nombre'])?$datos['data']['nombre']:''; ?>"  disabled>
    </div>

    <div class="form-group text-left">
      <label for="apellidoPaterno">* Apellido paterno:</label>
      <input type="text" name="apellidoPaterno" id="apellidoPaterno" class="form-control" value="<?php print isset($datos['data']['apellidoPaterno'])?$datos['data']['apellidoPaterno']:''; ?>" disabled>
    </div>

    <div class="form-group text-left">
      <label for="apellidoMaterno">Apellido materno:</label>
      <input type="text" name="apellidoMaterno" id="apellidoMaterno" class="form-control" value="<?php print isset($datos['data']['apellidoMaterno'])?$datos['data']['apellidoMaterno']:''; ?>" disabled>
    </div>

    <div class="form-group text-left">
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
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">
      <input type="hidden" name="pag" id="id" value="<?php if (isset($datos['pag'])) { print $datos['pag']; } else { print "1"; } ?>">

      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA.'usuarios/'.$datos['pag']; ?>" class="btn btn-success">Regresar</a>
    </div>
  </form>
<?php include_once("piepagina.php"); ?>