<?php
session_start(); // Iniciar la sesión para acceder a las variables de sesión
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contactanos</title>
  <link rel="stylesheet" href="/barberia/CSS/bootstrap.min.css">
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
    <div class="row align-items-center">
      <!-- Sección de Contacto -->
      <div class="col-md-6">
        <h2 class="mb-4">Contáctanos</h2>
        <!-- Acordeón de Preguntas -->
        <div class="accordion mb-4" id="faqAccordion">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                aria-expanded="true" aria-controls="collapseOne">
                ¿Aceptan tarjeta?
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
              data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Sí, aceptamos tarjetas de crédito y débito.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                ¿Necesito hacer una cita previa o aceptan clientes sin cita?
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
              data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Aceptamos clientes sin cita, pero recomendamos hacer una cita para evitar esperas.
              </div>
            </div>
          </div>
        </div>
        <!-- Botón de WhatsApp -->
        <a id="whatsappButton" class="btn btn-success d-flex align-items-center" target="_blank">
          <img src="/barberia/IMG/WhatsApp_icon.png" alt="WhatsApp" style="width: 20px; margin-right: 8px;">
          WhatsApp
        </a>
      </div>
      <!-- Imagen -->
      <div class="col-md-6 text-center">
        <img src="/barberia/IMG/barb_cont.jpg" alt="Barbería" class="img-fluid rounded">
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
  <script src="contact.js"></script>
  <script>
    document.getElementById('logoutButton').addEventListener('click', function() {
      var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
      logoutModal.show();
    });
  </script>
</body>

</html>