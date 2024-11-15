<?php
header('Content-Type: application/json'); // Indica que la respuesta será en JSON

// Conexión a la base de datos (ajusta con tus credenciales)
include '../conecction.php'; // Asegúrate de que la ruta sea correcta

// Verificar si se ha enviado el nombre de la categoría
if (isset($_POST['name']) && !empty($_POST['name'])) {
    $category_name = $_POST['name']; // Nombre de la categoría

    // Preparar la consulta SQL para insertar la categoría
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param("s", $category_name); // "s" para string

    // Ejecutar la consulta y verificar si fue exitosa
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Categoría agregada correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agregar la categoría']);
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
} else {
    // Si no se recibió un nombre válido
    echo json_encode(['success' => false, 'message' => 'El nombre de la categoría es requerido']);
}

$conn->close();
?>