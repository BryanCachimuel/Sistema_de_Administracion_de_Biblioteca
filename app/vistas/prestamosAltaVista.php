<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>prestamos/alta/" method="POST">

    <div class="form-group text-left">
      <label for="idUsuario">* Usuarios:</label>
      <select class="form-control" name="idUsuario" id="idUsuario" 
      <?php if (isset($datos["baja"])) { print " disabled "; } ?>
      >
      <option value="void">---Selecciona un usuario---</option>
        <?php
          for ($i=0; $i < count($datos["usuarios"]); $i++) { 
            print "<option value='".$datos["usuarios"][$i]["id"]."'";
              if(isset($datos["data"]["idUsuario"]) && $datos["data"]["idUsuario"]==$datos["usuarios"][$i]["id"]){
                print " selected ";
              }
            print ">".$datos["usuarios"][$i]["usuario"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-left">
      <label for="idCopia">* Copias disponibles:</label>
      <select class="form-control" name="idCopia" id="idCopia" 
      <?php if (isset($datos["baja"])) { print " disabled "; } ?>
      >
      <option value="void">---Selecciona una copia disponible---</option>
        <?php
          for ($i=0; $i < count($datos["copias"]); $i++) { 
            print "<option value='".$datos["copias"][$i]["id"]."'";
              if(isset($datos["data"]["idCopia"]) && $datos["data"]["idCopia"]==$datos["copias"][$i]["id"]){
                print " selected ";
              }
            print ">".$datos["copias"][$i]["copia"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-left">
      <label for="prestamo">* Fecha de préstamo:</label>
      <input type="text" name="prestamo" id="prestamo" class="form-control"  <?php if (isset($datos["baja"])) { print " disabled "; }?>
      value="<?php print isset($datos['data']['prestamo'])?$datos['data']['prestamo']:''; ?>"
      >
    </div>

    <div class="form-group text-left">
      <label for="devolucion">* Fecha de devolución:</label>
      <input type="text" name="devolucion" id="devolucion" class="form-control"  <?php if (isset($datos["baja"])) { print " disabled "; }?>
      value="<?php print isset($datos['data']['devolucion'])?$datos['data']['devolucion']:''; ?>"
      >
    </div>

    <div class="form-group text-left">
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; }?>">
      <input type="hidden" name="pag" id="id" value="<?php if (isset($datos['pag'])) { print $datos['pag']; } else { print "1"; } ?>">

      <?php
      if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>prestamos/bajaLogica/<?php print $datos['data']['id'].'/'.$datos['pag']; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA.'prestamos/'.$datos['pag'];?>" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información</b></p>
      <?php } else { ?> 
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA.'prestamos/'.$datos['pag']; ?>" class="btn btn-success">Regresar</a>
    <?php } ?> 

    </div>
  </form>
<?php include_once("piepagina.php"); ?>