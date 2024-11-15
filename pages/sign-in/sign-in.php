<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sing IN in</title>
    <link href="/barberia/CSS/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <main>
        <div class="container d-flex justify-content-center align-items-center vh-100">
            <div class="row align-items-center">
                <div class="col-md-6 d-flex justify-content-center">
                    <img src="/barberia/IMG/sing-in.png" alt="Sign in" class="img-fluid rounded">
                </div>
                <!-- apartado de formulario -->
                <div class="col-md-6">
                    <div class="logo text-center mb-4">
                        <a href="/barberia/index.php">
                            <img src="../../IMG/LOGO.png" alt="Logo" class="img-fluid" style="max-width: 150px;">
                        </a>
                    </div>
                    <form form action="/barberia/php/ya-registrado.php" method="POST">
                        <fieldset>
                            <legend class="text-center mb-4">Sign IN</legend>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico:</label>
                                <input type="email" class="form-control" id="email" placeholder="Correo Electrónico" name="correo" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" id="password" placeholder="Contraseña" name="contra" required>
                                <div id="passwordHelp" class="form-text">
                                    Entre 8-20 caracteres de longitud.
                                    <button type="submit" class="btn btn-dark w-100">Sign in</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="/barberia/JS/bootstrap.bundle.min.js"></script>
</body>

</html>