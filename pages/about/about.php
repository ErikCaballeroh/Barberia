<?php
session_start(); // Iniciar la sesión para acceder a las variables de sesión
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sobre Nosostros</title>
  <link rel="stylesheet" href="/barberia/CSS/bootstrap.min.css">
  <link rel="stylesheet" href="/barberia/CSS/sobrenosotros.css">
  <link rel="stylesheet" href="/barberia/CSS/Compartido.css">
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
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                    <?php echo $_SESSION['username']; ?>
                    <img src="/barberia/IMG/icono.png" alt="User Icon" class="rounded-circle"
                      style="width: 30px; height: 30px;">
                  </a>
                  <ul class="dropdown-menu">
                  <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 2): ?>
                      <!-- Solo se muestra Agendar cita si el rol es 2 -->
                      <li><a class="dropdown-item" href="/barberia/pages/sign-in/schedule/agendar.php">Agendar cita</a></li>
                  <?php else: ?>
                      <!-- Si el rol no es 2 (puede ser 1 u otro número), muestra Dashboard -->
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

  <div class="container py-5">
    <!-- Sección Sobre Nosotros -->
    <div class="row mb-5">
      <div class="col-md-6 text-center">
        <h2 class="fw-bold">Sobre Nosotros</h2>
        <p class="text-muted">Barberia Rivera Shop</p>
        <p>En Barberia Rivera Shop tenemos como finalidad crear una experiencia total para nuestros usuarios contamos
          con excelentes instalaciones, equipo de calidad y personal capacitado.</p>
        <p>Tenemos la filosofía es siempre superar las expectativas de nuestros clientes para crear un diferenciador
          permanente con nuestros competidores. Nuestra mejor recompensa es lograr que nuestros clientes se sientan como
          en casa, con un servicio de calidad y nos recomienden.</p>
      </div>
      <div class="col-md-6 text-center">
        <img src="/barberia/IMG/sobrenosotros1.jpg" alt="Barberia" class="about-image">
      </div>
    </div>
    <!-- Sección Sucursales -->
    <div class="row">
      <div class="col-12 text-center mb-4">
        <h2 class="fw-bold">Sucursales</h2>
      </div>
      <div class="col-md-6 text-center">
        <!-- Ícono y Nombre de la Sucursal -->
        <div class="icon-text mb-2">
          <img src="/barberia/IMG/ubicacion.png" alt="Ubicación">
          <span>San Pedro</span>
        </div>
        <!-- Botón de Ubicación -->
        <a id="googleMapsLink" href="#" target="_blank" class="btn btn-dark mb-3 googleMapsLink googleMapsLink">Ubicación</a>
        <p>En Barberia Rivera Shop no hacemos ninguna distinción ¡Todos son bienvenidos!</p>
        <p>¡Los esperamos!</p>
      </div>
      <div class="col-md-6 text-center">
        <img src="/barberia/IMG/sobrenosotros2.jpg" alt="Barberia" class="branch-image">
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
        <a id="googleMapsLink" class="googleMapsLink" href="#" target="_blank">Google Maps</a>
      </div>
      <p class="mb-0">© 2024 Rivera Barber Shop</p>
    </div>
  </footer>
  <script src="/barberia/JS/bootstrap.bundle.min.js"></script>
  <script src="/barberia/js/location.js"></script>
  <script>
        document.getElementById('logoutButton').addEventListener('click', function() {
            var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();
        });
    </script>
</body>

</html>