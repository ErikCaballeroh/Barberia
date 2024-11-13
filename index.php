<?php
session_start(); // Iniciar la sesión para acceder a las variables de sesión
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="/barberia/css/bootstrap.min.css">
    <link rel="stylesheet" href="/barberia/css/Compartido.css">
    <link rel="stylesheet" href="/barberia/css/Inicio.css">
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
                            <a class="nav-link" href="/barberia/pages/about/about.html">Sobre Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/barberia/pages/services/services.html">Servicios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/barberia/pages/contact/contact.html">Contáctanos</a>
                        </li>
                        <?php
                        //Si el usuario no está logueado, mostrar los botones de Sign In y Sign Up //
                        if(!isset($_SESSION["usuario"])): ?>
                                    <li class="nav-item">
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
                                    <img src="3" alt="Logo"  class="d-inline-block align-top col-6">
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/barberia/pages/sign-in/schedule/agendar.php">Agendar cita</a></li>
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

    <main>

        <!--Carrusel-->
        <div id="carouselExampleDark" class="carousel carousel-dark slide bg-dark bg-opacity-75">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="10000">
                    <img src="/barberia/IMG/carrusel.png" class="d-block w-100" alt="..."
                        style="height: 600px; object-fit: cover;">
                    <div
                        class="carousel-caption d-flex align-items-center justify-content-center bg-light bg-opacity-50">
                        <div>
                            <h1 class="text-dark">Rivera Barber Shop</h1>
                            <p class="text-dark">Regístrate para poder agendar citas, así como elegir el corte que
                                deseas y
                                poder conocer a nuestros barberos certificados.</p>
                        </div>
                    </div>
                </div>

                <div class="carousel-item" data-bs-interval="2000">
                    <img src="/barberia/IMG/carrusel-2.png" class="d-block w-100" alt="..."
                        style="height: 600px; object-fit: cover;">
                </div>

                <div class="carousel-item">
                    <img src="/barberia/IMG/carrusel-3.png" class="d-block w-100" alt="..."
                        style="height: 600px; object-fit: cover;">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>


        <!--Trabajos-->
        <div class="work-section text-center">
            <div>
                <h2>Nuestros trabajos</h2>
            </div>
            <div class="d-flex justify-content-center">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-2 mb-3">
                        <img src="/barberia/IMG/trabajos-1.png" class="img-thumbnail" alt="Trabajo 1">
                    </div>
                    <div class="col-12 col-md-2 mb-3">
                        <img src="/barberia/IMG/trabajos-2.png" class="img-thumbnail" alt="Trabajo 2">
                    </div>
                    <div class="col-12 col-md-2 mb-3">
                        <img src="/barberia/IMG/trabajos-3.png" class="img-thumbnail" alt="Trabajo 3">
                    </div>
                    <div class="col-12 col-md-2 mb-3">
                        <img src="/barberia/IMG/trabajos-4.png" class="img-thumbnail" alt="Trabajo 4">
                    </div>
                    <div class="col-12 col-md-2 mb-3">
                        <img src="/barberia/IMG/trabajos-5.png" class="img-thumbnail" alt="Trabajo 5">
                    </div>
                </div>
            </div>
    </main>
    <!--Pie de pagina-->
    <footer class="footer bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <h4 class="footer-title">Redes de Rivera Barber Shop</h4>
            <div class="social-links mb-3">
                <a href="https://instagram.com" target="_blank">Instagram</a> |
                <a href="https://facebook.com" target="_blank">Facebook</a> |
                <a href="https://maps.google.com" target="_blank">Google Maps</a>
            </div>
            <p class="mb-0">© 2024 Rivera Barber Shop</p>
        </div>
    </footer>
    <script src="/barberia/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.getElementById('logoutButton').addEventListener('click', function() {
    var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
    logoutModal.show();
    });
    </script>
</body>
</html>