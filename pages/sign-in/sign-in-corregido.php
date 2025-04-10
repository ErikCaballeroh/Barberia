<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: /barberia/pages/dashboard/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <form action="../../includes/validar_login.php" method="POST">
        <h2>Iniciar Sesión</h2>
        <label for="correo">Correo:</label>
        <input type="email" name="correo" required>
        
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>

        <button type="submit">Ingresar</button>

        <p>¿No tienes cuenta? <a href="../register/ya-registrado-corregido.php">Regístrate aquí</a></p>
    </form>

    <?php
    if (isset($_GET['error']) && $_GET['error'] == '1') {
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Correo o contraseña incorrectos. Intenta de nuevo.',
                confirmButtonColor: '#d33'
            });
        </script>";
    }
    ?>
</body>
</html>
