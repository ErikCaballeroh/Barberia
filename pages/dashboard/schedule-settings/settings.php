<?php
// get_users.php

// Iniciar sesión para acceder a las variables de sesión
session_start();

// Verificar si el usuario tiene el rol adecuado (rol 1 = administrador)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
  // Si no es administrador, redirigir a la página de inicio
  header('Location: /barberia/index.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Horario</title>
  <link rel="stylesheet" href="/barberia/css/bootstrap.min.css">
  <link rel="stylesheet" href="/barberia/css/Compartido.css">
  <link rel="stylesheet" href="/barberia/css/Inicio.css">
  <link rel="stylesheet" href="/barberia/css/datatables.min.css">
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
                        <li class="nav-item text-white">
                            <a class="nav-link" href="/barberia/pages/services/services.php">Servicios</a>
                        </li>
                        <li class="nav-item text-white">
                            <a class="nav-link" href="/barberia/pages/contact/contact.php">Contáctanos</a>
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

  <main class="container py-5">
    <h2 class="fa-1 fw-bold mb-3">
      Establecer horario
    </h2>
    <form class="form row gap-5" id="form-settings">
      <section class="col-4 d-flex flex-column">
        <div class="mb-3 row">
          <label for="opening-time" class="form-label fst-italic">Hora de apertura</label>
          <select name="opening-time" class="form-select py-2 border border-dark" id="opening-time">
            <option value="" default>Selecciona una hora</option>
          </select>
        </div>

        <div class="mb-3 row">
          <label for="closing-time" class="form-label fst-italic">Hora de cierre</label>
          <select name="closing-time" class="form-select py-2 border border-dark" id="closing-time">
            <option value="" default>Selecciona una hora</option>
          </select>
        </div>

        <div class="mb-3 row">
          <label for="max-clients" class="form-label fst-italic">Clientes por hora</label>
          <input type="number" name="max-clients" class="form-control py-2 border border-dark"
            placeholder='Numero de horas ej. "3"' id="max-clients">
        </div>

        <div class="row mt-auto">
          <input type="submit" value="Realizar cambios" class="btn btn-dark w-100 py-2 fw-bold">
        </div>
      </section>

      <section class="col-6 ps-4">
        <label for="time" class="form-label fst-italic mb-3">Dias de servicio</label>

        <div class="mb-3 form-check">
          <input type="checkbox" name="domingo" class="form-check-input p-2 border border-dark">
          <label class="form-check-label ms-3" for="domingo">
            Domingo
          </label>
        </div>

        <div class="mb-3 form-check">
          <input type="checkbox" name="lunes" class="form-check-input p-2 border border-dark">
          <label class="form-check-label ms-3" for="lunes">
            Lunes
          </label>
        </div>

        <div class="mb-3 form-check">
          <input type="checkbox" name="martes" class="form-check-input p-2 border border-dark">
          <label class="form-check-label ms-3" for="martes">
            Martes
          </label>
        </div>

        <div class="mb-3 form-check">
          <input type="checkbox" name="miercoles" class="form-check-input p-2 border border-dark">
          <label class="form-check-label ms-3" for="miercoles">
            Miercoles
          </label>
        </div>

        <div class="mb-3 form-check">
          <input type="checkbox" name="jueves" class="form-check-input p-2 border border-dark">
          <label class="form-check-label ms-3" for="jueves">
            Jueves
          </label>
        </div>

        <div class="mb-3 form-check">
          <input type="checkbox" name="viernes" class="form-check-input p-2 border border-dark">
          <label class="form-check-label ms-3" for="viernes">
            Viernes
          </label>
        </div>

        <div class="mb-3 form-check">
          <input type="checkbox" name="sabado" class="form-check-input p-2 border border-dark">
          <label class="form-check-label ms-3" for="sabado">
            Sabado
          </label>
        </div>
      </section>
    </form>
  </main>
  <script src="/barberia/js/bootstrap.bundle.min.js"></script>
  <script src="/barberia/js/jquery-3.7.1.min.js"></script>
  <script src="/Barberia/JS/sweetalert2.all.min.js"></script>
  <script src="settings_handler.js"></script>
  <script>
        document.getElementById('logoutButton').addEventListener('click', function() {
            var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();
        });
    </script>
</body>

</html>