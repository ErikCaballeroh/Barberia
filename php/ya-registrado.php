<?php
//conexion a la base de datos
    include'conexion.php';
//variable de registro
    $correo =  $_POST['correo'];
    $contrasena =  $_POST['contrasena'];

    $validar_login = mysqli_query($conexion, "SELECT * FROM users WHERE email='$correo' AND pasword = '$contrasena'");

    if(mysqli_num_rows($validar_login) > 0){
        header( "location: ../../index.html" ) ;
    }else{
        echo' 
            <script>alert("Usuario no existe, Verifica los datos");
            wind.location = "../pages/sign-in/sign-in.php";
            </script>';
            exit;
    }

