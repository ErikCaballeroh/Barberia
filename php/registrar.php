<?php
//conexion a la base de datos
    include'conexion.php';
//variable de registro
    $user =  $_POST['user'];
    $correo =  $_POST['correo'];
    $contrasena =  $_POST['contrasena']; 
    $contrasena2 = $_POST['confirmarcontrasena'];
    $id_role = 2;


//verificar el correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("El correo electrónico no es válido");</script>';
        exit;
    }

//verificar que no se repita el correo
$verificar_correo = mysqli_query($conexion, "SELECT * FROM users WHERE email='$correo' ");

if (mysqli_num_rows($verificar_correo) > 0) {
    echo '
        <script> alert("Este correo ya esta registrado, intenta con otro diferente");
        window.location = "../pages/sign-in/sign-in.php";
        </script>';
    
        exit;
}
//verificar que no se repita el usuario
$verificar_usuario = mysqli_query($conexion, "SELECT * FROM users WHERE username='$user' ");

if (mysqli_num_rows($verificar_usuario) > 0) {
    echo '
        <script> alert("Este usuario ya esta registrado, intenta con otro diferente");
        window.location = "../pages/sign-in/sign-in.php";
        </script>';
    
        exit;
}

//validar que la contraseña es lo mismo
    if($contrasena == $contrasena2){

        $contrasena_cifrada = password_hash($contrasena, PASSWORD_BCRYPT);//hash de la contrasena

    // insertar los datos en la base de datos
    $query = "INSERT INTO users(id_role,username, email, password)
            values('$id_role','$user', '$correo', '$contrasena_cifrada')";

$ejecutar = mysqli_query($conexion, $query);
exit;
//validar que se registro
if ($ejecutar) {

    echo' <script>alert("usuario alamacenado exitosamente");
   window.location = "barberia/pages/sign-in/sign-in.php";
    </script>';
} else {
    echo "Error al registrar el usuario: " . mysqli_error($conexion);
}
}else{
    echo'<script>alert("Contraseña no coincide");</script>';
    exit;
}
    // Cerrar conexión
    mysqli_close($conexion);
?>
