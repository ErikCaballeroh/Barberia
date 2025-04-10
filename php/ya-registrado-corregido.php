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
    <title>Registro</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <form action="../../includes/registrar_usuario.php" method="POST">
        <h2>Registro</h2>
        <label for="nombre">Nombre completo:</label>
        <input type="text" name="nombre" required>
        
        <label for="correo">Correo:</label>
        <input type="email" name="correo" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>

        <button type="submit">Registrarse</button>

        <p>¿Ya tienes cuenta? <a href="../login/sign-in-corregido.php">Inicia sesión</a></p>
    </form>
</body>
</html>
