<?php

include '../conecction.php';  // Asegúrate de que la conexión a la base de datos esté configurada correctamente.

if ($conexion) {
    // Consulta SQL para obtener el número de WhatsApp de la base de datos
    $query = "SELECT service_number FROM barbers WHERE id_barber = 1";  // Asume que el id del registro que deseas es 1.
    $result = mysqli_query($conexion, $query);

    // Verifica si se obtuvo el número de WhatsApp
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $service_number = $row['service_number'];  // Almacena el número de WhatsApp en una variable
    } else {
        // Si no se encuentra el número, puedes asignar un valor por defecto
        $service_number = '1234567890';  // Número predeterminado
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conexion);
} else {
    // Si la conexión a la base de datos falla, maneja el error
    echo "Error de conexión a la base de datos.";
}
?>