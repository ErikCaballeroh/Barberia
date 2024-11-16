<?php
// Conexión a la base de datos
include '../conecction.php'; // Asegúrate de que la conexión esté configurada correctamente

// Consulta para obtener las categorías
$sql = "SELECT id_category, name FROM categories";
$result = $conn->query($sql);

// Crear un array para almacenar las categorías
$categories = [];
if ($result->num_rows > 0) {
    // Convertir los resultados a un array
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Enviar las categorías como JSON
echo json_encode($categories);

// Cerrar la conexión
$conn->close();
?>
