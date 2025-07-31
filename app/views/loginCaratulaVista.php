<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca | Entrada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</head>

<body>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a href="#" class="navbar-brand">Biblioteca</a>
    </nav>

    <div class="container-fluid">
        <div class="row content">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="card p-4 mt-3 bg-light">
                    
                    <form action="" method="POST">

                        <div class="form-group text-left">
                            <label for="usuario">* Usuario:</label>
                            <input type="text" class="form-control" name="usuario" placeholder="Escribe tu usuario (correo electrónico)">
                        </div>

                        <div class="form-group text-left">
                            <label for="clave">* Clave:</label>
                            <input type="password" class="form-control" name="clave" placeholder="Escribe tu clave de acceso">
                        </div>

                        <div class="form-group text-left mt-2">
							<input type="checkbox" name="recordar">
							<label for="recordar">Recordar</label>
						</div>

                        <div class="form-group text-left mt-2">
							<input type="submit" value="Iniciar Sesión" class="btn btn-success">
						</div>

						<a href="#">¿Olvidaste tu clave de acceso?</a><br>
						<a href="#">Registrarse</a>
                    </form>
                </div>
            </div>
            <div class="col-sm-1"></div>
        </div>
    </div>

</body>

</html>