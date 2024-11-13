<?php
    $conexion = mysqli_connect("localhost", "root", "","db_barberia");

    if(!$conexion){
     // Si la conexión falla, mostramos el error
     echo 'La conexión falló: ' . mysqli_connect_error();
    } else {
        // Si la conexión es exitosa
        echo 'Conexión exitosa';
    }
    
?>