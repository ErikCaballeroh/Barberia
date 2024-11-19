<?php
include '../conecction.php';  // Conexión a la base de datos.

if ($conn) {
    // Consulta SQL para obtener el número de WhatsApp
    $query = "SELECT service_number FROM barbers WHERE id_barber = 1";
    $result = mysqli_query($conn, $query);

    // Verifica si hay resultados
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $service_number = $row['service_number'] ?? '1234567890'; // Número predeterminado si el campo está vacío
    } else {
        $service_number = '1234567890'; // Número predeterminado si no hay resultados
    }

    // Devuelve el número en formato JSON
    echo json_encode(['service_number' => $service_number]);

    // Cierra la conexión
    mysqli_close($conn);
} else {
    // Manejo de error de conexión
    echo json_encode(['service_number' => '1234567890']); // Número predeterminado en caso de error
}
