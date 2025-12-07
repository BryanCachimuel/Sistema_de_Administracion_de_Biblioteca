<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>editoriales/alta/" method="POST">

    <div class="form-group text-left">
      <label for="editorial">* Nombre de la editorial:</label>
      <input type="text" name="editorial" id="editorial" class="form-control" required value="<?php print isset($datos['data']['editorial'])?$datos['data']['editorial']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="pagina">Página web:</label>
      <input type="text" name="pagina" id="pagina" class="form-control" value="<?php print isset($datos['data']['pagina'])?$datos['data']['pagina']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?> placeholder="www.paginaweb.com">
    </div>

    <div class="form-group text-left">
      <label for="idPais">* País:</label>
      <select class="form-control" name="idPais" id="idPais" 
      <?php
      if (isset($datos["baja"])) {
        print " disabled ";
      }
      ?>
      >
      <option value="void">---Selecciona un país---</option>
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
        <a href="<?php print RUTA; ?>editoriales/bajaLogica/<?php print $datos['data']['id'].'/'.$datos['pag']; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA.'editoriales/'.$datos['pag'];?>" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información</b></p>
      <?php } else { ?> 
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA.'editoriales/'.$datos['pag']; ?>" class="btn btn-success">Regresar</a>
    <?php } ?> 

    </div>
  </form>
<?php include_once("piepagina.php"); ?>