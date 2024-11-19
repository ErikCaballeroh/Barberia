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

    <!-- DatePicker -->
    <link rel="stylesheet" href="/barberia/pickadate/default.css">
    <link rel="stylesheet" href="/barberia/pickadate/default.date.css">
    <link rel="stylesheet" href="/barberia/pickadate/default.time.css">
</head>

<body>
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
                            <a class="nav-link text-white" href="/barberia/pages/about/about.php">Sobre Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/barberia/pages/services/services.php">Servicios</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link text-white" href="/barberia/pages/contact/contact.php">Contáctanos</a>
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
                                    <img src="/barberia/IMG/icono.png" alt="User Icon" class="rounded-circle" style="width: 30px; height: 30px;">
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 2): ?>
                                        <li><a class="dropdown-item" href="/barberia/pages/sign-in/schedule/agendar.php">Agendar cita</a></li>
                                    <?php endif; ?>
                                    <!-- Verificación del rol -->
                                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                                        <li><a class="dropdown-item" href="/barberia/pages/dashboard/dashboard.php">Dashboard</a></li>
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
            <div class="container my-3">
                <div class="row">
                    <!-- Citas Disponibles -->
                    <div class="col-12 col-lg-6 order-1 order-lg-1 px-4 py-3">
                        <h2 class="fs-4 fw-bold mb-3">Tus Citas</h2>
                        <div id="citas-container" class="row g-4">
                            <!-- Aquí se insertarán dinámicamente las citas como tarjetas -->
                        </div>
                    </div>

                    <!-- Formulario para Agendar Cita -->
                    <div class="col-12 col-lg-6 order-2 order-lg-2">
                        <form class="bg-white px-4 py-3" id="appointmentForm">
                            <h2 class="fs-4 fw-bold mb-3">Agendar cita</h2>
                            <div class="mb-3">
                                <label for="barber" class="form-label fst-italic">Sucursal</label>
                                <select name="barber" class="form-select py-2 border border-dark" id="select-sucursales">
                                    <option value="" default>Selecciona una sucursal</option>
                                </select>
                            </div>
                            <div class="mb-3" id="service-control">
                                <label for="service" class="form-label fst-italic">Servicio</label>
                                <select name="service" class="form-select py-2 border border-dark" id="select-service">
                                    <option value="" default>Selecciona un servicio</option>
                                </select>
                            </div>
                            <div class="mb-3" id="date-control">
                                <label for="appointment-date" class="form-label fst-italic">Fecha</label>
                                <input type="text" name="appointment-date" class="form-control py-2 border border-dark"
                                    placeholder="Selecciona una fecha" id="datepicker">
                            </div>
                            <div class="mb-3" id="time-control">
                                <label for="appointment-time" class="form-label fst-italic">Hora</label>
                                <input type="text" name="appointment-time" class="form-control py-2 border border-dark"
                                    placeholder="Selecciona una hora (Varia segun disponibilidad)" id="timepicker">
                            </div>
                            <div class="mt-4">
                                <input type="submit" value="Realizar cambios" class="btn btn-dark w-100 py-2 fw-bold">
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <!-- Citas Disponibles -->

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="/barberia/JS/jquery-3.7.1.min.js"></script>
    <script src="/barberia/JS/bootstrap.bundle.min.js"></script>
    <script src="/Barberia/pickadate/pickadate.js"></script>
    <script src="/Barberia/js/sweetalert2.all.min.js"></script>
    <script type="module" src="agendar.js"></script>
    <script type="module" src="look_citas.js"></script>


    <script>
        document.getElementById('logoutButton').addEventListener('click', function() {
            var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();
        });
    </script>
</body>

</html>