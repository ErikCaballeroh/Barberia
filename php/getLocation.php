<?php
// Incluir la conexión a la base de datos.
include 'conexion.php';

// Consulta para obtener el enlace de Google Maps y el número de WhatsApp
$sql = "SELECT googlemaps_link FROM barbers WHERE id_barber = 1";
$result = $conexion->query($sql);

// Verificar si la consulta trae resultados
if ($result->num_rows > 0) {
    // Obtener los datos
    $row = $result->fetch_assoc();
    // Devolver los datos en formato JSON
    echo json_encode($row);
} else {
    // Enviar un enlace genérico si no hay resultados
    echo json_encode(array('googlemaps_link' => 'https://www.google.com/maps'));
}

// Cerrar la conexión
$conexion->close();
