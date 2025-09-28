<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>prestamos/devolver/" method="POST">

    <div class="form-group text-left">
      <label for="copia">* Clave de copia:</label>
      <input type="text" name="copia" id="copia" class="form-control" required>
    </div>

    <div class="form-group text-left">
      <label for="num">* Número copia:</label>
      <input type="text" name="num" id="num" class="form-control" required>
    </div>

    <div class="form-group text-left">
      <label for="idEstado">* Estados:</label>
      <select class="form-control" name="idEstado" id="idEstado">
        <?php
          for ($i=0; $i < count($datos["estados"]); $i++) { 
            if ($datos["estados"][$i]["id"]==COPIA_PRESTADO) {
              continue;
            }
            print "<option value='".$datos["estados"][$i]["id"]."'";
              if($datos["estados"][$i]["id"]==COPIA_DISPONIBLE){
                print " selected ";
              }
            print ">".$datos["estados"][$i]["estadoCopia"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-left mt-3">
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA.'prestamos/1'; ?>" class="btn btn-success">Regresar</a>
    </div>
  </form>
<?php include_once("piepagina.php"); ?>