<?php
// Iniciar sesión para acceder a las variables de sesión
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Servicios</title>
  <link rel="stylesheet" href="/barberia/CSS/bootstrap.min.css">
  <link rel="stylesheet" href="/barberia/CSS/servicios.css">
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

  <div class="container py-5">
    <h1 class="mb-5">Servicios</h1>
    <!-- Imagen principal -->
    <div class="text-center mb-4">
      <img src="/barberia/IMG/servicios.jpeg" alt="Barbería" class="img-fluid">
    </div>
    <div class="row gy-5">
      <!-- Servicios Individuales -->
      <div class="col-md-6">
        <h3>Servicios Individuales</h3>
            <ul id="serviciosIndividualesList" class="service-list list-unstyled"></ul>
          
        <!-- Servicios Adicionales -->
        <h3>Servicios Adicionales</h3>
        <ul id="serviciosAdicionalesList" class="service-list list-unstyled"></ul>

        <div class="footer-image mt-3">
          <img src="/barberia/IMG/muestra1.jpg" alt="Barbería" class="img-fluid">
        </div>
      </div>
      <!-- Paquetes -->
      <div class="col-md-6">
        <h3>Paquetes</h3>
        <ul id="paquetesList" class="service-list list-unstyled" ></ul>
        
        <div class="footer-image mt-3">
          <img src="/barberia/IMG/muestra2.jpg" alt="Barbería" class="img-fluid">
        </div>  
      </div>
    </div>
  </div>
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
  <script src="servicios.js"></script>
  <script src="/barberia/JS/bootstrap.bundle.min.js"></script>
  
</body>
</html>