<?php
header('Content-Type: application/json'); // Indica que la respuesta será en JSON

// Conexión a la base de datos (ajusta con tus credenciales)
include '../conecction.php'; // Asegúrate de que la ruta sea correcta

// Consulta para obtener las categorías
$result = $conn->query("SELECT id_category, name FROM categories");

// Verifica si hay resultados
if ($result->num_rows > 0) {
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    echo json_encode($categories); // Devuelve las categorías como JSON
} else {
    echo json_encode([]); // Si no hay categorías, devuelve un array vacío
}

$conn->close();
?>