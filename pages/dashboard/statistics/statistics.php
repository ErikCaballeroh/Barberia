<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadisticas</title>
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
                    <img src="/barberia/IMG/LOGO.png" alt="Logo" height="40" width="100"
                        class="d-inline-block align-top col-6">
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
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i>
                                <?php echo $_SESSION['username']; ?>
                                <img src="3" alt="Logo" class="d-inline-block align-top col-6">
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/barberia/pages/sign-in/schedule/agendar.php">Agendar
                                        cita</a></li>
                                <!-- Verificación del rol -->
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                                <li><a class="dropdown-item"
                                        href="/barberia/pages/dashboard/dashboard.html">Dashboard</a></li>
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

        <section class="nav nav-tabs" id="chart-tabs">
            <li class="nav-item">
                <button class="nav-link active text-dark" id="most-saled-tab" data-bs-toggle="tab"
                    data-bs-target="#most-saled" type="button" role="tab" aria-controls="most-saled"
                    aria-selected="true">Más vendidos</button>
            </li>
            <li class="nav-item">
                <button class="nav-link text-dark" id="appointments-tab" data-bs-toggle="tab"
                    data-bs-target="#appointments" type="button" role="tab" aria-controls="appointments"
                    aria-selected="false">Dias mas concurridos</button>
            </li>
        </section>

        <section class="tab-content" id="myTabContent">
            <article class="tab-pane fade show active p-4" id="most-saled" role="tabpanel"
                aria-labelledby="most-saled-tab">
                <div id="sales-chart" style="width: 1000px; height:500px;">

                </div>
            </article>
            <article class="tab-pane fade p-4" id="appointments" role="tabpanel" aria-labelledby="appointments-tab">
                <div id="appointments-chart" style="width: 1000px; height:500px;">

                </div>
            </article>
        </section>


    </main>

    <script src="/barberia/js/bootstrap.bundle.min.js"></script>
    <script src="/barberia/js/jquery-3.7.1.min.js"></script>
    <script src="/barberia/js/echarts.min.js"></script>
    <script src="/barberia/JS/sweetalert2.all.min.js"></script>
    <script src="sales-chart.js"></script>
    <script src="appointments-chart.js"></script>
</body>

</html>