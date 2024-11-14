<?php
session_start();
//conexion a la base de datos
include 'conexion.php';

//variable de registro con validacion para evitar ataques
$correo = mysqli_real_escape_string($conexion, $_POST['correo']);
$contra = $_POST['contra'];


//comparar las variables
$validar_login = mysqli_query($conexion, "SELECT * FROM users WHERE email='$correo' ");

//validar login
if (mysqli_num_rows($validar_login) > 0) {
    $_SESSION['usuario'] = $correo;
    $usuario = mysqli_fetch_assoc($validar_login);

    // Verificar la contraseña ingresada con el hash de la base de datos
    if (password_verify($contra, $usuario['password'])) {
        $_SESSION['usuario'] = $correo;
        $_SESSION['username'] = $usuario['username'];
        $_SESSION['role'] = $usuario['id_role'];
        header("Location: /barberia/index.php");
        exit;
    } else {
        // Contraseña incorrecta
        echo '
                <script>
                    alert("Contraseña incorrecta, verifica los datos.");
                    window.location = "/barberia/index.php";
                </script>';
        exit;
    }
} else {
    // Usuario no encontrado
    echo ' 
            <script>alert("Usuario no existe, Verifica los datos");
            window.location = "/barberia/index.php";
            </script>';
    exit;
}
