<?php
    session_start();
//conexion a la base de datos
    include'conexion.php';
//variable de registro
    $correo =  $_POST['correo'];
    $contrasena =  $_POST['contrasena'];
    

    //validar la contraseña
    $validar_login = mysqli_query($conexion, "SELECT * FROM users WHERE email='$correo' AND pasword = '$contrasena'");

//validar login
    if(mysqli_num_rows($validar_login) > 0){
        $_sesion['usuario'] = $correo;
        header( "location: /barberia/index.html" );

    }else{
        echo' 
            <script>alert("Usuario no existe, Verifica los datos");
            wind.location = "/barberia/index.php";
            </script>';
            exit;
    }

