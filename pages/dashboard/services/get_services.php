<?php
// Conexión a la base de datos
include '../conecction.php'; // Asegúrate de que la ruta sea correcta

$sql = "
    SELECT s.id_service, s.name AS service, s.description, s.price, c.name AS category
    FROM services AS s
    LEFT JOIN categories AS c ON s.id_category = c.id_category
";

$result = $conn->query($sql);

// Crear un array para almacenar los datos
$services = [];
if ($result->num_rows > 0) {
    // Convertir los resultados a un array
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
    // Enviar los datos como JSON
    echo json_encode($services);
} else {
    // Si no se encuentran servicios, devolver un JSON vacío
    echo json_encode([]);
}

// Cerrar la conexión
$conn->close();
?>