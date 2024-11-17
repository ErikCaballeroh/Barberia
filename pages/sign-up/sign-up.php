    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sing UP</title>
        <link href="/barberia/CSS/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <main>
            <div class="container d-flex justify-content-center align-items-center vh-100">
                <div class="row align-items-center">
                    <div class="col-md-6 d-flex justify-content-center">
                        <img src="/barberia/IMG/sign-up.png" alt="Sign Up" class="img-fluid rounded">
                    </div>
                    <div class="col-md-6">
                        <div class="logo text-center mb-4">
                        <a href="/barberia/index.php">
                            <img src="/barberia/IMG/LOGO.png" alt="Logo" class="img-fluid" style="max-width: 150px;">
                        </a>
                        </div>
                        <form action="/barberia/php/registrar.php" method="POST">
                            <fieldset>
                                <legend class="text-center mb-4">Sign UP</legend>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Usuario:</label>
                                    <input type="text" class="form-control" id="username" placeholder="Usuario" name="user" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo Electrónico:</label>
                                    <input type="email" class="form-control" id="email" placeholder="Correo Electrónico" name="correo" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña:</label>
                                    <input type="password" class="form-control" id="password" placeholder="Contraseña" name="contrasena" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm-password" class="form-label">Confirmar Contraseña:</label>
                                    <input type="password" class="form-control" id="confirm-password" placeholder="Confirmar Contraseña" name="confirmarcontrasena" required>
                                    <small id="passwordHelp" class="form-text text-muted">
                                        Entre 8-20 caracteres de longitud.
                                    </small>
                                </div>
                                <button type="submit" class="btn btn-dark w-100">Sign UP</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <script src="/barberia/JS/bootstrap.bundle.min.js"></script>
    </body>
    </html>
