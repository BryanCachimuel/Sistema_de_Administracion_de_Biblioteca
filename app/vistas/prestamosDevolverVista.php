<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>prestamos/devolver/" method="POST">

    <div class="form-group text-left mb-2">
      <label for="copia">* <i class="fa-solid fa-key"></i> Clave de copia:</label>
      <input type="text" name="copia" id="copia" class="form-control" required>
    </div>

    <div class="form-group text-left mb-2">
      <label for="num">* <i class="fa-solid fa-book-journal-whills"></i> Número copia:</label>
      <input type="text" name="num" id="num" class="form-control" required>
    </div>

    <div class="form-group text-left mb-2">
      <label for="idEstado">* <i class="fa-solid fa-chart-line"></i> Estados:</label>
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