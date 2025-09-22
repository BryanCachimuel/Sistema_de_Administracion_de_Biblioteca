<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>copias/alta/" method="POST">

    <div class="form-group text-left">
      <label for="idLibro">* Libro:</label>
      <select class="form-control" name="idLibro" id="idLibro" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
      <option value="void">---Selecciona un libro---</option>
        <?php
          for ($i=0; $i < count($datos["libros"]); $i++) { 
            print "<option value='".$datos["libros"][$i]["id"]."'";
            if(isset($datos["data"]["idLibro"]) && $datos["data"]["idLibro"]==$datos["libros"][$i]["id"]){
              print " selected ";
            }
            print ">".$datos["libros"][$i]["titulo"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-left">
      <label for="clave">* Clave:</label>
      <input type="text" name="clave" id="clave" class="form-control"
      placeholder="Escribe la clave de la copia." required value="<?php print isset($datos['data']['nombre'])?$datos['data']['nombre']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="copia">Copia:</label>
      <input type="text" name="copia" id="copia" class="form-control"
      placeholder="Escribe el número de la copia."  value="<?php print isset($datos['data']['copia'])?$datos['data']['copia']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="anio">Año de impresión:</label>
      <input type="text" name="anio" id="anio" class="form-control"
      placeholder="Escribe el año de impresión." value="<?php print isset($datos['data']['anio'])?$datos['data']['anio']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="isdn">ISDN:</label>
      <input type="text" name="isdn" id="isdn" class="form-control"
      placeholder="Escribe el ISDN." value="<?php print isset($datos['data']['isdn'])?$datos['data']['isdn']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="edicion">Edición:</label>
      <input type="text" name="edicion" id="edicion" class="form-control"
      placeholder="Escribe la edición del libro." value="<?php print isset($datos['data']['edicion'])?$datos['data']['edicion']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="paginas">Número de páginas:</label>
      <input type="text" name="paginas" id="paginas" class="form-control"
      placeholder="Escribe el número de páginas del libro." value="<?php print isset($datos['data']['paginas'])?$datos['data']['paginas']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="idEditorial">* Editorial:</label>
      <select class="form-control" name="idEditorial" id="idEditorial" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
      <option value="void">---Selecciona la editorial---</option>
        <?php
          for ($i=0; $i < count($datos["editoriales"]); $i++) { 
            print "<option value='".$datos["editoriales"][$i]["id"]."'";
            if(isset($datos["data"]["idEditorial"]) && $datos["data"]["idEditorial"]==$datos["editoriales"][$i]["id"]){
              print " selected ";
            }
            print ">".$datos["editoriales"][$i]["editorial"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-left">
      <label for="idPais">* País:</label>
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
      <label for="estado">* Estado copia:</label>
      <select class="form-control" name="estado" id="estado" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
      <option value="void">---Selecciona el estado de la copia---</option>
        <?php
          for ($i=0; $i < count($datos["estadosCopias"]); $i++) { 
            print "<option value='".$datos["estadosCopias"][$i]["id"]."'";
            if(isset($datos["data"]["estado"]) && $datos["data"]["estado"]==$datos["estadosCopias"][$i]["id"]){
              print " selected ";
            }
            print ">".$datos["estadosCopias"][$i]["estadoCopia"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-left">
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">
      <input type="hidden" name="pag" id="id" value="<?php if (isset($datos['pag'])) { print $datos['pag']; } else { print "1"; } ?>">

      <?php
      if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>copias/bajaLogica/<?php print $datos['data']['id'].'/'.$datos['pag']; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA.'copias/'.$datos['pag'];?>" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información</b></p>
      <?php } else { ?> 
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA.'copias/'.$datos['pag']; ?>" class="btn btn-success">Regresar</a>
    <?php } ?> 
    </div>
  </form>
<?php include_once("piepagina.php"); ?>