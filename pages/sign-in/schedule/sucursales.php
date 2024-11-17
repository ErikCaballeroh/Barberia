<?php

include '../conecction.php';

$sql = "SELECT id_barber FROM barbers";

$sucursales = array();

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Recorrer los resultados y agregarlos al array
    while ($row = $result->fetch_assoc()) {
        $sucursales[] = $row;  // Agregar solo el ID al array
    }
}
// Devolver los datos en formato JSON
echo json_encode($sucursales);

// Cerrar la conexión
$conn->close();
