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
  <title>Configuracion de contacto</title>
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
                            <a class="nav-link text-white" href="/pages/about/about.html">Sobre Nosotros</a>
                        </li>
                        <li class="nav-item text-white">
                            <a class="nav-link" href="/barberia/pages/services/services.php">Servicios</a>
                        </li>
                        <li class="nav-item text-white">
                            <a class="nav-link" href="/pages/contact/contact.html">Contáctanos</a>
                        </li>
                        <?php
                        //Si el usuario no está logueado, mostrar los botones de Sign In y Sign Up 
                        if (!isset($_SESSION["usuario"])): ?>
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
                                    <img src="3" alt="Logo" class="d-inline-block align-top col-6">
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
  </header>

  <main class="container py-5">
    <h2 class="fa-1 fw-bold mb-3">
      Establecer horario
    </h2>
    <form class="form row gap-5" action="/barberia/pages/dashboard/contact-settings/get_number_link.php" method="POST">
      <section class="col-4 d-flex flex-column">
            <div class="mb-3 row">
              <label for="branch" class="form-label fst-italic">Selecciona la Sucursal</label>
              <select name="branch" id="branch" class="form-control py-2 border border-dark" required>
                <?php
                include '../conecction.php'; // Asegúrate de que esta ruta sea correcta

                // Consulta para cargar las sucursales
                $sql = "SELECT id_barber, service_number FROM barbers";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Mostrar las sucursales como opciones en el select
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id_barber'] . '">' . $row['service_number'] . '</option>';
                    }
                } else {
                    echo '<option value="">No hay sucursales disponibles</option>';
                }

                $conn->close();
                ?>
            </select>

          <div class="mb-3 row">
              <label for="whatsapp" class="form-label fst-italic">Número de WhatsApp</label>
              <input type="text" name="whatsapp" class="form-control py-2 border border-dark"
                    placeholder="Ejemplo. 8164958564" required>
          </div>

          <div class="mb-3 row">
              <label for="maps" class="form-label fst-italic">Enlace de Google Maps</label>
              <input type="text" name="maps" class="form-control py-2 border border-dark"
                    placeholder="https://maps.app.goo.gl/Hfp4Q6Angsz9X9aa9" required>
          </div>


        <div class="row mt-4">
          <input type="submit" value="Realizar cambios" class="btn btn-dark w-100 py-2 fw-bold">
        </div>
      </section>
    </form>
  </main>
  <script src="/barberia/js/bootstrap.bundle.min.js"></script>
  <script src="/barberia/js/jquery-3.7.1.min.js"></script>

  <script>
        document.getElementById('logoutButton').addEventListener('click', function() {
            var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();
        });

    </script>
</body>

</html>