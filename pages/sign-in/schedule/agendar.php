<?php
session_start(); // Iniciar la sesión para acceder a las variables de sesión
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas</title>
    <link rel="stylesheet" href="/barberia/CSS/bootstrap.min.css">
    <link rel="stylesheet" href="/barberia/CSS/Compartido.css">
</head>
<body>

<header>
<header>
        <!--Barra de navegacion-->
        <nav class="navbar navbar-expand-lg navbar-dark  py-3 $black">
            <div class="container">
                <a class="navbar-brand" href="/barberia/index.php">
                    <img src="/barberia/IMG/LOGO.png" alt="Logo" height="40" width="100" class="d-inline-block align-top col-6">
                    <span class="d-flex align-items-center col-6">
                        Rivera Barber Shop
                    </span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto gap-3">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/barberia/pages/about/about.html">Sobre Nosotros</a>
                        </li>
                        <li class="nav-item text-white">
                            <a class="nav-link" href="/barberia/pages/services/services.php">Servicios</a>
                        </li>
                        <li class="nav-item text-white">
                            <a class="nav-link" href="/barberia/pages/contact/contact.html">Contáctanos</a>
                        </li>
                        <?php
                        //Si el usuario no está logueado, mostrar los botones de Sign In y Sign Up 
                        if (!isset($_SESSION["usuario"])): ?>
                            <li class="nav-item text-white">
                                <a class="btn btn-outline-light mx-1" href="/barberia/pages/sign-up/sign-up.php">Sign Up</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-light mx-1" href="/barberia/pages/sign-in/sign-in.php">Sign In</a>
                            </li>

                            <!--si existe-->
                        <?php else: ?>
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i> <?php echo $_SESSION['username']; ?>
                                    <img src="3" alt="Logo" class="d-inline-block align-top col-6">
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/barberia/pages/sign-in/schedule/agendar.php">Agendar cita</a></li>
                                    <!-- Verificación del rol -->
                                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                                        <li><a class="dropdown-item" href="/barberia/pages/dashboard/dashboard.html">Dashboard</a></li>
                                    <?php endif; ?>

                                    <li><a id="logoutButton" class="dropdown-item" href="#">cerrar sesion</a></li>

                                </ul>
                            </div>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- Modal de Confirmación de Cerrar sesión -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirmación de Cerrar Sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas cerrar sesión?
                </div>
                <div class="modal-footer">
                    <!-- Botón Cancelar para cerrar el modal -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                    <!-- Enlace para cerrar sesión que llevará al archivo logout.php -->
                    <a href="/barberia/php/logout.php" class="btn btn-danger">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>


    <div class="d-flex flex-column min-vh-100">
        <main class="flex-grow-1">
            <div class="container my-5">
                <div class="row justify-content-between g-4">
                    <!-- Citas Disponibles -->
                    <div class="col-12 col-md-6">
                        <h1>Citas Disponibles</h1>
                        <p id="mensajeSinCita" class="d-none">Citas no disponibles</p>
                        <div id="cuadroCita" class="card d-none mb-4 p-3 shadow-sm">
                            <h2>Detalles de tu Cita</h2>
                            <p><strong>Fecha:</strong> <span id="fecha"></span></p>
                            <p><strong>Hora:</strong> <span id="hora"></span></p>
                            <p><strong>Sucursal:</strong> <span id="sucursal"></span></p>
                            <button class="btn btn-danger">Cancelar Cita</button>
                        </div>
                    </div>
    
                    <!-- Formulario para Agendar Cita -->
                    <div class="col-12 col-md-6">
                    <form class="bg-white p-4 rounded shadow-sm" id="agendarCitaForm">
                    <fieldset>
                        <legend class="text-center"><h1>Agendar tu cita</h1></legend>
                        <div class="mb-3">
                            <label for="sucursal" class="form-label">Sucursal:</label>
                            <select class="form-select" id="sucursal" name="sucursal" required>
                                <option value="">Seleccione una sucursal</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha:</label>
                            <input type="date" id="fecha" name="fecha" required><br>
                        </div>
                        <div class="mb-3">
                            <label for="servicio" class="form-label">Servicio:</label>
                            <select class="form-select" id="servicio" name="servicio" required>
                                <option value="">Seleccione un servicio</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="hora" class="form-label">Hora:</label>
                            <select class="form-select" id="hora" name="hora" required>
                                <option value="">Selecciona una hora</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Agendar</button>
                    </fieldset>
                </form>
                    </div>
                </div>
            </div>
        </main>
    
        <!-- Footer -->
        <footer class="footer bg-dark text-white text-center py-3 mt-auto">
            <div class="container">
                <h4 class="footer-title">Redes de Rivera Barber Shop</h4>
                <div class="mb-3">
                    <a href="https://instagram.com" target="_blank" class="text-white">Instagram</a> |
                    <a href="https://facebook.com" target="_blank" class="text-white">Facebook</a> |
                    <a href="https://maps.google.com" target="_blank" class="text-white">Google Maps</a>
                </div>
                <p class="mb-0">© 2024 Rivera Barber Shop</p>
            </div>
        </footer>
    </div>

    <script src="/barberia/JS/jquery-3.7.1.min.js"></script>
    <script src="/barberia/JS/bootstrap.bundle.min.js"></script>
    <script src="/barberia/JS/agendar.js"></script>


</body>
</html>