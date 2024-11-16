<?php
// Incluir la conexión a la base de datos
include 'connection.php';

// Consulta para obtener el enlace de Google Maps y el número de WhatsApp
$sql = "SELECT googlemaps_link, service_number FROM barbers WHERE id_barber = 1";
$result = $conn->query($sql);

// Verificar si la consulta trae resultados
if ($result->num_rows > 0) {
    // Obtener los datos
    $row = $result->fetch_assoc();
    // Devolver los datos en formato JSON
    echo json_encode($row);
} else {
    // Si no se encuentran resultados, devolver un error
    echo json_encode(array('error' => 'No se encontraron datos'));
}

// Cerrar la conexión
$conn->close();
?>