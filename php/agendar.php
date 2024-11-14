<?php
//conexion a la base de datos
    include'conexion.php';

    //ejecutar la consulta para obetener las barberia
    function Sucursales($conexion){
    $sql = "SELECT id_barber, service_number FROM barbers";
    $result = mysql_query($conexion, $sql);

    $sucursales = []; 
    
    while ($row = mysqli_fetch_assoc($result)) {
        $sucursales[] = $row;
    } // Array para almacenar las sucursales

    echo json_encode($sucursales);

}
// Función para obtener los días disponibles
funcio dias($conexion, $barber_id){
    $sql = "SELECT service_days FROM barbers WHERE id_barber = ?";
    $sucu = mysqli_prepare($conexion, $sql);
    my_

}


    ?>   



