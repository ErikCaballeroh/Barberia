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
  <title>Servicios</title>
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

  <main class="container py-5">
    <button type="button" class="btn btn-success" id="addServiceBtn" data-bs-toggle="modal" data-bs-target="#addServiceModal">
    Agregar Servicio
    </button>
    
    <button type="button" class="btn btn-warning" id="addCategoryBtn" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
      Agregar Categoría
    </button>
    <table id="myTable" class="table">
      <thead>
        <tr>
          <th>Servicio</th>
          <th>Descripcion</th>
          <th>Precio</th>
          <th>Categoria</th>
          <th>Acciones</th>
        </tr>
      </thead>
    </table>

    <div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">Agregar Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addServiceForm">
                    <div class="mb-3">
                        <label for="serviceName">Nombre del Servicio</label>
                        <input type="text" class="form-control" id="serviceName" name="serviceName" required>
                    </div>
                    <div class="mb-3">
                        <label for="serviceDescription">Descripción</label>
                        <input type="text" class="form-control" id="serviceDescription" name="serviceDescription" required>
                    </div>
                    <div class="mb-3">
                        <label for="servicePrice">Precio</label>
                        <input type="number" class="form-control" id="servicePrice" name="servicePrice" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="serviceCategory" class="form-label">Categoría</label>
                        <select class="form-control" id="serviceCategory" name="serviceCategory" required>
                            <!-- Las categorías se cargarán dinámicamente aquí -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="saveService">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal para agregar categoría -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Agregar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Nombre de la Categoría</label>
                        <input type="text" class="form-control" id="categoryName" name="categoryName" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="saveCategory">Guardar Categoría</button>
            </div>
        </div>
    </div>
</div>

<!---editar -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editServiceModalLabel">Editar Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editServiceForm">
                    <input type="hidden" id="editServiceId" name="serviceId">
                    <div class="mb-3">
                        <label for="editServiceName">Nombre del Servicio</label>
                        <input type="text" class="form-control" id="editServiceName" name="serviceName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editServiceDescription">Descripción</label>
                        <input type="text" class="form-control" id="editServiceDescription" name="serviceDescription" required>
                    </div>
                    <div class="mb-3">
                        <label for="editServicePrice">Precio</label>
                        <input type="number" class="form-control" id="editServicePrice" name="servicePrice" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="editServiceCategory" class="form-label">Categoría</label>
                        <select class="form-control" id="editServiceCategory" name="serviceCategory" required>
                            <!-- Las categorías se cargarán dinámicamente aquí -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="updateService">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>


  </main>
  <script src="/barberia/js/jquery-3.7.1.min.js"></script>
  <script src="/barberia/js/bootstrap.bundle.min.js"></script>
  <script src="/barberia/js/datatables.min.js"></script>
  <script src="services_table.js"></script>
  <script>
        document.getElementById('logoutButton').addEventListener('click', function() {
            var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();
        });
    </script>
</body>

</html>