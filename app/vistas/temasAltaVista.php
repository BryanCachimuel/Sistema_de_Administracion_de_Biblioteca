<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>temas/alta/" method="POST">

    <div class="form-group text-left mb-3">
      <label for="idCategoria">* <i class="fa-solid fa-list"></i> Categoría:</label>
      <select class="form-control" name="idCategoria" id="idCategoria" 
      <?php
      if (isset($datos["baja"])) {
        print " disabled ";
      }
      ?>
      >
      <option value="void">---Selecciona una categoría---</option>
        <?php
          for ($i=0; $i < count($datos["categorias"]); $i++) { 
            print "<option value='".$datos["categorias"][$i]["id"]."'";
              if(isset($datos["data"]["idCategoria"]) && $datos["data"]["idCategoria"]==$datos["categorias"][$i]["id"]){
                print " selected ";
              }
            print ">".$datos["categorias"][$i]["clave"].": ".$datos["categorias"][$i]["categoria"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-left mb-3">
      <label for="tema">* <i class="fa-solid fa-book-bookmark"></i> Nombre del tema:</label>
      <input type="text" name="tema" id="tema" class="form-control" required value="<?php print isset($datos['data']['tema'])?$datos['data']['tema']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">
      <input type="hidden" name="pag" id="id" value="<?php if (isset($datos['pag'])) { print $datos['pag']; } else { print "1"; } ?>">

      <?php
      if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>temas/bajaLogica/<?php print $datos['data']['id'].'/'.$datos['pag']; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA.'temas/'.$datos['pag'];?>" class="btn btn-danger">Regresar</a>
        <p class="mt-3"><b>Advertencia: una vez borrado el registro, no podrá recuperar la información</b></p>
      <?php } else { ?> 
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA.'temas/'.$datos['pag']; ?>" class="btn btn-success">Regresar</a>
    <?php } ?> 

    </div>
  </form>
<?php include_once("piepagina.php"); ?>