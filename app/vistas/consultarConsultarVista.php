<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>consultar/consulta/" method="POST">

    <div class="form-group text-left">
      <label for="nombre">Nombre del autor:</label>
      <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Escribe el nombre del autor." >
    </div>

    <div class="form-group text-left">
      <label for="apellidoPaterno">Apellido paterno del autor:</label>
      <input type="text" name="apellidoPaterno" id="apellidoPaterno" class="form-control" placeholder="Escribe el apellido paterno del autor." >
    </div>

    <div class="form-group text-left">
      <label for="apellidoMaterno">Apellido materno del autor:</label>
      <input type="text" name="apellidoMaterno" id="apellidoMaterno" class="form-control" placeholder="Escribe el apellido materno  del autor." >
    </div>

    <div class="form-group text-left">
      <label for="titulo">Título:</label>
      <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Escribe el título del libro.">
    </div>

    <div class="form-group text-left">
      <label for="idTema">Tema:</label>
      <select class="form-control" name="idTema" id="idTema">
      <option value="void">---Selecciona un tema---</option>
        <?php
          for ($i=0; $i < count($datos["temas"]); $i++) { 
            print "<option value='".$datos["temas"][$i]["id"]."'>".$datos["temas"][$i]["tema"]."</option>";
          } 
        ?>
      </select>
    </div>
    <ul>
      <li>El símbolo de porcentaje (%) se usa para coincidir con cualquier cadena de cero o más caracteres.</li>
      <li>El guion bajo (_) se usa para coincidir con un carácter exacto.</li>
    </ul>

    <div class="form-group text-left">
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; }?>">
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA; ?>consultar" class="btn btn-info">Regresar</a>
    </div>
  </form>
<?php include_once("piepagina.php"); ?>